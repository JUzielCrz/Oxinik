<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TransporteBitacoras extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transporte_bitacoras', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transporte_id')->nullable();
            $table->foreign('transporte_id')->references('id')->on('transportes')->onDelete('SET NULL');
            $table->string('lugar_salida');
            $table->string('lugar_llegada');
            $table->time('hora_salida');
            $table->time('hora_entrada');
            $table->string('descarga');
            $table->string('carga');
            $table->string('total');
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
        //
    }
}
