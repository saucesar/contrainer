<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsoleOutsTable extends Migration
{

    public function up()
    {
        Schema::create('console_outs', function (Blueprint $table) {
            $table->id();
            $table->string('containerDockerId', 128);
            $table->string('command');
            $table->foreign('containerDockerId')->references('container_docker_id')->on('instancia_containers');
            $table->string('out');
            $table->boolean('status');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('console_outs');
    }
}
