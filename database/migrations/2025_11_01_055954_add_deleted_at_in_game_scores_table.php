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
        Schema::table('game_scores', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('game_card_logs', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('substitutions', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('game_scores', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('game_card_logs', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('substitutions', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
