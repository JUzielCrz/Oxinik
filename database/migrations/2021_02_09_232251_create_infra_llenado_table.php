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
            $table->integer('cantidad_salida');
            $table->integer('cantidad_entrada')->nullable();
            $table->integer('cantidad_diferencia')->default(0);
            $table->boolean('pendiente')->default(true)->nullable();
            $table->string('observaciones')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
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
