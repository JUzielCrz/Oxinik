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
            $table->unsignedBigInteger('folio_nota')->unique();
            $table->unsignedBigInteger('contrato_id');
            $table->foreign('contrato_id')->references('id')
                ->on('contratos')
                ->onDelete('restrict');
            $table->date('fecha');
            $table->string('envio')->nullable();
            $table->float('subtotal');
            $table->float('iva_general');
            $table->string('total');
            $table->boolean('pago_cubierto');
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
