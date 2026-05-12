<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->string('grade')->nullable()->after('phone')->comment('Student grade or class level');
            $table->text('address')->nullable()->after('grade')->comment('Student address');
            $table->date('date_of_birth')->nullable()->after('address')->comment('Student date of birth');
            $table->string('guardian_name')->nullable()->after('date_of_birth')->comment('Guardian name');
            $table->string('guardian_phone')->nullable()->after('guardian_name')->comment('Guardian phone number');
            $table->enum('status', ['active', 'inactive', 'graduated'])->default('active')->after('guardian_phone')->comment('Student status');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn(['grade', 'address', 'date_of_birth', 'guardian_name', 'guardian_phone', 'status']);
            $table->dropSoftDeletes();
        });
    }
};
