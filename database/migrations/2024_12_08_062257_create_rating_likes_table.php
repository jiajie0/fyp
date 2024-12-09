<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRatingLikesTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('rating_likes')) {
            Schema::create('rating_likes', function (Blueprint $table) {
                $table->id();
                $table->string('PlayerID');
                $table->string('RatingID');
                $table->timestamps();

                $table->unique(['PlayerID', 'RatingID']); // 确保同一个玩家对同一个评分只能点赞一次
                $table->foreign('PlayerID')->references('PlayerID')->on('players')->onDelete('cascade');
                $table->foreign('RatingID')->references('RatingID')->on('ratings')->onDelete('cascade');
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('rating_likes');
    }
}
