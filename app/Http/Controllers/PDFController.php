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
use App\Models\DatosEmpresa;
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
        $empresa=DatosEmpresa::find(1);
        
        $data=['nota'=>$nota,'tanques'=>$tanques, 'contrato'=>$contrato, 'cliente'=>$cliente, 'empresa'=>$empresa];
 
        $pdf = PDF::loadView('pdf.nota', $data);

        return $pdf->stream('nota_'.$nota->id.'.pdf');
        // return $pdf->dowload('name.pdf');
    }

    public function pdf_nota_exporadica($idnota){
        $nota=VentaExporadica::find($idnota);
        $tanques=VentaTanque::
        join('tanques', 'tanques.num_serie','=','venta_tanque.num_serie' )
        ->where('venta_id', $nota->id)->get();
        $empresa=DatosEmpresa::find(1);

        $data=['nota'=>$nota,'tanques'=>$tanques, 'empresa'=>$empresa];
 
        $pdf = PDF::loadView('pdf.nota_exporadica', $data);

        return $pdf->stream('nota_exporadica_'.$nota->id.'.pdf');
        return $pdf->dowload('name.pdf');
    }

    public function asignacion_tanques($nota_id){
        $nota= AsignacionNota::find($nota_id);
        
        $contrato=Contrato::select('cliente_id','id')->where('id',$nota->contrato_id)->first();

        $cliente=Cliente::select('nombre','apPaterno','apMaterno')->where('id',$contrato->cliente_id)->first();

        $detalleNota= AsignacionNotaDetalle::
        join('catalogo_gases','catalogo_gases.id','=','detalle_nota_asignacion.tipo_gas')
        ->where('detalle_nota_asignacion.nota_asignacion_id', $nota_id)->get();

        $asignaciones_all=Asignacion::join('catalogo_gases','catalogo_gases.id','=','asignacion.tipo_gas')
        ->where('contratos_id',$nota->contrato_id)->get();

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
        $precioLetras = $objeto->toMoney($tanques->sum('deposito_garantia'), 2, 'PESOS','CENTAVOS');

        $data=['contrato'=>$contrato, 'cliente'=>$cliente, 'tanques'=>$tanques, 'nota'=>$nota, 'precioLetras'=>$precioLetras];

        if($contrato->tipo_contrato == 'Eventual'){
            $pdf = PDF::loadView('pdf.contrato_eventual', $data);
        }else{
            $pdf = PDF::loadView('pdf.contrato_general', $data);
        }
        return $pdf->stream('contrato_'. $contrato->id.'.pdf');
    }

    public function infra_nota($idnota){
        $nota=InfraLLenado::find($idnota);
        $tanques=InfraTanque::where('infrallenado_id', $nota->id)->get();
        
        $data=['nota'=>$nota,'tanques'=>$tanques];
 
        $pdf = PDF::loadView('pdf.infra_nota', $data);

        return $pdf->stream('nota_infra_'.$nota->id.'.pdf');
        // return $pdf->dowload('name.pdf');
    }

    public function mantenimiento_nota($idnota){
        $nota=MantenimientoLLenado::find($idnota);
        $tanques=MantenimientoTanque::
        join('tanques', 'tanques.num_serie', '=','mantenimiento_tanques.num_serie')
        ->where('mantenimientollenado_id', $nota->id)->get();
        
        $data=['nota'=>$nota,'tanques'=>$tanques];
 
        $pdf = PDF::loadView('pdf.mantenimiento_nota', $data);

        return $pdf->stream('nota_mantenimiento_'.$nota->id.'.pdf');
        // return $pdf->dowload('name.pdf');
    }

    public function pdf_nota_foranea($idnota){
        $nota=NotaForanea::find($idnota);
        $tanques=NotaForaneaTanque::
        join('tanques', 'tanques.num_serie','=','notaforanea_tanque.num_serie' )
        ->where('nota_foranea_id', $nota->id)->get();

        $cliente=ClienteSinContrato::find($nota->cliente_id);
        $empresa=DatosEmpresa::find(1);

        $data=['nota'=>$nota,'tanques'=>$tanques,'cliente' => $cliente,'empresa'=>$empresa];
        $pdf = PDF::loadView('pdf.nota_foranea', $data);

        return $pdf->stream('nota_foranea_'.$nota->id.'.pdf');
        return $pdf->dowload('name.pdf');
    }

    public function pdf_nota_talon($idnota){
        $nota=NotaTalon::find($idnota);
        $tanques=NotaTalonTanque::
        join('tanques', 'tanques.num_serie','=','nota_talontanque.num_serie' )
        ->where('nota_talon_id', $nota->id)->get();
        $empresa=DatosEmpresa::find(1);

        $data=['nota'=>$nota,'tanques'=>$tanques,'empresa'=>$empresa];
        $pdf = PDF::loadView('pdf.nota_talon', $data);
    
        return $pdf->stream('nota_talon_'.$nota->id.'.pdf');
        return $pdf->dowload('name.pdf');
    }


    public function pdf_tanque_barras($num_serie){
        $tanque=Tanque::
        join('catalogo_gases', 'catalogo_gases.id', 'tanques.tipo_gas')->select('catalogo_gases.nombre as gas_nombre', 'tanques.*')->where('num_serie',$num_serie)->first();
        
        $pdf = PDF::loadView('pdf.etiqueta_tanque', $tanque);
        return $pdf->setPaper(array(0, 0, 100, 200), 'landscape')->stream('nota_mantenimiento_'.$tanque->num_serie.'.pdf');
    }
}


