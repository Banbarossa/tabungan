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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('absen_id')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('account_number')->nullable();
            $table->string('name');
            $table->string('nisn')->nullable();
            $table->string('nis')->nullable();
            $table->string('nama_ibu')->nullable();
            $table->boolean('status')->default(true);
            $table->text('photo')->nullable();
            $table->bigInteger('saldo')->nullable()->default(0);
            $table->bigInteger('daily_limit')->nullable()->default(15000);
            $table->boolean('send_notification')->default(false);
            $table->enum('notification_target',['whatsapp','email'])->nullable();
            $table->string('notification_account')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
