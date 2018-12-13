<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMicroRegiaosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('micro_regiaos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome')->unique();

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
        Schema::drop('micro_regiaos');
    }
}
