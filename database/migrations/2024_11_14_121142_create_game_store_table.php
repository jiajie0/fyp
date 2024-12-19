<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('game_store', function (Blueprint $table) {
            $table->string('PlayerID');
            $table->string('GameID');

            $table->foreign('PlayerID')->references('PlayerID')->on('players')->onDelete('cascade');
            $table->foreign('GameID')->references('GameID')->on('games')->onDelete('cascade');

            $table->integer('GameAchievementsCount')->default(0);
            $table->integer('PlayerAchievementsCount')->default(0);
            $table->integer('TotalPlayTime')->default(0);
            $table->primary(['PlayerID', 'GameID']);
            $table->boolean('Has50PercentScore')->default(0);
            $table->boolean('Has80PercentScore')->default(0);
            $table->json('GameCategory');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_store');
    }
};
