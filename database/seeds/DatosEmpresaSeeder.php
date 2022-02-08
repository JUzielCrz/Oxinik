<?php

use App\Models\DatosEmpresa;
use Illuminate\Database\Seeder;

class DatosEmpresaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //asignaciones
        DatosEmpresa::create([
            'id'=>1
        ]);
    }
}
