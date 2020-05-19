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
            $table->string('docker_id', 128);
            $table->string('command');
            $table->foreign('docker_id')->references('docker_id')->on('instancia_containers')->onDelete('cascade');
            $table->string('out', 128000);
            $table->boolean('status');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('console_outs');
    }
}
