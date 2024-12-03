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
            $table->string('GameID')->primary();

            $table->string('DeveloperID');
            $table->foreign('DeveloperID')->references('DeveloperID')->on('developers')->onDelete('cascade');

            $table->string('GameName');
            $table->text('GameDescription');
            $table->string('GameCategory');
            $table->date('GameUploadDate')->default(DB::raw('CURRENT_DATE'));
            $table->decimal('RatingScore', 4, 2)->default(0); // 将 float 替换为 decimal，以提高精度
            $table->decimal('GamePrice', 8, 2)->default(0);
            $table->integer('GameAchievementsCount')->default(0);
            $table->string('GameAvatar')->nullable();
            $table->json('GameReferenceImages')->nullable(); // 用于存储多个图片的路径
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
