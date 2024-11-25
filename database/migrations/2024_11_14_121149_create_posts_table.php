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
        Schema::create('posts', function (Blueprint $table) {
            $table->string('PostID')->primary();

            $table->string('PlayerID');
            $table->foreign('PlayerID')->references('PlayerID')->on('players')->onDelete('cascade');

            $table->text('PostText');
            $table->string('PostImageURL')->nullable();
            $table->string('PostVideoURL')->nullable();
            $table->timestamp('PostTime');
            $table->integer('TotalLikeReceived')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
