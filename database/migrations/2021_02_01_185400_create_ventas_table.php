<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cliente_id')->unsigned()->nullable();
            $table->foreign('cliente_id')->references('id')
                ->on('clientes_sin_contrato')
                ->onDelete('set null');
            $table->float('precio_envio');
            $table->float('subtotal');
            $table->float('iva_general')->nullable();
            $table->float('total');

            $table->string('metodo_pago')->nullable();
            $table->date('fecha');
            $table->enum('estatus', ['ACTIVA', 'CANCELADA'])->default('ACTIVA');
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
        Schema::dropIfExists('ventas');
    }
}
