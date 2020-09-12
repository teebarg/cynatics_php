<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGameItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_items', function (Blueprint $table) {
            $table->id();
            $table->date('match_date');
            $table->morphs('home');
            $table->morphs('away');
            $table->string('result')->default('0-0');
            $table->unsignedBigInteger('game_id')->index();
            $table->unsignedBigInteger('competition_id')->index();
            $table->unsignedBigInteger('odd_id')->index();
            $table->unsignedBigInteger('game_status_id')->default(1)->index();
            $table->float('bookie_odd')->default(0);
            $table->timestamps();

            $table->foreign('game_id')->references('id')->on('games');
            $table->foreign('competition_id')->references('id')->on('competitions');
            $table->foreign('odd_id')->references('id')->on('odds');
            $table->foreign('game_status_id')->references('id')->on('game_statuses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('game_items');
    }
}
