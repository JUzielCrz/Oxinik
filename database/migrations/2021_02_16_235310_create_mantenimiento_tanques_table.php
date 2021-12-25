<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMantenimientoTanquesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mantenimiento_tanques', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mantenimientollenado_id');
            $table->foreign('mantenimientollenado_id')
                ->references('id')
                ->on('mantenimiento_llenado')
                ->onDelete('cascade');
            $table->string('num_serie');
            $table->string('folio_talon');
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
        Schema::dropIfExists('mantenimiento_tanques');
    }
}
