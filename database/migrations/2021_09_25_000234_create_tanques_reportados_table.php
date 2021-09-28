<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTanquesReportadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tanques_reportados', function (Blueprint $table) {
            $table->id();
            $table->string('num_serie')->unique();
            $table->foreign('num_serie')->references('num_serie')
                ->on('tanques')
                ->onDelete('cascade');
            $table->string('observaciones');
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
        Schema::dropIfExists('tanques_reportados');
    }
}
