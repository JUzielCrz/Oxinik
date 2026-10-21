<?php

namespace App\Http\Controllers;

use App\Models\CatalogoGas;
use App\Models\InfraLLenado;
use App\Models\InfraTanque;
use App\Models\Tanque;
use App\User;
use App\Http\Requests\InfraSalidaRequest;
use App\Services\InfraSalidaService;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class InfraController extends Controller
{

    protected $infraSalidaService;

    public function __construct(InfraSalidaService $infraSalidaService)
    {
        $this->middleware('auth');
        $this->infraSalidaService = $infraSalidaService;
    }

    public function index(){
        $responsables = User::whereIn(
            'id',
            InfraLLenado::whereNotNull('user_id')->distinct()->pluck('user_id')
        )->orderBy('name')->pluck('name', 'id');

        return view('infra.index', compact('responsables'));
    }

    public function data(Request $request){
        $query = $this->infraQuery();
        $filteredQuery = $this->infraQuery();
        $this->applyInfraFilters($query, $request);
        $this->applyInfraFilters($filteredQuery, $request);
        $this->applyGlobalSearch($filteredQuery, $request->input('search.value'));

        $summary = $this->buildSummary($filteredQuery);

        return DataTables::of($query)
            ->filter(function ($dataTableQuery) use ($request) {
                $this->applyGlobalSearch($dataTableQuery, $request->input('search.value'));
            }, false)
            ->editColumn('created_at', function ($infra) {
                return $infra->created_at
                    ? $infra->created_at->format('Y/m/d - H:i:s A')
                    : '—';
            })
            ->editColumn('cantidad_entrada', function ($infra) {
                return $infra->cantidad_entrada === null ? null : (int) $infra->cantidad_entrada;
            })
            ->addColumn('mostrar_diferencia', function ($infra) {
                if ($infra->cantidad_entrada === null) {
                    return null;
                }

                return $infra->pendiente == true && (int) $infra->cantidad_diferencia > 0
                    ? (int) $infra->cantidad_diferencia
                    : 0;
            })
            ->addColumn('estado', function ($infra) {
                return $this->statusBadge($infra);
            })
            ->addColumn('acciones', function ($infra) {
                $actions = '<div class="infra-record-actions">';

                if ($infra->cantidad_entrada === null || ($infra->pendiente == true && (int) $infra->cantidad_diferencia > 0)) {
                    $label = $infra->cantidad_entrada === null ? 'Registrar entrada' : 'Revisar entrada';
                    $actions .= '<a class="btn btn-verde btn-sm" href="'.route('infra.entrada', $infra->id).'" data-toggle="tooltip" data-placement="top" title="'.$label.'">'
                        .'<i class="fas fa-warehouse" aria-hidden="true"></i><span class="sr-only">'.$label.'</span></a>';
                }

                $actions .= '<button type="button" class="btn btn-verde btn-show btn-sm" data-id="'.$infra->id.'" data-toggle="tooltip" data-placement="top" title="Ver detalle">'
                    .'<span class="far fa-eye" aria-hidden="true"></span><span class="sr-only">Ver detalle</span></button>';
                $actions .= '<a class="btn btn-verde btn-sm" href="'.route('pdf.infra_nota', $infra->id).'" target="_blank" rel="noopener" data-toggle="tooltip" data-placement="top" title="Descargar PDF">'
                    .'<i class="fas fa-file-pdf" aria-hidden="true"></i><span class="sr-only">Descargar PDF</span></a>';

                return $actions.'</div>';
            })
            ->rawColumns(['estado', 'acciones'])
            ->with('summary', $summary)
            ->toJson();
    }

    
    public function salida(){
        return view('infra.salida');
    }

    public function salida_save(InfraSalidaRequest $request){
        $infra = $this->infraSalidaService->registrar(
            $request->input('inputNumSerie'),
            $request->input('cantidad'),
            auth()->user()->id
        );

        return response()->json(['notaId' => $infra->id]);

    }

    public function entrada($id){
        $catalogo = CatalogoGas::pluck('nombre','id');
        $nota_salida = InfraLLenado::findOrFail($id);
        $tanques= InfraTanque::
        join('tanques','tanques.num_serie','=','infra_tanques.num_serie')->select('tanques.*')->where('infrallenado_id',$id)->where('incidencia','ENTRADA')->get();
        $data=['catalogo'=> $catalogo, 'nota'=>$nota_salida,'tanques'=>$tanques];
        return view('infra.entrada', $data);
    }

    public function entrada_save(Request $request){
        $request->validate([
            'cantidad_entrada' => ['required', 'int'],
            'inputEstatus' => ['required', 'array'],
            'inputEstatus.*' => ['required', 'string', 'max:255']
        ]);
        if ($request->cantidad_entrada > $request->cantidad_salida) {
            return response()->json(['alert'=>'error', 'mensaje'=>'Cantidad Entrada no puede ser mayor a cantidad salida']);
        }

        if($request->pendiente == null){
            $vapendiente =true;
        }else{
            $vapendiente =false;
        }
        $infra=InfraLLenado::findOrFail($request->nota_id);
        $infra->cantidad_entrada= $request->cantidad_entrada;
        $infra->cantidad_diferencia= $request->cantidad_diferencia;
        $infra->pendiente=  $vapendiente;
        $infra->observaciones= $request->observaciones;
        $infra->user_id = auth()->user()->id;
        $infra->save();

            foreach( $request->inputNumSerie AS $series => $g){
                if(InfraTanque::where('num_serie',$request->inputNumSerie[$series])->where('infrallenado_id', $infra->id)->where('incidencia','ENTRADA')->first() == null){
                    $infratanque=new InfraTanque;
                    $infratanque->num_serie = $request->inputNumSerie[$series];
                    $infratanque->infrallenado_id = $infra->id;
                    $infratanque->incidencia = 'ENTRADA';
                    $infratanque->save();

                    $tanque=Tanque::where('num_serie',$request->inputNumSerie[$series])->first();
                    $tanque->estatus = $request->inputEstatus[$series];
                    $tanque->save();
                }
            }
            return response()->json(['alert'=>'success', 'mensaje'=>'Registrado Correctamente']);

    }

    public function show(InfraLLenado $id){
        $tanques=InfraTanque::
            join('tanques', 'tanques.num_serie', 'infra_tanques.num_serie')
            ->where('infrallenado_id', $id->id)
            ->get();
        $usuario= User::select('name')->where('id', $id->user_id)->first();
        $data = ['infranota'=>$id, 'tanques' => $tanques, 'usuario'=>$usuario];
        return view('infra.show', $data);
    }

    protected function infraQuery()
    {
        return InfraLLenado::query()
            ->leftJoin('users', 'users.id', '=', 'infra_llenado.user_id')
            ->select('infra_llenado.*', 'users.name as responsable');
    }

    protected function applyInfraFilters($query, Request $request)
    {
        if ($request->filled('status')) {
            $this->applyStatusFilter($query, $request->input('status'));
        }

        if ($request->filled('date_from') && preg_match('/^\d{4}-\d{2}-\d{2}$/', $request->input('date_from'))) {
            $query->whereDate('infra_llenado.created_at', '>=', $request->input('date_from'));
        }

        if ($request->filled('date_to') && preg_match('/^\d{4}-\d{2}-\d{2}$/', $request->input('date_to'))) {
            $query->whereDate('infra_llenado.created_at', '<=', $request->input('date_to'));
        }

        if ($request->filled('note_id') && is_numeric($request->input('note_id'))) {
            $query->where('infra_llenado.id', (int) $request->input('note_id'));
        }

        if ($request->filled('user_id') && is_numeric($request->input('user_id'))) {
            $query->where('infra_llenado.user_id', (int) $request->input('user_id'));
        }
    }

    protected function applyGlobalSearch($query, $term)
    {
        $term = trim((string) $term);

        if ($term === '') {
            return;
        }

        $like = '%'.$term.'%';
        $normalizedTerm = function_exists('mb_strtolower') ? mb_strtolower($term, 'UTF-8') : strtolower($term);

        $query->where(function ($search) use ($like, $normalizedTerm) {
            $search->where('infra_llenado.id', 'like', $like)
                ->orWhere('infra_llenado.created_at', 'like', $like)
                ->orWhere('users.name', 'like', $like);

            if (strpos($normalizedTerm, 'pendiente') !== false) {
                $search->orWhereNull('infra_llenado.cantidad_entrada');
            }

            if (strpos($normalizedTerm, 'diferencia') !== false) {
                $search->orWhere(function ($difference) {
                    $this->whereDifference($difference);
                });
            }

            if (strpos($normalizedTerm, 'complet') !== false) {
                $search->orWhere(function ($complete) {
                    $this->whereCompleted($complete);
                });
            }
        });
    }

    protected function applyStatusFilter($query, $status)
    {
        switch ($status) {
            case 'pending':
                $query->whereNull('infra_llenado.cantidad_entrada');
                break;
            case 'difference':
                $this->whereDifference($query);
                break;
            case 'complete':
                $this->whereCompleted($query);
                break;
        }
    }

    protected function whereDifference($query)
    {
        $query->whereNotNull('infra_llenado.cantidad_entrada')
            ->where('infra_llenado.pendiente', true)
            ->where('infra_llenado.cantidad_diferencia', '>', 0);
    }

    protected function whereCompleted($query)
    {
        $query->whereNotNull('infra_llenado.cantidad_entrada')
            ->where(function ($completed) {
                $completed->whereNull('infra_llenado.pendiente')
                    ->orWhere('infra_llenado.pendiente', false)
                    ->orWhere('infra_llenado.cantidad_diferencia', '<=', 0);
            });
    }

    protected function buildSummary($query)
    {
        return [
            'total' => (clone $query)->count('infra_llenado.id'),
            'pending' => (clone $query)->whereNull('infra_llenado.cantidad_entrada')->count('infra_llenado.id'),
            'difference' => (clone $query)->where(function ($difference) {
                $this->whereDifference($difference);
            })->count('infra_llenado.id'),
            'complete' => (clone $query)->where(function ($complete) {
                $this->whereCompleted($complete);
            })->count('infra_llenado.id'),
            'pending_cylinders' => (int) (clone $query)->where(function ($difference) {
                $this->whereDifference($difference);
            })->sum('infra_llenado.cantidad_diferencia'),
        ];
    }

    protected function statusBadge($infra)
    {
        if ($infra->cantidad_entrada === null) {
            return '<span class="infra-status infra-status-pending">Pendiente de entrada</span>';
        }

        if ($infra->pendiente == true && (int) $infra->cantidad_diferencia > 0) {
            return '<span class="infra-status infra-status-difference">Con diferencia</span>';
        }

        return '<span class="infra-status infra-status-complete">Completada</span>';
    }

}
