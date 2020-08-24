<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClubCompetitionTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('club_competition', function (Blueprint $table) {
            $table->unsignedBigInteger('club_id')->index();
            $table->unsignedBigInteger('competition_id')->index();

            $table->foreign('club_id')->references('id')->on('clubs');
            $table->foreign('competition_id')->references('id')->on('competitions');

            $table->unique(['club_id', 'competition_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('club_competition');
    }
}
