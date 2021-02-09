<?php

use App\Models\Tanque;
use Illuminate\Database\Seeder;

class TanqueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tanque::create([
            'num_serie'=>'TQ00245',
            'ph'=>'2014-12',
            'capacidad'=>'8 m3',  
            'material'=>'Aluminio',
            'fabricante'=>'Plaxair',
            'tipo_gas'=>'Oxigeno',
            'estatus'=>'LLENO-ALMACEN',
        ]);

        Tanque::create([
            'num_serie'=>'TQ00265',
            'ph'=>'2014-12',
            'capacidad'=>'8 m3',  
            'material'=>'Acero',
            'fabricante'=>'Infra',
            'tipo_gas'=>'Oxigeno',
            'estatus'=>'LLENO-ALMACEN',
        ]);

        Tanque::create([
            'num_serie'=>'TQ00275',
            'ph'=>'2014-12',
            'capacidad'=>'8 m3',  
            'material'=>'Aluminio',
            'fabricante'=>'Plaxair',
            'tipo_gas'=>'Oxigeno',
            'estatus'=>'LLENO-ALMACEN',
        ]);

        Tanque::create([
            'num_serie'=>'TQ00285',
            'ph'=>'2014-12',
            'capacidad'=>'8 m3',  
            'material'=>'Acero',
            'fabricante'=>'TanQuir',
            'tipo_gas'=>'Oxigeno',
            'estatus'=>'LLENO-ALMACEN',
        ]);

        Tanque::create([
            'num_serie'=>'TQ00295',
            'ph'=>'2014-12',
            'capacidad'=>'8 m3',  
            'material'=>'Aluminio',
            'fabricante'=>'Oxinair',
            'tipo_gas'=>'Oxigeno',
            'estatus'=>'LLENO-ALMACEN',
        ]);
    }
}
