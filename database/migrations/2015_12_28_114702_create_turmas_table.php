<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTurmasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('turmas', function (Blueprint $table) {
            $table->increments('id');

            $table->string('codigo')->unique();
            $table->date('inicio');
            $table->date('fim');
            $table->integer('vagas');
            $table->integer('participantes');
            $table->string('local_execucao');
            $table->string('endereco_execucao');

            $table->enum('status', ['IMPRESSO', 'ENVIADO', 'PUBLICADO', 'SUSPENSO'])->default('IMPRESSO');
            $table->text('descricao')->nullable();

            $table->integer('consultor_id')->unsigned();
            $table->foreign('consultor_id')->references('id')->on('consultors');

            $table->integer('solucao_id')->unsigned();
            $table->foreign('solucao_id')->references('id')->on('solucaos');

            $table->integer('municipio_id')->unsigned();
            $table->foreign('municipio_id')->references('id')->on('municipios');

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
        Schema::drop('turmas');
    }
}
