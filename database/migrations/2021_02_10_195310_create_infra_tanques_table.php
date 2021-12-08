<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInfraTanquesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('infra_tanques', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('infrallenado_id');
            $table->foreign('infrallenado_id')
                ->references('id')
                ->on('infra_llenado')
                ->onDelete('cascade');
            $table->string('num_serie');
            $table->enum('incidencia',['ENTRADA','SALIDA']);
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
        Schema::dropIfExists('infra_tanques');
    }
}
