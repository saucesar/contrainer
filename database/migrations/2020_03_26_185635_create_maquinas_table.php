<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaquinasTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('maquinas', function (Blueprint $table) {
            $table->id();
            $table->integer('cpu_utilizavel')->default(25); // percentual(%)
            $table->integer('ram_utilizavel'); // em MB
            $table->string('hashcode')->unique();
            $table->boolean('disponivel')->default(false);
            $table->bigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->ipAddress('ip')->nullable();
            -$table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('maquinas');
    }
}
