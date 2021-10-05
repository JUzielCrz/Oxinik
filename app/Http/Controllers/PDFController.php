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
use App\Models\NotaPagos;
use App\Models\VentaExporadica;
use App\Models\VentaTanque;

// include 'App\Funciones\ConvertNumber';

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

    public function pdf_nota_exporadica($idnota){
        $nota=VentaExporadica::find($idnota);
        $tanques=VentaTanque::
        join('tanques', 'tanques.num_serie','=','venta_tanque.num_serie' )
        ->where('venta_id', $nota->id)->get();
        
        $data=['nota'=>$nota,'tanques'=>$tanques];
 
        $pdf = PDF::loadView('pdf.nota_exporadica', $data);

        return $pdf->stream('nota_exporadica_'.$nota->folio_nota.'.pdf');
        return $pdf->dowload('name.pdf');
    }


    public function asignacion_tanques($nota_id){
        $nota= AsignacionNota::find($nota_id);
        
        $contrato=Contrato::select('cliente_id','num_contrato', 'deposito_garantia')->where('id',$nota->contrato_id)->first();

        $cliente=Cliente::select('nombre','apPaterno','apMaterno')->where('id',$contrato->cliente_id)->first();

        $detalleNota= AsignacionNotaDetalle::
        join('catalogo_gases','catalogo_gases.id','=','detalle_nota_asignacion.tipo_gas')
        ->where('detalle_nota_asignacion.nota_asignacion_id', $nota_id)->get();

        $asignaciones_all=Asignacion::where('contratos_id',$nota->contrato_id)->get();

        
        $data=['detalleNota'=>$detalleNota, 'nota'=>$nota, 'contrato'=>$contrato, 'cliente'=>$cliente, 'asignaciones_all'=>$asignaciones_all];

        $pdf = PDF::loadView('pdf.asignaciontanque', $data);
        return $pdf->stream('asignaciontanque_'.$nota_id.'.pdf');
    }

    public function generar_contrato($idcontrato){
        $contrato=Contrato::find($idcontrato);
        $cliente=Cliente::find($contrato->cliente_id);
        
        $nota=AsignacionNota::where('contrato_id', $contrato->id)->first();

        $tanques=AsignacionNotaDetalle::
        join('nota_asignacion','nota_asignacion.id','=','detalle_nota_asignacion.nota_asignacion_id')
        ->join('catalogo_gases','catalogo_gases.id','=','detalle_nota_asignacion.tipo_gas')
        ->where('nota_asignacion_id', $nota->id)
        ->where('incidencia','INICIO-CONTRATO')
        ->get();

        $objeto = new ConvertNumberController();
        $precioLetras = $objeto->num2letras($contrato->deposito_garantia); 

        $data=['contrato'=>$contrato, 'cliente'=>$cliente, 'tanques'=>$tanques, 'nota'=>$nota, 'precioLetras'=>$precioLetras];

        $pdf = PDF::loadView('pdf.contratogenerate', $data);
        return $pdf->stream('contrato_'. $contrato->num_contrato.'.pdf');
    }
}
