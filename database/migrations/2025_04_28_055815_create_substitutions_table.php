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
        Schema::create('substitutions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id')->constrained('games')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('team_id')->constrained('teams')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('subbed_by')->comment('one who enters the field')->constrained('players')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('subbed_for')->comment('one who leaves the field')->constrained('players')->onDelete('cascade')->onUpdate('cascade');
            $table->enum('reason',['0', '1', '2'])->default('0')->comment('0: tactical substitution, 1: injury substitution, 2: red card');
            $table->string('subbed_at');
            $table->integer('extra_minutes')->comment('substitution in extra time')->nullable()->default(0);
            $table->timestamps();
            $table->unique(['game_id', 'subbed_for'], 'unique_player_subbed_out_per_game');
            $table->unique(['game_id', 'subbed_by'], 'unique_player_subbed_in_per_game');
        });

        Schema::table('game_team_players', function (Blueprint $table) {
            $table->enum('latest_status', ['0', '1', '2', '3'])->default('0')->comment('0: not selected, 1:  playing XI, 2: is_substitute, 3: subbed')->after('status')->index();
            $table->dropColumn('subbed_at');
            $table->dropColumn('subbed_for');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('substitutions');

        Schema::table('game_team_players', function (Blueprint $table) {
            $table->dropIndex('game_team_players_latest_status_index');
            $table->dropColumn('latest_status');
            $table->string('subbed_at')->nullable()->after('status');
            $table->string('subbed_for')->nullable()->after('subbed_at');
        });
    }
};
