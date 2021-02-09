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
            $table->unsignedBigInteger('folio_nota')->unique();
            $table->date('fecha');
            $table->string('pago_realizado');
            $table->string('metodo_pago');
            $table->unsignedBigInteger('num_contrato');
            $table->foreign('num_contrato')->references('num_contrato')
                ->on('contratos')
                ->onDelete('restrict');
            $table->string('total');
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
