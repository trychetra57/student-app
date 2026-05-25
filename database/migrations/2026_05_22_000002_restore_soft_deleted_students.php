<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Restore soft-deleted seed students.
     *
     * 10 students from the initial seeder were accidentally bulk-deleted
     * (deleted_at set on 2026-05-15). Since they are seeded test data with
     * valid statuses (active/inactive/graduated), restore them by clearing
     * the deleted_at timestamp.
     */
    public function up(): void
    {
        // Restore the 10 accidentally soft-deleted seeded students (IDs 1-10)
        DB::table('students')
            ->whereNotNull('deleted_at')
            ->whereIn('id', [1, 2, 3, 4, 5, 6, 7, 8, 9, 10])
            ->update(['deleted_at' => null]);
    }

    public function down(): void
    {
        // Re-apply the soft delete to revert
        DB::table('students')
            ->whereIn('id', [1, 2, 3, 4, 5, 6, 7, 8, 9, 10])
            ->update(['deleted_at' => '2026-05-15 01:34:49']);
    }
};
