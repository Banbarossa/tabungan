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
        Schema::create('topup_requests', function (Blueprint $table) {
            $table->id();
            $table->string('reference_number')->unique();
            $table->string('type');
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->decimal('jumlah', 12, 2)->default(0);
            $table->string('file_path');
            $table->text('keterangan')->nullable();
            $table->dateTime('tanggal_topup');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->foreignId('verification_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('verification_at')->nullable();
            $table->text('catatan_admin')->nullable();
            $table->index(['student_id', 'type','status']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('topup_requests');
    }
};
