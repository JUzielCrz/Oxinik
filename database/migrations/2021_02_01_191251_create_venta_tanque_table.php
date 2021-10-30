<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVentaTanqueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('venta_tanque', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('venta_id');
            $table->foreign('venta_id')->references('id')
                ->on('ventas')
                ->onDelete('cascade');
            $table->string('num_serie');
            $table->integer('cantidad')->nullable();
            $table->string('unidad_medida')->nullable();
            $table->double('precio_unitario')->nullable();
            $table->enum('tapa_tanque', ['SI', 'NO'])->nullable();
            $table->float('iva_particular')->nullable();
            $table->float('importe')->nullable();
            $table->enum('insidencia', ['ENTRADA', 'SALIDA']);
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
        Schema::dropIfExists('venta_tanque');
    }
}
