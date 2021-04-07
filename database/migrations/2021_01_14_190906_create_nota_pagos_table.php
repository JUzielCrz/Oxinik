<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotaPagosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nota_pagos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('nota_id');
            $table->foreign('nota_id')->references('id')
                ->on('notas')
                ->onDelete('restrict');
            $table->float('monto_pago');
            $table->string('metodo_pago');
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
        Schema::dropIfExists('nota_pagos');
    }
}
