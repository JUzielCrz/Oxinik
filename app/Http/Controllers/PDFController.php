<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Contrato;
use App\Models\ContratoAsignacionTanques;
use App\Models\Nota;
use App\Models\NotaTanque;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;

class PDFController extends Controller
{
    
    public function pdf_nota($idnota){
        $nota=Nota::find($idnota);
        $tanques=NotaTanque::
        join('tanques', 'tanques.num_serie','=','nota_tanque.num_serie' )
        ->where('folio_nota', $nota->folio_nota)->get();
        $contrato=Contrato::where('num_contrato', $nota->num_contrato)->first();
        $cliente=Cliente::where('id', $contrato->cliente_id)->first();

        
        $data=['nota'=>$nota,'tanques'=>$tanques, 'contrato'=>$contrato, 'cliente'=>$cliente];
 
        $pdf = PDF::loadView('pdf.nota', $data);

        return $pdf->stream('nota_'.$nota->folio_nota.'.pdf');
        // return $pdf->dowload('name.pdf');
    }

    public function asignacion_tanques($idasignacion){
        $asignacion= ContratoAsignacionTanques::where('id', $idasignacion)->first();

        $data=['asignacion'=>$asignacion];

        $pdf = PDF::loadView('pdf.asignaciontanque', $data);
        return $pdf->stream('asignaciontanque_'.$idasignacion.'.pdf');
    }

}
