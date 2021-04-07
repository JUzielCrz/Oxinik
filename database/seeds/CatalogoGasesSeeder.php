<?php

use App\Models\CatalogoGases;
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
        CatalogoGases::create(['nombre'=>'OXIGENO','abreviatura'=>'O2']);
        CatalogoGases::create(['nombre'=>'ACETILENO','abreviatura'=>'C2H2']);
        CatalogoGases::create(['nombre'=>'HELIO','abreviatura'=>'HE']);
        CatalogoGases::create(['nombre'=>'HELIO GLOBOS','abreviatura'=>'HEG']);
        CatalogoGases::create(['nombre'=>'HIDROGENO','abreviatura'=>'H']);
        CatalogoGases::create(['nombre'=>'NITROGENO','abreviatura'=>'N']);

    }
}
