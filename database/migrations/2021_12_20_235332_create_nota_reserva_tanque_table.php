<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotaReservaTanqueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nota_reserva_tanque', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('nota_id');
            $table->foreign('nota_id')->references('id')
                ->on('nota_reserva')
                ->onDelete('cascade');
            $table->string('num_serie');
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
        Schema::dropIfExists('nota_reserva_tanque');
    }
}
