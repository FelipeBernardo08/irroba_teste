<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThirdPlacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('third_places', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fk_team');
            $table->unsignedBigInteger('fk_championship');
            $table->foreign('fk_team')->references('id')->on('teams');
            $table->foreign('fk_championship')->references('id')->on('championships');
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
        Schema::dropIfExists('third_places');
    }
}
