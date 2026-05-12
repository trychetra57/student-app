<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class BackupController extends Controller
{
    public function index()
    {
        $backups = collect(Storage::disk('local')->files('backups'))
            ->filter(function ($file) {
                return str_starts_with($file, 'backups/backup_');
            })
            ->map(function ($file) {
                return [
                    'filename' => basename($file),
                    'path' => $file,
                    'size' => Storage::disk('local')->size($file),
                    'created_at' => Storage::disk('local')->lastModified($file),
                ];
            })
            ->sortByDesc('created_at')
            ->values();

        return view('backup.index', compact('backups'));
    }

    public function create(Request $request)
    {
        $table = $request->input('table');

        try {
            if ($table) {
                Artisan::call('db:backup', ['--table' => $table]);
            } else {
                Artisan::call('db:backup');
            }

            return redirect()->back()->with('success', 'Database backup created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to create backup: ' . $e->getMessage());
        }
    }

    public function download($filename)
    {
        $path = "backups/{$filename}";

        if (!Storage::disk('local')->exists($path)) {
            abort(404);
        }

        return Storage::disk('local')->download($path);
    }

    public function delete($filename)
    {
        $path = "backups/{$filename}";

        if (!Storage::disk('local')->exists($path)) {
            return redirect()->back()->with('error', 'Backup file not found.');
        }

        Storage::disk('local')->delete($path);

        return redirect()->back()->with('success', 'Backup deleted successfully.');
    }
}