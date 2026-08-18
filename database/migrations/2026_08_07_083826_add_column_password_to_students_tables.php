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
            $table->string('password')->nullable()->after('nisn');
            $table->boolean('is_default_password')->default(false);
            $table->rememberToken();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            if (Schema::hasColumn('students', 'password')) {
                $table->dropColumn('password');
            }

            if (Schema::hasColumn('students', 'remember_token')) {
                $table->dropRememberToken();
            }
            if (Schema::hasColumn('students', 'is_default_password')) {
                $table->dropColumn('is_default_password');
            }
        });
    }
};
