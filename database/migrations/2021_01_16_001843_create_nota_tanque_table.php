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
            //salida y devolucion
            $table->unsignedBigInteger('nota_id');
            $table->foreign('nota_id')->references('id')
                ->on('notas')
                ->onDelete('restrict');
            $table->string('num_serie');
            $table->foreign('num_serie')->references('num_serie')
                ->on('tanques')
                ->onDelete('restrict');
            //solo  salida
            $table->integer('cantidad')->nullable();
            $table->string('unidad_medida')->nullable();
            $table->double('precio_unitario')->nullable();
            $table->enum('tapa_tanque', ['SI', 'NO']);
            $table->float('iva_particular')->nullable();
            $table->float('importe')->nullable();
            //devolucion
            // $table->double('multa')->default(0)->nullable();
            // $table->boolean('devolucion')->default(false)->nullable();
            
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
