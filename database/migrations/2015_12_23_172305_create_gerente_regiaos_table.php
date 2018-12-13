<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGerenteRegiaosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gerente_regiaos', function (Blueprint $table) {
            $table->increments('id');

            $table->string('nome');
            $table->string('user_ad');

            $table->integer('regiao_id')->unsigned();
            $table->foreign('regiao_id')->references('id')->on('regiaos');


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
        Schema::drop('gerente_regiaos');
    }
}
