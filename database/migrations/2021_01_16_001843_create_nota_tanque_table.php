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
            $table->id();
            $table->unsignedBigInteger('nota_id');
            $table->foreign('nota_id')->references('id')
                ->on('notas')
                ->onDelete('cascade');
            $table->string('num_serie');
            //solo  salida
            $table->integer('cantidad')->nullable();
            $table->string('unidad_medida')->nullable();
            $table->double('precio_unitario')->nullable();
            $table->enum('tapa_tanque', ['SI', 'NO']);
            $table->float('iva_particular')->nullable();
            $table->float('importe')->nullable();
            $table->boolean('devuelto')->default(false);
            //devolucion
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
