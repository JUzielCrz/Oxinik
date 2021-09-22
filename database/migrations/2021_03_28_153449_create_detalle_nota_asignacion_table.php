<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleNotaAsignacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_nota_asignacion', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('nota_asignacion_id');
            $table->foreign('nota_asignacion_id')->references('id')
                    ->on('nota_asignacion')
                    ->onDelete('cascade');
            $table->integer('cilindros');
            $table->foreignId('tipo_gas')->references('id')->on('catalogo_gases')->onDelete('restrict');
            $table->string('tipo_tanque');
            $table->string('material');
            $table->string('unidad_medida');
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
        Schema::dropIfExists('detalle_nota_asignacion');
    }
}
