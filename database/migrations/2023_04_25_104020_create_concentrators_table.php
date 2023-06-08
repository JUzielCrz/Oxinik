<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConcentratorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('concentrators', function (Blueprint $table) {
            $table->id();
            $table->string('serial_number')->unique();
            $table->string('brand');
            $table->string('work_hours');
            $table->float('capacity');
            $table->enum('status', ['ALMACEN', 'EN RENTA', 'MANTENIMIENTO']);
            $table->string('description')->nullable();
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
        Schema::dropIfExists('concentrators');
    }
}
