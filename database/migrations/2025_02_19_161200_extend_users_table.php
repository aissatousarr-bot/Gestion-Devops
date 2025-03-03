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
        Schema::table('users', function (Blueprint $table) {
            $table->string('first_name')->after('id');
            $table->string('last_name')->after('first_name');
            $table->string('phone_number')->nullable()->after('email');
            $table->text('address')->nullable();
            $table->enum('role', ['admin', 'teacher', 'student', 'parent'])->default('student');
            $table->string('avatar')->nullable();
            $table->enum('status', ['active', 'inactive', 'suspended', 'graduated'])->default('active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'first_name',
                'last_name',
                'phone_number',
                'address',
                'role',
                'avatar',
                'status'
            ]);
        });
    }
};
