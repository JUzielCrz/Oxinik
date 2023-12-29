<?php

namespace App\Http\Controllers;
use App\Models\Driver;
use App\Models\Transporte;
use App\Models\Car;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class TransporteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $drivers=Driver::all();
        $cars=Car::all();
        $data = ['drivers'=> $drivers, 'cars'=>$cars ];
        return view('transporte.index', $data);
    }

    public function create(){
        return view('transporte.detalle.index');
    }
    public function store(Request $request)
    {
        $messages = [
            'fecha.required' => 'El campo fecha es obligatorio.',
            'car_id.required' => 'El campo Vehiculo es obligatorio.',
            'driver_id.required' => 'El campo Chofer es obligatorio.',
            'driver_id.unique' => 'La combinación de fecha, Vehiculo y Chofer ya existe.',
            // Puedes agregar más mensajes personalizados según tus necesidades...
        ];
        
        $request->validate([
            'fecha' => ['required', 'string', 'max:255'],
            'car_id' => ['required', 'integer', 'max:255'],
            'driver_id' => ['required', 'integer', 'max:255',
                Rule::unique('transportes')->where(function ($query) use ($request) {
                    return $query->where('fecha', $request->fecha)
                                 ->where('car_id', $request->car_id)
                                 ->where('driver_id', $request->driver_id);
                })
            ],
        ], $messages);

        $transporte = new Transporte();
        $transporte->fecha = $request->input('fecha');
        $transporte->car_id = $request->input('car_id');
        $transporte->driver_id = $request->input('driver_id');
        $transporte->save();
        return response()->json(['type_alert'=>'success', 'msg_text'=>'Registrado Correctamente']);
    }

    public function filter(Request $request)
    {
        $fecha = $request->input('filter_fecha');
        $vehiculo = $request->input('filter_vehiculo');
        $chofer = $request->input('filter_chofer');

        $query = Transporte::query();

        $query->leftJoin('drivers', 'transportes.driver_id', '=', 'drivers.id');
        $query->leftJoin('cars', 'transportes.car_id', '=', 'cars.id');
        $query->select('transportes.id','cars.nombre as car', 'drivers.nombre as driver','transportes.fecha');

        $datosFiltrados = $query->when($fecha || $vehiculo || $chofer, function ($query) use ($fecha, $vehiculo, $chofer) {
            // Si al menos uno de los campos no es nulo, aplicar filtros
            $query->where(function ($query) use ($fecha, $vehiculo, $chofer) {
                if ($fecha) {
                    $query->where('fecha', $fecha);
                }
                if ($vehiculo) {
                    $query->where('car_id', $vehiculo);
                }
                if ($chofer) {
                    $query->where('driver_id', $chofer);
                }
            });
        })->get();

        return response()->json(['data' => $datosFiltrados]);
    }

    public function bitacora(Transporte $id){
        $driver=Driver::find($id->driver_id);
        $car=Car::find($id->car_id);
        $data = ['bitacora'=> $id,'driver'=> $driver, 'car'=>$car ];
        return view('transporte.bitacora', $data);
    }
}
