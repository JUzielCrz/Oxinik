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

<div id="row-envio" >
    <button id="btn-addEnvio" type="button" class="btn btn-sm btn-amarillo" > <span class="fas fa-plus"></span> Agregar Envio</button>
</div>

<input id="precio_envio_nota" name="precio_envio_nota" type="hidden" value=0 >
<hr>

<div class="row">
    <div class="col-md-5">
        <label for="">TOTAL: $ </label>
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
    <div class="input-group input-group-sm mb-2">
        <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-sm">Metodo de pago:</span>
        </div>
        {{ Form::select('metodo_pago',[
            'Efectivo' => 'Efectivo',
            'Transferencia' => 'Transferencia', 
            'Tarjeta Credito' => 'Tarjeta Credito', 
            'Tarjeta Debito' => 'Tarjeta Debito',  
            'Cheque' => 'Cheque',
            'Credito' => 'Credito'
            ],null,['id' => 'metodo_pago','class'=>'form-control form-control-sm', 'placeholder'=>'Selecciona'])}}
    </div>
    <span id="metodo_pagoError" class="alert-danger  mb-2"></span>
</div> 


<div class="form-row" id="row-ingreso-efectivo">
    <div class="input-group input-group-sm mb-2">
        <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-sm">Ingreso de Efectivo:</span>
        </div>
        <input id="ingreso-efectivo" type="number" class="form-control" value=0 disabled>
    </div>
    <span id="ingreso-efectivoError" class="alert-danger"></span>
</div>

<hr>

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