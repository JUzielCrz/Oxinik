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

            $table->string('shipping_address')->nullable();
            $table->string('shipping_reference')->nullable();
            $table->float('shipping_price')->default(0)->nullable();
            $table->string('link_location')->nullable();

            //fin add
            $table->float('subtotal');
            $table->float('iva')->nullable();
            $table->float('total');

            $table->string('metodo_pago')->nullable();
            $table->enum('status', ['ACTIVA', 'CANCELADA'])->default('ACTIVA');
            $table->unsignedBigInteger('user_id')->nullable();

            $table->string('observations')->nullable();
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
