<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConcentratorNotasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('concentrator_notas', function (Blueprint $table) {
            $table->id();
            $table->integer('num_client')->nullable();
            $table->string('name');
            $table->string('phone_number')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('rfc')->nullable();
            $table->string('cfdi')->nullable();
            $table->string('address_facture')->nullable();
            $table->enum('status_concentrator', ['EN ALMACEN', 'CON EL CLIENTE']);

            $table->unsignedBigInteger('concentrator_id');
            $table->foreign('concentrator_id')->references('id')
                ->on('concentrators')
                ->onDelete('restrict');
            $table->string('observations')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();

            

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
        Schema::dropIfExists('concentrator_notas');
    }
}
