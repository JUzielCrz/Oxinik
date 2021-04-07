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

class PDFController extends Controller
{
    
    public function pdf_nota($idnota){
        $nota=Nota::find($idnota);
        $tanques=NotaTanque::
        join('tanques', 'tanques.num_serie','=','nota_tanque.num_serie' )
        ->where('nota_id', $nota->id)->get();
        $contrato=Contrato::where('id', $nota->contrato_id)->first();
        $cliente=Cliente::where('id', $contrato->cliente_id)->first();

        
        $data=['nota'=>$nota,'tanques'=>$tanques, 'contrato'=>$contrato, 'cliente'=>$cliente];
 
        $pdf = PDF::loadView('pdf.nota', $data);

        return $pdf->stream('nota_'.$nota->folio_nota.'.pdf');
        // return $pdf->dowload('name.pdf');
    }

    public function asignacion_tanques($nota_id){
        $nota= AsignacionNota::
        join('contratos','contratos.id','=','nota_asignacion.contrato_id')
        ->where('nota_asignacion.id',$nota_id)->first();

        $detalleNota= AsignacionNotaDetalle::
        join('catalogo_gases','catalogo_gases.id','=','detalle_nota_asignacion.tipo_gas')
        ->where('detalle_nota_asignacion.nota_asignacion_id', $nota_id)->get();

        
        $data=['detalleNota'=>$detalleNota, 'nota'=>$nota];

        $pdf = PDF::loadView('pdf.asignaciontanque', $data);
        return $pdf->stream('asignaciontanque_'.$nota_id.'.pdf');
    }

}
