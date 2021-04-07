<?php

namespace App\Http\Controllers;

use App\Models\Asignacion;
use App\Models\AsignacionNota;
use App\Models\AsignacionNotaDetalle;
use App\User;
use Illuminate\Http\Request;

class AsignacionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function slugpermision(){
        $idauth=auth()->user()->id;
        $user=User::find($idauth);

        return $user->havePermission('contratos');
    }
    

    public function show($contrato_id){
        $asigTanques=Asignacion::
        join('catalogo_gases','catalogo_gases.id','=','asignacion.tipo_gas')
        ->where('contratos_id', $contrato_id)->get();

        $data=['asigTanques'=>$asigTanques];
        return $data;
}

    public function asignacion_plus(Request $request, $contrato_id){
        if($this->slugpermision()){
            //valiodacion para que los campos no vengan vacios
            foreach( $request->tipo_gas AS $inci => $g){
                if($request->cantidadtanques[$inci] == '' || $request->tipo_gas[$inci] == ''){
                    return response()->json(['alert'=>'alert-danger', 'mensaje'=>'Faltan campos por rellenar']);
                }
            }
            
            $fechaactual=date("Y")."-" . date("m")."-".date("d");
            
                
                foreach( $request->tipo_gas AS $inci => $g){
                    $asignaciontanque= Asignacion::where('contratos_id', $contrato_id)->where('tipo_gas', $request->tipo_gas[$inci])->first();
                    if($asignaciontanque != null){
                        $asignaciontanque->cantidad = $asignaciontanque->cantidad + $request->cantidadtanques[$inci];
                        $asignaciontanque->save();
                    }else{
                        $newAsignacionTanque= new Asignacion;
                        $newAsignacionTanque->contratos_id=$contrato_id;
                        $newAsignacionTanque->cantidad= $request->cantidadtanques[$inci];
                        $newAsignacionTanque->tipo_gas= $request->tipo_gas[$inci];
                        $newAsignacionTanque->save();    
                    }
                }   

                $newNota=new AsignacionNota;
                $newNota->contrato_id = $contrato_id;
                $newNota->fecha=$fechaactual;
                $newNota->incidencia= 'AUMENTO';
                $newNota->save();

                foreach( $request->tipo_gas AS $detalle => $g){

                    $detalleNota=AsignacionNotaDetalle::where('nota_asignacion_id', $newNota->id)->where('tipo_gas', $request->tipo_gas[$detalle])->first();

                    if($detalleNota != null){
                        $detalleNota->cantidad = $detalleNota->cantidad + $request->cantidadtanques[$detalle];
                        $detalleNota->save();
                    }else{
                        $newDetalle= new AsignacionNotaDetalle;
                        $newDetalle->nota_asignacion_id = $newNota->id;
                        $newDetalle->cantidad= $request->cantidadtanques[$detalle];
                        $newDetalle->tipo_gas= $request->tipo_gas[$detalle];
                        $newDetalle->save();     
                    }
                } 
            

            return response()->json(['alert'=>'alert-primary', 'nota_id' => $newNota->id]);

        }
        return response()->json(['Sin permisos']);
    }

    public function asignacion_minus(Request $request, $contrato_id){
        if($this->slugpermision()){
            //valiodacion para que los campos no vengan vacios
            foreach( $request->tipo_gas AS $validar => $g){
                if($request->cantidadtanques[$validar] == '' || $request->tipo_gas[$validar] == ''){
                    return response()->json(['alert'=>'alert-danger', 'mensaje'=>'Faltan campos por rellenar']);
                }
            }

            $fechaactual=date("Y")."-" . date("m")."-".date("d");
            
            $banderanota=true;
            $groupGas=array();
                //Agrupar elementos del request
                foreach( $request->tipo_gas AS $agrupar => $g){
                    $searchGas = array_key_exists($request->tipo_gas[$agrupar], $groupGas);
                    
                    if ($searchGas) {
                        $cantidadaray=$groupGas[$request->tipo_gas[$agrupar]]; //11
                        $cantidadaray=$cantidadaray+$request->cantidadtanques[$agrupar];
                        $reemplazo = array($request->tipo_gas[$agrupar] => $cantidadaray);
                        $groupGas=array_replace($groupGas, $reemplazo);
                    }else{
                        $groupGas += [ $request->tipo_gas[$agrupar] => intval($request->cantidadtanques[$agrupar])];
                    }
                }

                //buscar un error antes de guardar en la base de datos
                foreach( $request->tipo_gas AS $searchError => $g){
                    $asignaciontanque=Asignacion::where('contratos_id', $contrato_id)->where('tipo_gas', $request->tipo_gas[$searchError])->first();
                    if ($asignaciontanque != null) {
                        $asignacionresta = $asignaciontanque->cantidad - $groupGas[$request->tipo_gas[$searchError]];
                        if($asignacionresta<0){
                            $banderanota=false;
                            return response()->json(['alert'=>'alert-danger', 'mensaje'=>'El cliente no cuenta con esta cantidad de tanques para disminuir']);
                        }
                    }else{
                        $banderanota=false;
                        return response()->json(['alert'=>'alert-danger', 'mensaje'=>'No puedes disminuir un tanque que non has asignado previamente']);
                    }
                }

                if($banderanota){

                    foreach ($groupGas as $gastipo => $cant) {
                        $asignaciontanque=Asignacion::where('contratos_id', $contrato_id)->where('tipo_gas', $gastipo)->first();
                        $asignacionresta = $asignaciontanque->cantidad - $cant;
                        
                        if($asignacionresta == 0){
                            $asignaciontanque->delete();
                        }else{
                            $asignaciontanque->cantidad = $asignacionresta;
                            $asignaciontanque->save();
                        }

                    }

                    $newNota=new AsignacionNota;
                    $newNota->contrato_id = $contrato_id;
                    $newNota->fecha=$fechaactual;
                    $newNota->incidencia= 'DISMINUCION';
                    $newNota->save();

                    foreach ($groupGas as $claveGas => $valCant) {
                        $newDetalle= new AsignacionNotaDetalle;
                        $newDetalle->nota_asignacion_id = $newNota->id;
                        $newDetalle->cantidad= $valCant;
                        $newDetalle->tipo_gas= $claveGas;
                        $newDetalle->save();  
                    }
                }

            return response()->json(['alert'=>'alert-primary', 'nota_id' => $newNota->id]);

        }
        return response()->json(['Sin permisos']);
    }

}
