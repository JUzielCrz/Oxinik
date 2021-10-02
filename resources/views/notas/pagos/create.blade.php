@csrf
<span><strong>INFORMACIÓN</strong></span>
    <div class="input-group input-group-sm mb-3">
        <div class="input-group-prepend">
        <span class="input-group-text" id="basic-addon1">Total de la nota:</span>
        </div>
        <input type="number" class="form-control" value="{{$nota->total}}" readonly>
    </div>
    <div class="input-group input-group-sm mb-3">
        <div class="input-group-prepend">
        <span class="input-group-text" id="basic-addon1">Cantidad cubierta::</span>
        </div>
        <input type="number" class="form-control" value="{{$suma_pagos}}" readonly>
    </div>

    <div class="input-group input-group-sm mb-3">
        <div class="input-group-prepend">
        <span class="input-group-text" id="basic-addon1">Adeudo:</span>
        </div>
        <input type="number" class="form-control" id="adeudo" value="{{$adeudo}}" readonly>
    </div>

    <span><strong>PAGO</strong></span>

    <div class="input-group input-group-sm mb-3">
        <div class="input-group-prepend">
        <span class="input-group-text" id="basic-addon1">Monto a Pagar:</span>
        </div>
        <input type="number" name="monto_pago" id="monto_pago" class="form-control" placeholder="$0.0">
    </div>

    <div class="input-group input-group-sm mb-3">
        <div class="input-group-prepend">
        <span class="input-group-text" id="basic-addon1">Metodo de pago:</span>
        </div>
        <select name="metodo_pago" id="metodo_pago" class="form-control">
            <option value="">Selecciona</option>
            <option value="Efectivo">Efectivo</option>
            <option value="Transferencia">Transferencia</option>
            <option value="Tarjeta Credito">Tarjeta Credito</option>
            <option value="Tarjeta Debito">Tarjeta Debito</option>
            <option value="Cheque">Cheque</option>
        </select>
    </div>
