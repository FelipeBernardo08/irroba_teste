<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlayThirdPlacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('play_third_places', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fk_team_1');
            $table->unsignedBigInteger('fk_team_2');
            $table->unsignedBigInteger('fk_championship');
            $table->integer('goals_team_1');
            $table->integer('goals_team_2');
            $table->foreign('fk_team_1')->references('id')->on('teams');
            $table->foreign('fk_team_2')->references('id')->on('teams');
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
        Schema::dropIfExists('play_third_places');
    }
}
