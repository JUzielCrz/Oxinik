<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNumTarjetaToDatosEmpresaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('datos_empresa', function (Blueprint $table) {
            $table->string('num_tarjeta1')->nullable()->after('titular1');
            $table->string('num_tarjeta2')->nullable()->after('titular2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('datos_empresa', function (Blueprint $table) {
            $table->dropColumn(['num_tarjeta1', 'num_tarjeta2']);
        });
    }
}
