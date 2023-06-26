<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConcentratorPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('concentrator_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('note_id');
            $table->foreign('note_id')->references('id')
                ->on('concentrator_notas')
                ->onDelete('cascade');

            $table->integer('day');
            $table->float('price_day');
            $table->integer('week');
            $table->float('price_week');
            $table->integer('mount');
            $table->float('price_mount');
            
            $table->float('deposit_garanty')->default(0)->nullable();

            $table->date('date_start');
            $table->date('date_end');
            $table->float('work_hours_output')->nullable();
            
            $table->string('shipping_address')->nullable();
            $table->string('shipping_reference')->nullable();
            $table->float('shipping_price')->default(0)->nullable();
            $table->string('link_location')->nullable();

            //fin add
            $table->float('total');
            $table->string('payment_method')->nullable();
            $table->enum('status', ['PAGADO', 'ADEUDA']);


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
        Schema::dropIfExists('concentrator_payments');
    }
}
