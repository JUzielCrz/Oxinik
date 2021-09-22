<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContratosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contratos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('num_contrato')->unique();
            $table->unsignedBigInteger('cliente_id');
            $table->foreign('cliente_id')->references('id')
                ->on('clientes')
                ->onDelete('restrict');
            $table->string('tipo_contrato');
            $table->double('precio_transporte')->default(0)->nullable();
            $table->string('direccion')->nullable();
            $table->string('referencia')->nullable();
            $table->string('link_ubicacion')->nullable();
            $table->integer('reguladores')->default(0)->nullable();
            $table->string('empresa')->nullable();
            $table->float('deposito_garantia');
            $table->unique(['cliente_id', 'tipo_contrato']);
            $table->string('observaciones')->nullable();
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
        Schema::dropIfExists('contratos');
    }
}
