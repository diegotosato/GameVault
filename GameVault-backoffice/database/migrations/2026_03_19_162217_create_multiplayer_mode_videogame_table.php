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
        Schema::create('multiplayer_mode_videogame', function (Blueprint $table) {
            $table->id();

            $table->foreignId('multiplayer_mode_id')->constrained()->cascadeOnDelete();
            $table->foreignId('videogame_id')->constrained()->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('multiplayer_mode_videogame');
    }
};
