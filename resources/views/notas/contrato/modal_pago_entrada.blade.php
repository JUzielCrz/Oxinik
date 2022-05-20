<fieldset class="InputsFilaEntrada" disabled="disabled">
    <div class="card mt-2">
        <div class="card-body">

            <div class="form-row">
                <div class="input-group input-group-sm mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-sm">Recargos por tapa:</span>
                    </div>
                    <input id="recargosXtapa" name="recargosXtapa" type="number" class="form-control" value=0 aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" readonly>
                </div>
            </div> 

            <div class="form-row">
                <div class="input-group input-group-sm mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-sm">Otros Recargos:</span>
                    </div>
                    <input id="recargos" name="recargos" type="number" value=0 class="form-control numero-decimal-positivo" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" >
                </div>
                <span id="recargosError" class="alert-danger  mb-3"></span>
            </div> 

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
                        <span class="input-group-text" id="inputGroup-sizing-sm">Metodo de Pago:</span>
                    </div>
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
        </div>
    </div>
    </fieldset>