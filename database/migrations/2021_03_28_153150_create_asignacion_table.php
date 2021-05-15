<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsignacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asignacion', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('contratos_id');
            $table->foreign('contratos_id')->references('id')
                    ->on('contratos')
                    ->onDelete('restrict');
            $table->integer('cilindros');
            $table->string('tipo_gas');
            $table->string('tipo_tanque');
            $table->string('material');
            $table->float('precio_unitario');
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
        Schema::dropIfExists('asignacion');
    }
}
