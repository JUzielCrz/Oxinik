<?php

namespace App\Http\Controllers;

use App\Models\CatalogoGas;
use App\Models\Tanque;
use App\Models\TanqueHistorial;
use App\Models\TanqueReportado;
use App\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class TanqueController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    public function slug_permiso($slug_permiso){
        $idauth=auth()->user()->id;
        $user=User::find($idauth);

        return $user->permiso_con_admin($slug_permiso);
    }

    protected function validator(array $data,$id){
        return Validator::make($data, [
            'num_serie' => ['required', 'string','max:255', Rule::unique('tanques')->ignore($id, 'id')],
            'ph' => ['required', 'string', 'max:255'],
            'capacidad' => ['required', 'string', 'max:255'],
            'material' => ['required', 'string', 'max:255'],
            'fabricante' => ['required', 'string', 'max:255'],
            'tipo_gas' =>  ['required', 'string', 'max:255'],
            'tipo_tanque' =>  ['required', 'string', 'max:255'],
        ]);
    }

    public function index(){
        if($this->slug_permiso('tanque_show')){
            $catalogo = CatalogoGas::pluck('nombre','id');
            $data= ['catalogo'=>$catalogo];
            return view('tanques.index', $data);
        }
        return view('home');
    }

    public function tanques_data(){
        if($this->slug_permiso('tanque_show')){
            $tanques=Tanque::
            select('tanques.*')
            ->where('estatus',"!=","BAJA-TANQUE")
            ->where('estatus',"!=","TANQUE-CAMBIADO")
            ->where('estatus',"!=","TANQUE-REPORTADO");
            return DataTables::of(
                $tanques
            )
            ->editColumn('ph', function ($pruebaH) {
                $fechaactual=new DateTime(date("Y")."-" . date("m")."-".date("d"));
                $fechaPh=new DateTime($pruebaH->ph);
                $diferencia = $fechaactual->diff($fechaPh);
                
                if( $diferencia->y >= 9 &&  $diferencia->m >= 10 || $diferencia->y >= 10){
                    return '<div class="alert-danger" role="alert">'.$pruebaH->ph.'</div>';
                };
                if( $diferencia->y >= 9 &&  $diferencia->m >= 7 ){
                    return '<div class="alert-warning" role="alert">'.$pruebaH->ph.'</div>';
                };
                return  $pruebaH->ph;
            })                                                               
            ->addColumn( 'btnHistory', '<a class="btn btn-sm btn-verde btn-xs" href="{{route(\'tanques.history\', $id)}}" title="Historial"><span class="fas fa-history"></span></a>')
            ->addColumn( 'btnShow', '<button class="btn btn-sm btn-verde btn-show-modal btn-xs" data-id="{{$id}}" title="Información"><span class="far fa-eye"></span></button>')
            ->addColumn( 'btnEdit', '<button class="btn btn-sm btn-verde btn-edit-modal btn-xs" data-id="{{$id}}" title="Editar"><span class="far fa-edit"></span></button>')
            ->addColumn( 'btnBaja', '<button class="btn btn-sm btn-verde btn-delete-modal btn-xs" data-id="{{$id}}" title="Baja"><span class="fas fa-trash"></span></button>')
            ->rawColumns(['btnHistory','btnShow','btnEdit','btnBaja','ph'])
            ->toJson();
        }
        return view('home');
    }

    public function validar_ph($pruebaH){
        $fechaactual=new DateTime(date("Y")."-" . date("m")."-".date("d"));
        $fechaPh=new DateTime($pruebaH);
        $diferencia = $fechaactual->diff($fechaPh);

            if( $diferencia->y >= 9 &&  $diferencia->m >= 10 || $diferencia->y >= 10){
                return response()->json(['alert'=>true, 'mensaje'=>'Prueba hidroestatica 3 meses a vencer o vencido']);
            };
            if( $diferencia->y >= 9 &&  $diferencia->m >= 7 ){
                return response()->json(['alert'=>true, 'mensaje'=>'Prueba hidroestatica 6 meses a vencer']);
            };
        
        return response()->json(['alert'=>false]);
    }

    public function create(Request $request){
        if($this->slug_permiso('tanque_create')){
            $request->validate([
                'num_serie' => ['required', 'string', 'max:255','unique:tanques,num_serie'],
                'ph' => ['required', 'string', 'max:255'],
                'capacidad' => ['required', 'string', 'max:255'],
                'material' => ['required', 'string', 'max:255'],
                'fabricante' => ['required', 'string', 'max:255'],
                'tipo_gas' =>  ['required', 'string', 'max:255'],
                'estatus' =>  ['required', 'string', 'max:255'],
                'tipo_tanque' =>  ['required', 'string', 'max:255'],
            ]);
            $tanques=new Tanque;
            $tanques->num_serie = $request->input('num_serie');
            $tanques->ph = $request->input('ph');
            $tanques->capacidad = $request->input('capacidad');
            $tanques->material = $request->input('material');
            $tanques->fabricante = $request->input('fabricante');
            $tanques->tipo_gas = $request->input('tipo_gas');
            $tanques->estatus = $request->input('estatus');
            $tanques->tipo_tanque = $request->input('tipo_tanque');
            

            if($tanques->save()){
                $historytanques=new TanqueHistorial;
                $historytanques->num_serie = $request->input('num_serie');
                $historytanques->estatus = $request->input('estatus');
                $historytanques->observaciones ='Registro del tanque';
                $historytanques->save();
                return response()->json(['mensaje'=>' Registrado Correctamente']);
            }
            return response()->json(['mensaje'=>'No registrado']);
        }
        return response()->json(['mensaje'=>'Sin permisos']);
    }

    public function show( Tanque $id){
            return $id;
    }

    public function show_numserie($num_serie){
            $tanque=Tanque::where('num_serie',$num_serie)->first();
            return $tanque;
    }

    public function update(Request $request, $id){
        if($this->slug_permiso('tanque_update')){
            $this->validator($request->all(),$id)->validate();

            $tanques=  Tanque::find($id);
            $tanques->num_serie = $request->input('num_serie');
            $tanques->ph = $request->input('ph');
            $tanques->capacidad = $request->input('capacidad');
            $tanques->material = $request->input('material');
            $tanques->fabricante = $request->input('fabricante');
            $tanques->tipo_gas = $request->input('tipo_gas');
            $tanques->estatus = $request->input('estatus');
            $tanques->tipo_tanque = $request->input('tipo_tanque');

            if($tanques->save()){
                $historytanques=new TanqueHistorial;
                $historytanques->num_serie = $request->input('num_serie');
                $historytanques->estatus = $request->input('estatus');
                $historytanques->observaciones ='Edición de los datos del tanque';
                $historytanques->save();
                return response()->json(['mensaje'=>' Editado Correctamente']);
            }
            return response()->json(['mensaje'=>'No Editado']);
        }
        return response()->json(['mensaje'=>'Sin permisos']);
    }

    public function destroy( Tanque $id){
        if($this->slug_permiso('tanque_delete')){
            $id->delete();
            return response()->json(['mensaje'=>'exito']);
        }
        return response()->json(['mensaje'=>'Sin permisos']);
    }

    //////// Historial de tanques 

    public function history(Tanque $id){
        if($this->slug_permiso('tanque_history')){
            $data=['tanque'=>$id];
            return view('tanques.history', $data);
        }
        return view('home');
    }

    public function history_data($serietanque){
        if($this->slug_permiso('tanque_history')){
            $tanques=TanqueHistorial::
            select('tanque_historial.*')->where('num_serie',$serietanque);
            return DataTables::of(
                $tanques
            )
            ->editColumn('created_at', function ($user) {
                return $user->created_at->format('H:i:s A - d/m/Y');
            })
            ->toJson();
        }
        return view('home');
    }

    //// BAJAS de tanques 
    public function lista_bajas(){
        if($this->slug_permiso('tanque_show')){
            return view('tanques.lista_bajas');
        }
        return view('home');
    }

    public function lista_bajas_data(){
        if($this->slug_permiso('tanque_show')){
            $tanques=Tanque::
            select('tanques.*')
            ->where('estatus',"BAJA-TANQUE");
            return DataTables::of(
                $tanques
            )             
            ->addColumn( 'btnRestablecer', '<button class="btn btn-sm btn-verde btn-restore" data-id="{{$id}}" title="Restablecer"><i class="fas fa-trash-restore-alt"></i></button>')
            ->addColumn( 'btnHistory', '<a class="btn btn-sm btn-verde" href="{{route(\'tanques.history\', $id)}}" title="Historial"><span class="fas fa-history"></span></a>')
            ->addColumn( 'btnDelete', '<button class="btn btn-sm btn-verde btn-delete" data-id="{{$id}}" title="Eliminar"><i class="fas fa-trash-alt"></i></button>')
            ->rawColumns(['btnHistory','btnRestablecer', 'btnDelete'])
            ->toJson();
        }
        return view('home');
    }

    public function baja_tanque(Tanque $id){
        if($this->slug_permiso('tanque_delete')){
            $id->estatus = "BAJA-TANQUE";
            $id->save();

            $historytanques=new TanqueHistorial;
            $historytanques->num_serie = $id->num_serie;
            $historytanques->estatus = $id->estatus;
            $historytanques->observaciones ='Tanque dado de baja';
            $historytanques->save();

            return response()->json(['mensaje'=>'Eliminado Correctamente']);
            
        }
        return response()->json(['mensaje'=>'Sin permisos']);
    }

    public function restablecer_tanque(Tanque $id){
        if($this->slug_permiso('tanque_delete')){
            $id->estatus = "VACIO-ALMACEN";

            if($id->save()){
                $historytanques=new TanqueHistorial;
            $historytanques->num_serie = $id->num_serie;
            $historytanques->estatus = $id->estatus;
            $historytanques->observaciones ='Tanque restablecido como vacio en almacen';
            $historytanques->save();
                return response()->json(['mensaje'=>'Eliminado Correctamente']);
            }else{
                return response()->json(['mensaje'=>'Error al Eliminar']);
            }
        }
        return response()->json(['mensaje'=>'Sin permisos','accesso'=>'true']);
    }

    //// lISTAR tanques POR ESTATUS
    public function estatus_index(){
        if($this->slug_permiso('tanque_show')){
            $vacioalmacen= Tanque::where('estatus','VACIO-ALMACEN'); //analizar
            $llenoalmacen= Tanque::where('estatus','LLENO-ALMACEN');
            $infra= Tanque::where('estatus','INFRA');
            $mantenimiento= Tanque::where('estatus','MANTENIMIENTO');
            $entregadocliente= Tanque::where('estatus','ENTREGADO-CLIENTE');
            $ventaexporadica = Tanque::where('estatus','VENTA-EXPORADICA');
            $tanquecambiado= Tanque::where('estatus','TANQUE-CAMBIADO');
            
            $data=[
                'vacioalmacen'=>$vacioalmacen->count(), 
                'llenoalmacen'=>$llenoalmacen->count(), 
                'entregadocliente'=>$entregadocliente->count(),
                'infra'=>$infra->count(),
                'mantenimiento'=>$mantenimiento->count(),
                'ventaexporadica'=>$ventaexporadica->count(),
                'tanquecambiado'=>$tanquecambiado->count(),
            ];
            return view('tanques.estatus.index', $data);
        }
        return view('home');
    }
    public function estatus_data($estatus){

        if($this->slug_permiso('tanque_show')){
            $tanques=Tanque::
            select('tanques.*')->where('estatus', $estatus);

            return DataTables::of(
                $tanques
            )
            ->toJson();
        }
        return view('home');
    }

    //// REPORTES TANQUES
    public function reportados_index(){
        if($this->slug_permiso('tanque_show')){
            return view('tanques.reportes.index');
        }
        return view('home');
    }
    public function reportados_data(){
        if($this->slug_permiso('tanque_show')){
            $tanques=TanqueReportado::
            join('tanques','tanques.num_serie','tanques_reportados.num_serie')
            ->select('tanques.*','tanques_reportados.*', 'tanques_reportados.id as reporte_id', 'tanques.id as tanque_id');
            return DataTables::of(
                $tanques
            )                                                               
            ->addColumn( 'btnHistory', '<a class="btn btn-sm btn-verde btn-xs" href="{{route(\'tanques.history\', $tanque_id)}}" title="Historial"><span class="fas fa-history"></span></a>')
            ->addColumn( 'btbEliminar', '<button class="btn btn-sm btn-verde btn-eliminar btn-xs" data-id="{{$reporte_id}}" title="Baja"><span class="fas fa-trash"></span></button>')
            ->addColumn('descripcion', function ($tanques) {
                return "PH: ".$tanques->ph.", ".$tanques->fabricante.", ".$tanques->material.", ".$tanques->tipo_tanque;
            })
            ->rawColumns(['btnHistory','btbEliminar'])
            ->toJson();
        }
        return view('home');
    }

    public function reportados_create(){
        if($this->slug_permiso('tanque_report')){
            return view('tanques.reportes.create');
        }
        return view('home');
    }

    public function reportados_save(Request $request){
        
        if($this->slug_permiso('tanque_report')){
            $tanque=Tanque::where('num_serie',$request->num_serie)->first();
            
            if($tanque){
                $report=new TanqueReportado();
                $report->num_serie = $request->num_serie;
                $report->observaciones = $request->observaciones;
                $report->save();

                $tanque->estatus='TANQUE-REPORTADO';
                $tanque->save();
                
                $historytanques=new TanqueHistorial;
                $historytanques->num_serie = $request->num_serie;
                $historytanques->estatus = $tanque->estatus;
                $historytanques->observaciones ='tanque reportado, #num. de reporte: '. $report->id;
                $historytanques->save();    

                return response()->json(['mensaje'=>true]);
            }
            return response()->json(['mensaje'=>false]);
        }
        return view('home');
    }

    public function reportados_eliminar($id){
        if($this->slug_permiso('tanque_report')){
            $reporte= TanqueReportado::find($id);
            $tanque=Tanque::where('num_serie',$reporte->num_serie)->first();
            if($tanque){
                $reporte->delete();
                $tanque->estatus='VACIO-ALMACEN';
                $tanque->save();

                $historytanques=new TanqueHistorial;
                $historytanques->num_serie = $tanque->num_serie;
                $historytanques->estatus = $tanque->estatus;
                $historytanques->observaciones ='Reporte Eliminado, el tanque cambio a estatus: VACIO-ALMACEN';
                $historytanques->save();
                return response()->json(['mensaje'=>true]);
            }else{
                $reporte->delete();
                return response()->json(['mensaje'=>true]);
            }
        }
        return view('home');
    }
}