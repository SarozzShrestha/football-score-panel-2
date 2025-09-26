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
        Schema::create('game_scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id')->constrained('games')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('team_id')->constrained('teams')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('scored_by')->constrained('players')->onDelete('cascade')->onUpdate('cascade');
            $table->string('scorer_name')->nullable();
            $table->foreignId('assist_by')->nullable()->constrained('players')->onDelete('cascade')->onUpdate('cascade');
            $table->string('assist_name')->nullable();
            $table->enum('is_penalty', ['0', '1'])->default('0');
            $table->enum('is_own_goal', ['0', '1'])->default('0');
            $table->string('scored_at')->default('00:00:00');
            $table->string('card_issued_time')->default('00:00:00');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_scores');
    }
};
