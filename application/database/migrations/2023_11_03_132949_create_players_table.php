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
            $table->string('id', 50)->unique();
            $table->string('game_id', 50)->comment('ゲームID')->references('id')->on('games')->cascadeOnDelete();
            $table->string('name')->comment('ユーザー名');
            $table->integer('turn')->comment('プレイ順');
            $table->integer('distance_to_destination')->comment('目的地までの距離(単位km)');
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
