<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOddsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('odds', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('is_active')->default(1);
            $table->unsignedBigInteger('market_id')->index();
            $table->foreign('market_id')->references('id')->on('markets');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('odds');
    }
}
