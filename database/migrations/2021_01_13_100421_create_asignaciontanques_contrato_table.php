<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsignaciontanquesContratoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asignaciontanques_contrato', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('num_contrato');
            $table->foreign('num_contrato')->references('num_contrato')
                ->on('contratos')
                ->onDelete('restrict');
            $table->integer('cantidad');
            $table->date('tipo_envase');
            $table->enum('incidencia',['AUMENTO', 'DISMINUCION']);
            $table->date('fecha');
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
        Schema::dropIfExists('asignaciontanques_contrato');
    }
}
