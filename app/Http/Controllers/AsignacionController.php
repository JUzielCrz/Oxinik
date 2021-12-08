<?php

namespace App\Http\Controllers;

use App\Models\Asignacion;
use App\Models\AsignacionNota;
use App\Models\AsignacionNotaDetalle;
use App\User;
use Illuminate\Http\Request;

class AsignacionController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function slug_permiso($slug_permiso){
        $idauth=auth()->user()->id;
        $user=User::find($idauth);

        return $user->permiso_con_admin($slug_permiso);
    }
    

    public function show($contrato_id){
        $asigTanques=Asignacion::
        join('catalogo_gases','catalogo_gases.id','=','asignacion.tipo_gas')
        ->select('asignacion.*', 'catalogo_gases.nombre as nombreGas', 'catalogo_gases.id as idGas')
        ->where('contratos_id', $contrato_id)
        ->get();

        $data=['asigTanques'=>$asigTanques];
        return $data;
    }

    public function asignacion_plus(Request $request, $contrato_id){
        
        if($this->slug_permiso('asignacion_aumento')){
            //valiodacion para que los campos no vengan vacios
            $suma_variante=0;
            foreach( $request->asignacion_variante AS $valid => $g){
                $suma_variante=$suma_variante+$request->asignacion_variante[$valid];
                if($request->asignacion_variante[$valid] < 0 || 
                    $request->asignacion_gas[$valid] == '' ||
                    $request->asignacion_tipo_tanque[$valid] == '' || 
                    $request->asignacion_material[$valid] == '' || 
                    $request->asignacion_precio_unitario[$valid] < 0 || 
                    $request->asignacion_unidad_medida[$valid] == ''||
                    $request->asignacion_capacidad[$valid] < 0 
                    ){
                    return response()->json(['alert'=>'alert-danger', 'mensaje'=>'Faltan campos por rellenar o existen valores incorrectos']);
                }
            }
            if($suma_variante <= 0){
                return response()->json(['alert'=>'alert-danger', 'mensaje'=>'Debes realizar al menos 1 cambio']);
            }
            //verificar que no existan repeticiones
            foreach( $request->asignacion_gas AS $search => $g){
                $buscarrepetido=$request->asignacion_gas[$search].$request->asignacion_tipo_tanque[$search].$request->asignacion_material[$search].$request->asignacion_capacidad[$search].$request->asignacion_unidad_medida[$search];
                foreach( $request->asignacion_gas AS $rep => $g){
                    if($search != $rep){
                        if($buscarrepetido == $request->asignacion_gas[$rep].$request->asignacion_tipo_tanque[$rep].$request->asignacion_material[$rep].$request->asignacion_capacidad[$rep].$request->asignacion_unidad_medida[$rep]){
                            return response()->json(['alert'=>'alert-danger', 'mensaje'=>'Asignación de tanques repetidos']);
                        }
                    }
                    

                }
            }

            //
            $fechaactual=date("Y")."-" . date("m")."-".date("d");

                foreach( $request->asignacion_variante AS $inci => $g){
                    $asignaciontanque = Asignacion::
                    where('contratos_id', $contrato_id)
                    ->where('tipo_gas', $request->asignacion_gas[$inci])
                    ->where('tipo_tanque', $request->asignacion_tipo_tanque[$inci])
                    ->where('material', $request->asignacion_material[$inci])
                    ->where('capacidad', $request->asignacion_capacidad[$inci])
                    ->where('unidad_medida', $request->asignacion_unidad_medida[$inci])
                    ->first();

                    if($asignaciontanque != null){
                        $asignaciontanque->cilindros = $asignaciontanque->cilindros + $request->asignacion_variante[$inci];
                        $asignaciontanque->save();
                    }else{
                        $newAsignacionTanque= new Asignacion;
                        $newAsignacionTanque->contratos_id=$contrato_id;
                        $newAsignacionTanque->cilindros= $request->asignacion_variante[$inci];
                        $newAsignacionTanque->tipo_gas= $request->asignacion_gas[$inci];
                        $newAsignacionTanque->tipo_tanque= $request->asignacion_tipo_tanque[$inci];
                        $newAsignacionTanque->material= $request->asignacion_material[$inci];
                        $newAsignacionTanque->precio_unitario= $request->asignacion_precio_unitario[$inci];
                        $newAsignacionTanque->unidad_medida= $request->asignacion_unidad_medida[$inci];
                        $newAsignacionTanque->capacidad= $request->asignacion_capacidad[$inci];
                        $newAsignacionTanque->save();  
                    }
                }   

                $newNota=new AsignacionNota;
                $newNota->contrato_id = $contrato_id;
                $newNota->fecha=$fechaactual;
                $newNota->incidencia= 'aumento';
                $newNota->deposito_garantia= $request->deposito_garantia;
                $newNota->user_id= auth()->user()->id;
                $newNota->save();

                foreach( $request->asignacion_gas AS $detalle => $g){

                    $detalleNota=AsignacionNotaDetalle::
                    where('nota_asignacion_id', $newNota->id)
                    ->where('tipo_gas', $request->asignacion_gas[$detalle])
                    ->where('tipo_tanque', $request->asignacion_tipo_tanque[$detalle])
                    ->where('material', $request->asignacion_material[$detalle])
                    ->first();

                    if($request->asignacion_variante[$detalle] > 0){
                        if($detalleNota != null){
                            $detalleNota->cilindros = $detalleNota->cilindros + $request->asignacion_variante[$detalle];
                            $detalleNota->save();
                        }else{
                            $newDetalle= new AsignacionNotaDetalle;
                            $newDetalle->nota_asignacion_id = $newNota->id;
                            $newDetalle->cilindros= $request->asignacion_variante[$detalle];
                            $newDetalle->tipo_gas= $request->asignacion_gas[$detalle];
                            $newDetalle->tipo_tanque= $request->asignacion_tipo_tanque[$detalle];
                            $newDetalle->material= $request->asignacion_material[$detalle];
                            $newDetalle->unidad_medida= $request->asignacion_unidad_medida[$detalle];
                            $newDetalle->capacidad= $request->asignacion_capacidad[$detalle];
                            $newDetalle->save();     
                        }
                    }
                } 
            

            return response()->json(['alert'=>'alert-primary', 'nota_id' => $newNota->id]);

        }
        return response()->json(['Sin permisos']);
    }

    public function asignacion_minus(Request $request, $contrato_id){
        if($this->slug_permiso('asignacion_disminucion')){
            //valiodacion para que los campos no vengan vacios
            foreach( $request->asignacion_variante AS $valid => $g){
                if($request->asignacion_variante[$valid] < 0 
                // || 
                //     $request->asignacion_gas[$valid] == '' ||
                //     $request->asignacion_tipo_tanque[$valid] == '' || 
                //     $request->asignacion_material[$valid] == '' || 
                //     $request->asignacion_unidad_medida[$valid] == ''
                    ){
                    return response()->json(['alert'=>'alert-danger', 'mensaje'=>'Faltan campos por rellenar o existen valores incorrectos']);
                }
            }

            $fechaactual=date("Y")."-" . date("m")."-".date("d");

            foreach( $request->asignacion_variante AS $dism => $g){
                $asignaciontanque= Asignacion::
                where('contratos_id', $contrato_id)
                ->where('tipo_gas', $request->asignacion_gas[$dism])
                ->where('tipo_tanque', $request->asignacion_tipo_tanque[$dism])
                ->where('material', $request->asignacion_material[$dism])
                ->first();
                if($asignaciontanque != null){
                    $resta = $asignaciontanque->cilindros - $request->asignacion_variante[$dism];
                    if($resta<0){
                        return response()->json(['alert'=>'alert-danger', 'mensaje'=>'El cliente no cuenta con cilindros suficientes para disminuir']);
                    }
                    if($resta == 0){
                        $asignaciontanque->delete();
                    }else{
                        $asignaciontanque->cilindros=$resta;
                        $asignaciontanque->save();
                    }
                }
            }

            $newNota=new AsignacionNota;
            $newNota->contrato_id = $contrato_id;
            $newNota->fecha=$fechaactual;
            $newNota->incidencia= 'disminucion';
            $newNota->user_id= auth()->user()->id;
            $newNota->save();

            foreach( $request->asignacion_gas AS $detalle => $g){

                $detalleNota=AsignacionNotaDetalle::
                where('nota_asignacion_id', $newNota->id)
                ->where('tipo_gas', $request->asignacion_gas[$detalle])
                ->where('tipo_tanque', $request->asignacion_tipo_tanque[$detalle])
                ->where('material', $request->asignacion_material[$detalle])
                ->first();

                if($detalleNota != null){
                    $detalleNota->cilindros = $detalleNota->cilindros + $request->asignacion_variante[$detalle];
                    $detalleNota->save();
                }else{
                    $newDetalle= new AsignacionNotaDetalle;
                    $newDetalle->nota_asignacion_id = $newNota->id;
                    $newDetalle->cilindros= $request->asignacion_variante[$detalle];
                    $newDetalle->tipo_gas= $request->asignacion_gas[$detalle];
                    $newDetalle->tipo_tanque= $request->asignacion_tipo_tanque[$detalle];
                    $newDetalle->material= $request->asignacion_material[$detalle];
                    $newDetalle->unidad_medida= $request->asignacion_unidad_medida[$detalle];
                    $newDetalle->capacidad= $request->asignacion_capacidad[$detalle];
                    $newDetalle->save();     
                }
            }
            
            return response()->json(['alert'=>'alert-primary', 'nota_id' => $newNota->id]);
        }
        return response()->json(['Sin permisos']);
    }

}
