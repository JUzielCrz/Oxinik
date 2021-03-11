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
            $table->unsignedBigInteger('folio_nota');
            $table->foreign('folio_nota')->references('folio_nota')
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
