<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotaTanqueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nota_tanque', function (Blueprint $table) {
            $table->unsignedBigInteger('nota_id');
            $table->foreign('nota_id')->references('id')
                ->on('notas')
                ->onDelete('restrict');
            $table->string('num_serie');
            $table->foreign('num_serie')->references('num_serie')
                ->on('tanques')
                ->onDelete('restrict');
            //salida
            $table->integer('cantidad');
            $table->string('unidad_medida');
            $table->double('precio_unitario')->nullable();
            $table->enum('tapa_tanque', ['SI', 'NO']);
            $table->float('iva_particular');
            $table->float('importe');
            //devolucion
            $table->double('multa')->default(0)->nullable();
            $table->boolean('devolucion')->default(false)->nullable();
            
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
        Schema::dropIfExists('nota_tanque');
    }
}
