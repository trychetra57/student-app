<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebBackupController extends Controller
{
    public function index()
    {
        $backupPath = database_path();
        $backups    = [];

        // List sqlite backups if they exist
        if (file_exists($backupPath)) {
            $files = glob($backupPath . '/backups/*.sqlite');
            if ($files) {
                foreach ($files as $file) {
                    $backups[] = [
                        'name'    => basename($file),
                        'size'    => number_format(filesize($file) / 1024, 2) . ' KB',
                        'created' => date('Y-m-d H:i:s', filemtime($file)),
                        'path'    => $file,
                    ];
                }
                $backups = array_reverse($backups);
            }
        }

        return view('backup.index', compact('backups'));
    }

    public function create()
    {
        $source    = database_path('database.sqlite');
        $backupDir = database_path('backups');

        if (!is_dir($backupDir)) {
            mkdir($backupDir, 0755, true);
        }

        $filename   = 'backup_' . date('Y-m-d_H-i-s') . '.sqlite';
        $dest       = $backupDir . DIRECTORY_SEPARATOR . $filename;

        if (file_exists($source)) {
            copy($source, $dest);
            return redirect()->route('backup.index')->with('success', "Backup created: {$filename}");
        }

        return redirect()->route('backup.index')->with('error', 'Database file not found.');
    }
}
