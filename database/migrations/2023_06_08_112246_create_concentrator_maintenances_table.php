<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConcentratorMaintenancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('concentrator_maintenances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('concentrator_id');
            $table->foreign('concentrator_id')->references('id')
                ->on('concentrators')
                ->onDelete('restrict');
            $table->string('serial_number');
            $table->string('work_hours')->nullable();

            $table->enum('status', ['OK', 'PENDIENTE']);
            $table->string('observations')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->dateTime('date_return')->nullable();

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
        Schema::dropIfExists('concentrator_maintenances');
    }
}
