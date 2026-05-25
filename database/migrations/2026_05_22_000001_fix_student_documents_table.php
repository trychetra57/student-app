<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Fix student_documents table:
     * 1. Rename 'document_name' column to 'file_name'
     * 2. Add missing 'document_type' column
     *
     * SQLite doesn't support ALTER TABLE RENAME COLUMN in older versions,
     * so we recreate the table.
     */
    public function up(): void
    {
        // Step 1: Backup existing data
        $existing = DB::table('student_documents')->get();

        // Step 2: Drop and recreate with correct schema
        Schema::drop('student_documents');

        Schema::create('student_documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->string('file_name');            // was document_name
            $table->string('file_path');
            $table->string('file_type')->nullable();
            $table->string('document_type')->nullable(); // new column
            $table->unsignedBigInteger('uploaded_by')->nullable();
            $table->timestamps();

            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('uploaded_by')->references('id')->on('users')->onDelete('set null');
        });

        // Step 3: Restore data, mapping document_name -> file_name
        foreach ($existing as $row) {
            DB::table('student_documents')->insert([
                'id'            => $row->id,
                'student_id'    => $row->student_id,
                'file_name'     => $row->document_name, // rename mapping
                'file_path'     => $row->file_path,
                'file_type'     => $row->file_type,
                'document_type' => null,              // no existing data for this
                'uploaded_by'   => $row->uploaded_by,
                'created_at'    => $row->created_at,
                'updated_at'    => $row->updated_at,
            ]);
        }
    }

    public function down(): void
    {
        // Revert: rename file_name back to document_name, drop document_type
        $existing = DB::table('student_documents')->get();

        Schema::drop('student_documents');

        Schema::create('student_documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->string('document_name');
            $table->string('file_path');
            $table->string('file_type')->nullable();
            $table->unsignedBigInteger('uploaded_by')->nullable();
            $table->timestamps();

            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('uploaded_by')->references('id')->on('users')->onDelete('set null');
        });

        foreach ($existing as $row) {
            DB::table('student_documents')->insert([
                'id'            => $row->id,
                'student_id'    => $row->student_id,
                'document_name' => $row->file_name,
                'file_path'     => $row->file_path,
                'file_type'     => $row->file_type,
                'uploaded_by'   => $row->uploaded_by,
                'created_at'    => $row->created_at,
                'updated_at'    => $row->updated_at,
            ]);
        }
    }
};
