<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAvaliacaosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('avaliacaos', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('turma_id')->unsigned()->unique();
            $table->foreign('turma_id')->references('id')->on('turmas');

            $table->integer('quantidade')->default(0);
            $table->integer('digitalizado')->default(0);

            $table->integer('detratores')->default(0);
            $table->integer('passivos')->default(0);
            $table->integer('promotores')->default(0);

            $table->float('nps_meta')->default(80);
            $table->float('nota_consultor_meta')->default(8);
            $table->float('nota_metodologia_meta')->default(8);
            $table->float('nota_atendimento_meta')->default(8);

            $table->float('nps')->default(0);
            $table->float('nota_consultor')->default(0);
            $table->float('nota_consultor_dominio')->default(0);
            $table->float('nota_consultor_clareza')->default(0);
            $table->float('nota_consultor_recursos')->default(0);
            $table->float('nota_consultor_exemplos')->default(0);
            $table->float('nota_metodologia')->default(0);
            $table->float('nota_metodologia_duracao')->default(0);
            $table->float('nota_metodologia_material')->default(0);
            $table->float('nota_atendimento')->default(0);
            $table->float('nota_atendimento_prestado')->default(0);
            $table->float('nota_atendimento_ambiente')->default(0);

            $table->enum('status', ['PROCESSANDO', 'AUDITORIA', 'PROCESSADO', 'ERRO'])->default('PROCESSANDO');

            $table->string('erro')->nullable();

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
        Schema::drop('avaliacaos');
    }
}
