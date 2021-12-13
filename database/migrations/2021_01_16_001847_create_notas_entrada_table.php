<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotasEntradaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notas_entrada', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('contrato_id');
            $table->foreign('contrato_id')->references('id')
                ->on('contratos')
                ->onDelete('cascade');
            $table->date('fecha');
            $table->string('metodo_pago')->nullable();
            $table->double('recargos')->default(0)->nullable();
            $table->string('observaciones')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->enum('estatus', ['ACTIVA', 'CANCELADA'])->default('ACTIVA');
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
        Schema::dropIfExists('notas_entrada');
    }
}
