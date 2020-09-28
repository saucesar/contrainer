<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DefaultTemplates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('default_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->json('template');
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('default_templates');
    }
}
