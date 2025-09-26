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
        Schema::create('game_card_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id')->constrained('games')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('team_id')->constrained('teams')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('player')->constrained('players')->onDelete('cascade')->onUpdate('cascade');
            $table->string('player_name')->nullable();
            $table->enum('is_yellow_card', ['0', '1'])->default('0');
            $table->enum('is_red_card', ['0', '1'])->default('0');
            $table->string('fouled_at')->default('00:00:00');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_card_logs');
    }
};
