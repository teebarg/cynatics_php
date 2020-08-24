<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookmakerGameTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookmaker_game', function (Blueprint $table) {
            $table->unsignedBigInteger('game_id')->index();
            $table->unsignedBigInteger('bookmaker_id')->index();
            $table->string('booking_number');

            $table->foreign('game_id')->references('id')->on('games');
            $table->foreign('bookmaker_id')->references('id')->on('bookmakers');

            $table->unique(['game_id', 'bookmaker_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookmaker_game');
    }
}
