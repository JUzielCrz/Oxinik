<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConcentratorNoteDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('concentrator_note_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('concentrator_id');
            $table->foreign('concentrator_id')->references('id')
                ->on('concentrators')
                ->onDelete('restrict');
            $table->unsignedBigInteger('note_id');
            $table->foreign('note_id')->references('id')
                ->on('concentrator_notas')
                ->onDelete('restrict');
            $table->float('rent');
            $table->string('time');
            $table->float('deposit_garanty')->default(0);
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
        Schema::dropIfExists('concentrator_note_details');
    }
}
