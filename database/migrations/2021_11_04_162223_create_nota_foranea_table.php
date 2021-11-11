<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotaForaneaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nota_foranea', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_cliente');
            $table->string('telefono')->nullable();
            $table->string('email')->nullable();
            $table->string('direccion')->nullable();
            $table->string('rfc')->nullable();
            $table->string('cfdi')->nullable();
            $table->string('direccion_factura')->nullable();

            $table->string('direccion_envio')->nullable();
            $table->string('referencia_envio')->nullable();
            $table->string('link_ubicacion_envio')->nullable();
            $table->float('precio_envio')->nullable();
            
            $table->float('subtotal');
            $table->float('iva_general')->nullable();
            $table->float('total');

            $table->string('metodo_pago')->nullable();
            $table->date('fecha');

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
        Schema::dropIfExists('nota_foranea');
    }
}
