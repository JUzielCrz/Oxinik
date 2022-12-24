<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTanquesTable extends Migration
{

    public function up()
    {
        Schema::create('tanques', function (Blueprint $table) {
            $table->id();
            $table->string('num_serie')->unique();
            $table->string('ph');
            $table->string('capacidad');
            $table->string('material');
            $table->string('fabricante');
            $table->foreignId('tipo_gas')->references('id')->on('catalogo_gases')->onDelete('restrict');
            $table->string('tipo_tanque');
            $table->string('estatus');
            // $table->foreignId('user_id')->references('id')->on('users')->onDelete('restrict');

            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tanques');
    }
}
