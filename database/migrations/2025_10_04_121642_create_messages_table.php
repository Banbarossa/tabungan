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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('message_id')->nullable();
            $table->string('source')->default('tabsis');
            $table->string('device')->nullable();
            $table->string('target')->nullable();
            $table->text('message')->nullable();
            $table->string('stateid')->nullable();
            $table->string('status')->nullable();
            $table->string('state')->nullable();
            $table->string('user_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
