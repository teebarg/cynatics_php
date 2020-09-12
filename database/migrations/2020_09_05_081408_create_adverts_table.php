<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adverts', function (Blueprint $table) {
            $table->id();
            $table->text('message')->nullable();
            $table->string('url');
            $table->enum('target', ['_self', '_blank'])->default('_self');
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('ad_slot_id')->index();
            $table->foreign('ad_slot_id')->references('id')->on('ad_slots');
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
        Schema::dropIfExists('adverts');
    }
}
