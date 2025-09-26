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
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('role', ['GK', 'DEF', 'MID', 'FWD']);
            $table->string('position');
            $table->string('image');
            $table->string('nationality');
            $table->string('height');
            $table->enum('height_unit', ['inches', 'm', 'cm'])->default('m');
            $table->string('weight');
            $table->enum('weight_unit', ['kg', 'lbs'])->default('kg');
            $table->string('age');
            $table->enum('status', ['0', '1'])->default('1');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};
