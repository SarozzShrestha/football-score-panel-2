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
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->nullable();
            $table->foreignId('team_a_id')->constrained('teams')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('team_a')->nullable();
            $table->string('team_a_abb')->nullable();
            $table->integer('team_a_score')->default(0);
            $table->foreignId('team_b_id')->constrained('teams')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('team_b')->nullable();
            $table->string('team_b_abb')->nullable();
            $table->integer('team_b_score')->default(0);
            $table->string('venue', 255);
            $table->string('weather', 255);
            $table->enum('status', ['0', '1', '2', '3'])->default('0')->comment('0: Yet to play, 1: Match ongoing, 2: match completed, 3: match abandoned');
            $table->dateTime('date_time');
            $table->enum('winner', ['0', '1', '2', '3'])->default('0')->comment('0: No result, 1: Team A, 2: Team B, 3: Match Drawn');
            $table->foreignId('referee')->constrained('staffs')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('first_linesmen')->constrained('staffs')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('second_linesmen')->constrained('staffs')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('official')->constrained('staffs')->cascadeOnDelete()->cascadeOnUpdate();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
