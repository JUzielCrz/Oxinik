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
            $table->unsignedBigInteger('folio_nota')->unique()->nullable();
            $table->unsignedBigInteger('contrato_id');
            $table->foreign('contrato_id')->references('id')
                ->on('contratos')
                ->onDelete('restrict');
            $table->date('fecha');
            $table->string('envio')->nullable();
            $table->float('subtotal')->nullable();
            $table->float('iva_general')->nullable();
            $table->float('total')->nullable();
            $table->boolean('pago_cubierto')->nullable();

            $table->double('recargos')->default(0)->nullable();
            $table->enum('incidencia',['ENTRADA','SALIDA'])->default('ENTRADA')->nullable();
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
