<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAvaliacaoRespostasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('avaliacao_respostas', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('avaliacao_ficha_id')->unsigned();
            $table->foreign('avaliacao_ficha_id')->references('id')->on('avaliacao_fichas')->onDelete('cascade')->onUpdate('cascade');

            $table->integer('avaliacao_pergunta_id')->unsigned();
            $table->foreign('avaliacao_pergunta_id')->references('id')->on('avaliacao_perguntas');

            $table->integer('resposta')->nullable();

            $table->unique(['avaliacao_ficha_id', 'avaliacao_pergunta_id'], 'unique01');

            $table->boolean('manual')->nullable();

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
        Schema::drop('avaliacao_respostas');
    }
}
