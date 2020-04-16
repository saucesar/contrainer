<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAtividadeMaquinasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('atividade_maquinas', function (Blueprint $table) {
            $table->id();
            $table->string('hashcode_maquina');
            $table->foreign('hashcode_maquina')->references('hashcode')->on('maquinas');
            $table->dateTime('dataHoraInicio');
            $table->dateTime('dataHoraFim')->nullable();
            $table->dateTime('last_notification')->nullable();
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
        Schema::dropIfExists('atividade_maquinas');
    }
}
