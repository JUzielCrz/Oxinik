<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotasEntradaTanqueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notas_entrada_tanque', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('nota_id');
            $table->foreign('nota_id')->references('id')
                ->on('notas_entrada')
                ->onDelete('cascade');
            $table->string('num_serie');
            $table->enum('tapa_tanque', ['SI', 'NO']);
            $table->string('intercambio');
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
        Schema::dropIfExists('notas_entrada_tanque');
    }
}
