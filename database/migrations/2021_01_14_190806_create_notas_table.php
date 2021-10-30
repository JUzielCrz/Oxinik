<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('contrato_id');
            $table->foreign('contrato_id')->references('id')
                ->on('contratos')
                ->onDelete('cascade');
            $table->date('fecha');
            $table->string('envio');
            $table->float('subtotal');
            $table->float('iva_general');
            $table->float('total');
            $table->float('primer_pago');
            $table->string('metodo_pago');
            $table->boolean('pago_cubierto');
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
        Schema::dropIfExists('notas');
    }
}
