<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string('game_number');
            $table->date('game_date');
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('game_status_id')->default(1)->index();
            $table->unsignedBigInteger('market_id')->index();
            $table->boolean('settled')->default(0);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('game_status_id')->references('id')->on('game_statuses');
            $table->foreign('market_id')->references('id')->on('markets');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('games');
    }
}
