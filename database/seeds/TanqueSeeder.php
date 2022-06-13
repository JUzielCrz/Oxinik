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
            'material'=>'Acero',
            'fabricante'=>'Praxair',
            'tipo_gas'=>'1',
            'tipo_tanque'=>'Industrial',
            'estatus'=>'VENTA-FORANEA',
        ]);

        Tanque::create([
            'num_serie'=>'TQ00246',
            'ph'=>'2014-12',
            'capacidad'=>'8 m3',  
            'material'=>'Acero',
            'fabricante'=>'Infra',
            'tipo_gas'=>'1',
            'tipo_tanque'=>'Industrial',
            'estatus'=>'VENTA-FORANEA',
        ]);

        Tanque::create([
            'num_serie'=>'TQ00247',
            'ph'=>'2014-12',
            'capacidad'=>'8 m3',  
            'material'=>'Acero',
            'fabricante'=>'Praxair',
            'tipo_gas'=>'3',
            'tipo_tanque'=>'Industrial',
            'estatus'=>'LLENO-ALMACEN',
        ]);

        Tanque::create([
            'num_serie'=>'TQ00248',
            'ph'=>'2014-12',
            'capacidad'=>'8 m3',  
            'material'=>'Acero',
            'fabricante'=>'TanQuir',
            'tipo_gas'=>'4',
            'tipo_tanque'=>'Industrial',
            'estatus'=>'LLENO-ALMACEN',
        ]);

        Tanque::create([
            'num_serie'=>'TQ00249',
            'ph'=>'2014-12',
            'capacidad'=>'8 m3',  
            'material'=>'Acero',
            'fabricante'=>'Praxair',
            'tipo_gas'=>'1',
            'tipo_tanque'=>'Industrial',
            'estatus'=>'LLENO-ALMACEN',
        ]);

        Tanque::create([
            'num_serie'=>'TQ00250',
            'ph'=>'2014-12',
            'capacidad'=>'8 m3',  
            'material'=>'Acero',
            'fabricante'=>'Infra',
            'tipo_gas'=>'2',
            'tipo_tanque'=>'Industrial',
            'estatus'=>'LLENO-ALMACEN',
        ]);

        Tanque::create([
            'num_serie'=>'TQ00251',
            'ph'=>'2014-12',
            'capacidad'=>'8 m3',  
            'material'=>'Acero',
            'fabricante'=>'Praxair',
            'tipo_gas'=>'3',
            'tipo_tanque'=>'Industrial',
            'estatus'=>'LLENO-ALMACEN',
        ]);

        Tanque::create([
            'num_serie'=>'TQ00252',
            'ph'=>'2014-12',
            'capacidad'=>'8 m3',  
            'material'=>'Acero',
            'fabricante'=>'TanQuir',
            'tipo_gas'=>'4',
            'tipo_tanque'=>'Industrial',
            'estatus'=>'LLENO-ALMACEN',
        ]);


        ////ALUMINIOOOOOO
        Tanque::create([
            'num_serie'=>'AL00245',
            'ph'=>'2014-12',
            'capacidad'=>'8 m3',  
            'material'=>'Acero',
            'fabricante'=>'Praxair',
            'tipo_gas'=>'1',
            'tipo_tanque'=>'Industrial',
            'estatus'=>'LLENO-ALMACEN',
        ]);

        Tanque::create([
            'num_serie'=>'AL00246',
            'ph'=>'2014-12',
            'capacidad'=>'8 m3',  
            'material'=>'Aluminio',
            'fabricante'=>'Infra',
            'tipo_gas'=>'2',
            'tipo_tanque'=>'Industrial',
            'estatus'=>'LLENO-ALMACEN',
        ]);

        Tanque::create([
            'num_serie'=>'AL00247',
            'ph'=>'2014-12',
            'capacidad'=>'8 m3',  
            'material'=>'Aluminio',
            'fabricante'=>'Praxair',
            'tipo_gas'=>'3',
            'tipo_tanque'=>'Industrial',
            'estatus'=>'LLENO-ALMACEN',
        ]);

        Tanque::create([
            'num_serie'=>'AL00248',
            'ph'=>'2014-12',
            'capacidad'=>'8 m3',  
            'material'=>'Aluminio',
            'fabricante'=>'TanQuir',
            'tipo_gas'=>'4',
            'tipo_tanque'=>'Industrial',
            'estatus'=>'LLENO-ALMACEN',
        ]);

        Tanque::create([
            'num_serie'=>'AL00249',
            'ph'=>'2014-12',
            'capacidad'=>'8 m3',  
            'material'=>'Aluminio',
            'fabricante'=>'Praxair',
            'tipo_gas'=>'1',
            'tipo_tanque'=>'Industrial',
            'estatus'=>'LLENO-ALMACEN',
        ]);

        Tanque::create([
            'num_serie'=>'AL00250',
            'ph'=>'2014-12',
            'capacidad'=>'8 m3',  
            'material'=>'Acero',
            'fabricante'=>'Infra',
            'tipo_gas'=>'1',
            'tipo_tanque'=>'Industrial',
            'estatus'=>'LLENO-ALMACEN',
        ]);

        Tanque::create([
            'num_serie'=>'AL00251',
            'ph'=>'2014-12',
            'capacidad'=>'8 m3',  
            'material'=>'Aluminio',
            'fabricante'=>'Praxair',
            'tipo_gas'=>'3',
            'tipo_tanque'=>'Industrial',
            'estatus'=>'LLENO-ALMACEN',
        ]);

        Tanque::create([
            'num_serie'=>'AL00252',
            'ph'=>'2014-12',
            'capacidad'=>'8 m3',  
            'material'=>'Aluminio',
            'fabricante'=>'TanQuir',
            'tipo_gas'=>'4',
            'tipo_tanque'=>'Industrial',
            'estatus'=>'LLENO-ALMACEN',
        ]);
        

    }
}
