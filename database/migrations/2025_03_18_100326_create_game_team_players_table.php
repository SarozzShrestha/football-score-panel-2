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
        Schema::create('game_team_players', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id')->constrained('games')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('team_id')->constrained('teams')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('player_id')->constrained('players')->onDelete('cascade')->onUpdate('cascade');
            $table->string('player_name');
            $table->string('jersey_no');
            $table->enum('status', ['0', '1', '2', '3'])->default('0')->comment('0: not selected, 1:  playing XI, 2: is_substitute, 3: subbed');
            $table->string('subbed_at');
            $table->string('subbed_for');
            $table->enum('has_yellow_carded', ['0', '1'])->default('0');
            $table->enum('has_red_carded', ['0', '1'])->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_team_players');
    }
};
