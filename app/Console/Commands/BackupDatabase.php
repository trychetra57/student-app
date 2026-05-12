<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class BackupDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:backup {--table= : Specific table to backup}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a backup of the database or specific table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $table = $this->option('table');
        $timestamp = Carbon::now()->format('Y-m-d_H-i-s');

        if ($table) {
            $this->info("Backing up table: {$table}");
            $filename = "backup_{$table}_{$timestamp}.sql";
            $this->backupTable($table, $filename);
        } else {
            $this->info('Backing up entire database');
            $filename = "backup_full_{$timestamp}.sql";
            $this->backupFullDatabase($filename);
        }

        $this->info("Backup completed: {$filename}");
        return Command::SUCCESS;
    }

    private function backupTable($table, $filename)
    {
        // Get table structure
        $createTable = DB::select("SHOW CREATE TABLE {$table}");
        $structure = $createTable[0]->{'Create Table'} . ";\n\n";

        // Get table data
        $data = DB::table($table)->get();
        $inserts = '';

        if ($data->count() > 0) {
            $columns = array_keys((array) $data->first());
            $columnList = '`' . implode('`, `', $columns) . '`';

            foreach ($data as $row) {
                $values = array_map(function($value) {
                    return $value === null ? 'NULL' : "'" . addslashes($value) . "'";
                }, (array) $row);
                $valueList = implode(', ', $values);
                $inserts .= "INSERT INTO `{$table}` ({$columnList}) VALUES ({$valueList});\n";
            }
        }

        $content = $structure . $inserts;
        Storage::disk('local')->put("backups/{$filename}", $content);
    }

    private function backupFullDatabase($filename)
    {
        $tables = DB::select('SHOW TABLES');
        $database = env('DB_DATABASE');
        $content = "-- Database backup for {$database}\n";
        $content .= "-- Generated on " . Carbon::now() . "\n\n";

        foreach ($tables as $table) {
            $tableName = $table->{'Tables_in_' . $database};
            $this->info("Backing up table: {$tableName}");

            // Get table structure
            $createTable = DB::select("SHOW CREATE TABLE {$tableName}");
            $content .= $createTable[0]->{'Create Table'} . ";\n\n";

            // Get table data
            $data = DB::table($tableName)->get();

            if ($data->count() > 0) {
                $columns = array_keys((array) $data->first());
                $columnList = '`' . implode('`, `', $columns) . '`';

                foreach ($data as $row) {
                    $values = array_map(function($value) {
                        return $value === null ? 'NULL' : "'" . addslashes($value) . "'";
                    }, (array) $row);
                    $valueList = implode(', ', $values);
                    $content .= "INSERT INTO `{$tableName}` ({$columnList}) VALUES ({$valueList});\n";
                }
            }
            $content .= "\n";
        }

        Storage::disk('local')->put("backups/{$filename}", $content);
    }
}
