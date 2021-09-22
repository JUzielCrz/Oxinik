<?php

use App\Models\CatalogoGas;
use Illuminate\Database\Seeder;

class CatalogoGasesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CatalogoGas::create(['nombre'=>'OXIGENO','abreviatura'=>'O2']);
        CatalogoGas::create(['nombre'=>'ACETILENO','abreviatura'=>'C2H2']);
        CatalogoGas::create(['nombre'=>'HELIO','abreviatura'=>'HE']);
        CatalogoGas::create(['nombre'=>'HELIO GLOBOS','abreviatura'=>'HEG']);
        CatalogoGas::create(['nombre'=>'HIDROGENO','abreviatura'=>'H']);
        CatalogoGas::create(['nombre'=>'NITROGENO','abreviatura'=>'N']);

    }
}
