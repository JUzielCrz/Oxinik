<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Driver;
use App\Models\Transporte;
use App\Models\TransporteBitacora;
use App\Models\Car;
use Yajra\DataTables\DataTables;
use Barryvdh\DomPDF\Facade as PDF;
use App\Models\DatosEmpresa;

class TransporteBitacoraController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Transporte $id){
        $driver=Driver::find($id->driver_id);
        $car=Car::find($id->car_id);
        $data = ['transporte'=> $id,'driver'=> $driver, 'car'=>$car ];
        return view('transporte.bitacora', $data);
    }

    public function create(Request $request, Transporte $transporte){
        $messages = [
            'lugar_salida.required' => 'El campo lugar salida es obligatorio.',
            'lugar_llegada.required' => 'El campo lugar llegada es obligatorio.',
            'hora_salida.required' => 'El campo hora salida es obligatorio.',
            'hora_entrada.required' => 'El campo hora entrada es obligatorio.',
            'carga.required' => 'El campo carga es obligatorio.',
            'descarga.required' => 'El campo descarga es obligatorio.',
            'total.required' => 'El campo total es obligatorio.',
            // Puedes agregar más mensajes personalizados según tus necesidades...
        ];
        
        $request->validate([
            'lugar_salida' => ['required', 'string', 'max:255'],
            'lugar_llegada' => ['required', 'string', 'max:255'],
            'hora_salida' => ['required', 'string', 'max:255'],
            'hora_entrada' => ['required', 'string', 'max:255'],
            'carga' => ['required', 'string', 'max:255'],
            'descarga' => ['required', 'string', 'max:255'],
            'total' => ['required', 'string', 'max:255'],
        ], $messages);
        
        $bitacora = new TransporteBitacora();
        $bitacora->transporte_id = $transporte->id;
        $bitacora->lugar_salida = $request->input('lugar_salida');
        $bitacora->lugar_llegada = $request->input('lugar_llegada');
        $bitacora->hora_salida = $request->input('hora_salida');
        $bitacora->hora_entrada = $request->input('hora_entrada');
        $bitacora->carga = $request->input('carga');
        $bitacora->descarga = $request->input('descarga');
        $bitacora->total = $request->input('total');
        $bitacora->observaciones = $request->input('observaciones');
        $bitacora->save();
    }

    public function data($transporte)
    {
                $data=TransporteBitacora::where('transporte_id','=', $transporte)->get();

                return DataTables::of(
                    $data
                )
               ->toJson();
        
    }

    public function destroy(TransporteBitacora $bitacora)
    {
        $bitacora->delete();
    }

    public function pdf(Transporte $transporte){
        $bitacoras=TransporteBitacora::where('transporte_id',$transporte->id)->get();
        $empresa=DatosEmpresa::find(1);
        $vehiculo=Car::find($transporte->car_id);
        $chofer=Driver::find($transporte->driver_id);

        $data=['transporte'=>$transporte,'bitacoras'=>$bitacoras,'empresa'=>$empresa,'vehiculo'=>$vehiculo,'chofer'=>$chofer];

        $pdf = PDF::loadView('transporte.pdf', $data);

        $pdf->setPaper('letter', 'landscape');
        return $pdf->stream('transporte_bitacora_'.$transporte->id.'.pdf');
    }
}
