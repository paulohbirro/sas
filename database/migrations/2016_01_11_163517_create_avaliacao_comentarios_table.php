<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAvaliacaoComentariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('avaliacao_comentarios', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('avaliacao_id')->unsigned();
            $table->foreign('avaliacao_id')->references('id')->on('avaliacaos')->onDelete('cascade')->onUpdate('cascade');

            $table->integer('avaliacao_ficha_id')->unsigned()->nullable();
            $table->foreign('avaliacao_ficha_id')->references('id')->on('avaliacao_fichas')->onDelete('cascade')->onUpdate('cascade');

            $table->string('comentario_path')->nullable();
            $table->string('comentario_transcrito')->nullable();
            $table->string('comentario_tags')->nullable();

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
        Schema::drop('avaliacao_comentarios');
    }
}
