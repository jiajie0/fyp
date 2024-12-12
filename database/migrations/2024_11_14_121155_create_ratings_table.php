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
        Schema::create('ratings', function (Blueprint $table) {
            $table->string('RatingID')->primary();

            $table->string('PlayerID');
            $table->foreign('PlayerID')->references('PlayerID')->on('players')->onDelete('cascade');

            $table->string('GameID');
            $table->foreign('GameID')->references('GameID')->on('games')->onDelete('cascade');

            $table->boolean('RatingMark');  // 用于存储 true 或 false (recommended,not_recommended)
            $table->integer('RatingWeight')->default(0); // 动态权重(0,1,3,10,30)
            $table->text('RatingText')->nullable();
            $table->string('RatingImageURL')->nullable();
            $table->string('RatingVideoURL')->nullable();
            $table->timestamp('RatingTime');
            $table->integer('TotalLikeReceived')->default(0);
            $table->integer('PlayerLevel')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
