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
        Schema::create('settingwhatsapps', function (Blueprint $table) {
            $table->id();
            $table->boolean('send_when_setor')->default(true);
            $table->boolean('send_when_tarik')->default(true);
            $table->text('template_setor')->nullable();
            $table->text('template_tarik')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settingwhatsapps');
    }
};
