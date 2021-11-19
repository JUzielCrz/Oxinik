<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotaTalontanqueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nota_talontanque', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('nota_talon_id');
            $table->foreign('nota_talon_id')->references('id')
                ->on('nota_talon')
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
        Schema::dropIfExists('nota_talontanque');
    }
}
