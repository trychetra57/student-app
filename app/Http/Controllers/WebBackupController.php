<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebBackupController extends Controller
{
    public function index()
    {
        if (!auth()->user()->isSuperAdmin()) abort(403, 'Unauthorized access');

        $backupPath = database_path();
        $backups    = [];

        // List sqlite backups if they exist
        if (file_exists($backupPath)) {
            $files = glob($backupPath . '/backups/*.sqlite');
            if ($files) {
                foreach ($files as $file) {
                    $backups[] = [
                        'filename'   => basename($file),
                        'size'       => filesize($file),
                        'created_at' => filemtime($file),
                        'path'       => $file,
                    ];
                }
                $backups = array_reverse($backups);
            }
        }

        return view('backup.index', ['backups' => collect($backups)]);
    }

    public function create()
    {
        if (!auth()->user()->isSuperAdmin()) abort(403, 'Unauthorized access');

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

    public function download($filename)
    {
        if (!auth()->user()->isSuperAdmin()) abort(403, 'Unauthorized access');

        $file = database_path('backups' . DIRECTORY_SEPARATOR . $filename);
        if (file_exists($file)) {
            return response()->download($file);
        }
        return redirect()->route('backup.index')->with('error', 'Backup file not found.');
    }

    public function destroy($filename)
    {
        if (!auth()->user()->isSuperAdmin()) abort(403, 'Unauthorized access');

        $file = database_path('backups' . DIRECTORY_SEPARATOR . $filename);
        if (file_exists($file)) {
            unlink($file);
            return redirect()->route('backup.index')->with('success', 'Backup deleted successfully.');
        }
        return redirect()->route('backup.index')->with('error', 'Backup file not found.');
    }
}
