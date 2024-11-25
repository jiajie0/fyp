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
            $table->string('PlayerID')->primary();
            $table->string('PlayerName');
            $table->string('PlayerPW');
            $table->integer('TotalRatingNumber')->default(0);
            $table->integer('TotalPlayTime')->default(0);
            $table->integer('TotalLikeReceived')->default(0);
            $table->integer('PlayerScore')->default(0);
            $table->string('PlayerEmail')->unique();
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
