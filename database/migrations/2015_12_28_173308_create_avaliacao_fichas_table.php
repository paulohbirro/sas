<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAvaliacaoFichasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('avaliacao_fichas', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('avaliacao_id')->unsigned();
            $table->foreign('avaliacao_id')->references('id')->on('avaliacaos')->onDelete('cascade')->onUpdate('cascade');

            $table->string('image_path');

            $table->enum('status', ['PROCESSANDO', 'PROCESSADO'])->default('PROCESSANDO');

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
        Schema::drop('avaliacao_fichas');
    }
}
