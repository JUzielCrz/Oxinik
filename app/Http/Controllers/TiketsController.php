<?php

namespace App\Http\Controllers;

use App\Models\Asignacion;
use App\Models\AsignacionNota;
use App\Models\AsignacionNotaDetalle;
use App\Models\Cliente;
use App\Models\Contrato;
use App\Models\Nota;
use App\Models\NotaTanque;
use Barryvdh\DomPDF\Facade as PDF;
// use App\Funciones\ConvertNumber;
use App\Http\Controllers\ConvertNumber;
use App\Models\ClienteSinContrato;
use App\Models\InfraLLenado;
use App\Models\InfraTanque;
use App\Models\MantenimientoLLenado;
use App\Models\MantenimientoTanque;
use App\Models\NotaForanea;
use App\Models\NotaForaneaTanque;
use App\Models\NotaTalon;
use App\Models\NotaTalonTanque;
use App\Models\Tanque;
use App\Models\VentaExporadica;
use App\Models\VentaTanque;

class TiketsController extends Controller
{
    //1 punto tipografico = 2.83465    80mm=226.772 segun google
    public function cotrato_nota_salida($idnota){
        $nota=Nota::find($idnota);
        $tanques=NotaTanque::
        join('tanques', 'tanques.num_serie','=','nota_tanque.num_serie' )
        ->where('nota_id', $nota->id)->get();
        $contrato=Contrato::where('id', $nota->contrato_id)->first();
        $cliente=Cliente::where('id', $contrato->cliente_id)->first();

        $list_tanq=count($tanques);
        $large= ($list_tanq*75)+320;

        if ($nota->pago_cubierto == false) {
            $large = $large+60;
        }

        $data=['nota'=>$nota,'tanques'=>$tanques, 'contrato'=>$contrato, 'cliente'=>$cliente];
        $pdf = PDF::loadView('tikets.cotrato_nota_salida', $data);
        
        return $pdf->setPaper(array(0, 0, 210, $large))->stream('nota_'.$nota->id.'.pdf');
        // return $pdf->setPaper(array(0, 0, 80, $large))->stream('nota_'.$nota->id.'.pdf');
        // return $pdf->dowload('name.pdf');  
    }
}
