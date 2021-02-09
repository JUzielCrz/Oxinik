<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInfraLlenadoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('infra_llenado', function (Blueprint $table) {
            $table->id();
            $table->string('num_serie');
            $table->foreign('num_serie')->references('num_serie')
                ->on('tanques')
                ->onDelete('restrict');
            $table->fecha();
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
        Schema::dropIfExists('infra_llenado');
    }
}
