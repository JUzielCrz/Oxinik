<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotaTalonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nota_talon', function (Blueprint $table) {
            $table->id();
            //add
            $table->integer('num_cliente')->nullable();
            $table->string('nombre');
            $table->string('telefono')->nullable();
            $table->string('email')->nullable();
            $table->string('direccion')->nullable();
            $table->string('rfc')->nullable();
            $table->string('cfdi')->nullable();
            $table->string('direccion_factura')->nullable();

            $table->string('direccion_envio')->nullable();
            $table->string('referencia_envio')->nullable();
            $table->string('link_ubicacion_envio')->nullable();
            $table->float('precio_envio')->default(0)->nullable();
            //fin add
            $table->boolean('pendiente')->default(true);

            $table->float('subtotal')->default(0);
            $table->float('iva_general')->default(0);
            $table->float('total')->default(0);
            $table->string('metodo_pago')->nullable();
            $table->date('fecha');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('observaciones')->nullable();

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
        Schema::dropIfExists('nota_talon');
    }
}
