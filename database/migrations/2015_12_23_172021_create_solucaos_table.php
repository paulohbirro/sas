<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSolucaosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solucaos', function (Blueprint $table) {
            $table->increments('id');

            $table->string('nome')->unique();

            $table->integer('gestor_id')->unsigned();
            $table->foreign('gestor_id')->references('id')->on('gestors');

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
        Schema::drop('solucaos');
    }
}
