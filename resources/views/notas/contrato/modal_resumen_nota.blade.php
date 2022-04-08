<div class="form-row ">
    <div class="col-md-6">
        <label for="">Subtotal:</label>
    </div>
    <div class="col-md-5 text-right">
        <div id="div-subtotal">
            <label id='label-subtotal'>$0.0</label>
        </div>
        <input type="hidden" id="input-subtotal" name="input-subtotal" value=0>
    </div>
</div>
<div class="form-row ">
    <div class="col-md-6">
        <label for="">Iva 16%:</label>
    </div>
    <div class="col-md-5 text-right">
        <div id="div-ivaGen">
            <label id='label-ivaGen'>$0.0</label>
        </div>
        <input type="hidden" id="input-ivaGen" name="input-ivaGen" value=0>
    </div>
</div>

<center>
    <div id="msg-envio-save" style="display:none" class="alert" role="alert" style="font-size: 13px">
    </div>
</center>
<div id="row-envio" >
    <button id="btn-addEnvio" type="button" class="btn btn-sm btn-amarillo" > <span class="fas fa-plus"></span> Agregar Envio</button>
</div>
<input type="hidden" name="precio_envio" id="precio_envio" value= 0 >

<hr>

<div class="row">
    <div class="col-md-5">
        <label for="">TOTAL:</label>
    </div>
    <div class="col-md-6 text-right">
        <div id="div-total">
            <label id='label-total'>$0.0</label>
        </div>
        <input type="hidden" id="input-total" name="input-total">
    </div>
</div>

<hr>

<div class="form-row">
    <div class="input-group input-group-sm mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-sm">Monto a pagar:</span>
        </div>
        <input id="monto_pago" name="monto_pago" type="number" class="form-control numero-decimal-positivo" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" >
        {{ Form::select('metodo_pago',[
            'Efectivo' => 'Efectivo',
            'Transferencia' => 'Transferencia', 
            'Tarjeta Credito' => 'Tarjeta Credito', 
            'Tarjeta Debito' => 'Tarjeta Debito',  
            'Cheque' => 'Cheque'
            ],null,['id' => 'metodo_pago','class'=>'form-control form-control-sm', 'placeholder'=>'Selecciona'])}}
    </div>
    <span id="metodo_pagoError" class="alert-danger  mb-3"></span>
</div> 


<div class="form-row" id="row-ingreso-efectivo">
    <div class="input-group input-group-sm mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-sm">Ingreso de Efectivo:</span>
        </div>
        <input id="ingreso-efectivo" type="number" class="form-control" value=0 disabled>
    </div>
    <span id="ingreso-efectivoError" class="alert-danger"></span>
</div>

<hr>



{{-- FOrmulario --}}
<div class="row justify-content-center">
    <div class="col-md-4">
        <label for="">Cambio:</label>
    </div>
    <div class="col-md-4 text-right">
        <div id="div-cambio">
            <label id='label-cambio'>$0.0</label>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-md-4">
        <label for="">Adeudo:</label>
    </div>
    <div class="col-md-4 text-right">
        <div id="div-adeudo">
            <label id='label-adeudo'>$0.0</label>
        </div>
    </div>
</div>