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
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('postal_code', 7)->comment('郵便番号');
            $table->string('prefecture')->comment('都道府県名');
            $table->string('city')->comment('市区町村名');
            $table->string('town')->comment('区画名');
            $table->text('city_kana')->comment('市区町村名ふりがな');
            $table->text('town_kana')->comment('区画名ふりがな');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
