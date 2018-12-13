<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConsultorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consultors', function (Blueprint $table) {
            $table->increments('id');

            $table->string('nome');
            $table->string('cpf')->nullable()->unique();
            $table->string('user_ad')->nullable()->unique();
            $table->string('tipo');
            $table->string('senha')->nullable();
            $table->string('email')->nullable()->unique();
            $table->string('chave_recuperacao')->nullable();

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
        Schema::drop('consultors');
    }
}
