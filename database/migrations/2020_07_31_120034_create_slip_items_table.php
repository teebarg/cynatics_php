<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlipItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slip_items', function (Blueprint $table) {
            $table->id();
            $table->date('match_date');
            $table->morphs('home');
            $table->morphs('away');
            $table->unsignedBigInteger('slip_id')->index();
            $table->unsignedBigInteger('competition_id')->index();
            $table->unsignedBigInteger('odd_id')->index();
            $table->timestamps();

            $table->foreign('slip_id')->references('id')->on('slips');
            $table->foreign('competition_id')->references('id')->on('competitions');
            $table->foreign('odd_id')->references('id')->on('odds');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('slip_items');
    }
}
