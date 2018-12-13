<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGestorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gestors', function (Blueprint $table) {
            $table->increments('id');

            $table->string('nome');
            $table->string('user_ad')->unique();

            $table->integer('gerente_gestor_id')->nullable()->unsigned();
            $table->foreign('gerente_gestor_id')->references('id')->on('gerente_gestors');

            $table->integer('unidade_id')->nullable()->unsigned();
            $table->foreign('unidade_id')->references('id')->on('unidades');

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
        Schema::drop('gestors');
    }
}
