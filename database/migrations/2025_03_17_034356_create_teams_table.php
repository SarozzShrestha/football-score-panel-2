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
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('abb', 10);
            $table->string('logo', 255);
            $table->string('home_color_top');
            $table->string('home_color_down');
            $table->string('away_color_top');
            $table->string('away_color_down');
            $table->enum('status', ['0', '1'])->default('1');
            $table->foreignId('manager_id')->constrained('staffs')->cascadeOnDelete()->cascadeOnUpdate();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teams');
    }
};
