@php
    $cuenta1Visible = trim((string) $empresa->titular1) !== ''
        || trim((string) $empresa->banco1) !== ''
        || trim((string) $empresa->num_cuenta1) !== ''
        || trim((string) $empresa->clave1) !== ''
        || trim((string) $empresa->num_tarjeta1) !== '';
    $cuenta2Visible = trim((string) $empresa->titular2) !== ''
        || trim((string) $empresa->banco2) !== ''
        || trim((string) $empresa->num_cuenta2) !== ''
        || trim((string) $empresa->clave2) !== ''
        || trim((string) $empresa->num_tarjeta2) !== '';
    $cuentasVisibles = ($cuenta1Visible ? 1 : 0) + ($cuenta2Visible ? 1 : 0);
    $colspanCuenta = $cuentasVisibles === 1 ? 2 : 1;
@endphp

@if ($cuentasVisibles > 0)
    <table class="table table-sm table-bordered mt-2" style="font-size: {{ $bankTableFontSize ?? '12px' }}">
        <tbody>
            <tr style="background: black">
                <td colspan="2"><div class="text-center text-white"> CUENTAS BANCARIAS PARA TRANSFERENCIAS</div></td>
            </tr>
            <tr>
                <td colspan="2" class="text-center">
                    RFC: <strong>{{$empresa->rfc}}</strong> <br>
                </td>
            </tr>
            <tr>
                @if ($cuenta1Visible)
                    <td colspan="{{$colspanCuenta}}">
                        <p class="p-0 m-0">
                            Titular: <strong>{{$empresa->titular1}}</strong> <br>
                            BANCO: <strong>{{$empresa->banco1}}</strong> <br>
                            # CUENTA: <strong>{{$empresa->num_cuenta1}}</strong> <br>
                            CLABE: <strong>{{$empresa->clave1}}</strong> <br>
                            @if (trim((string) $empresa->num_tarjeta1) !== '')
                                # TARJETA: <strong>{{$empresa->num_tarjeta1}}</strong> <br>
                            @endif
                        </p>
                    </td>
                @endif
                @if ($cuenta2Visible)
                    <td colspan="{{$colspanCuenta}}">
                        <p class="p-0 m-0">
                            Titular: <strong>{{$empresa->titular2}}</strong> <br>
                            BANCO: <strong>{{$empresa->banco2}}</strong> <br>
                            # CUENTA: <strong>{{$empresa->num_cuenta2}}</strong> <br>
                            CLABE: <strong>{{$empresa->clave2}}</strong> <br>
                            @if (trim((string) $empresa->num_tarjeta2) !== '')
                                # TARJETA: <strong>{{$empresa->num_tarjeta2}}</strong> <br>
                            @endif
                        </p>
                    </td>
                @endif
            </tr>
            <tr>
                <td colspan="2">
                    <p class="p-0 m-0">
                        ASÍ MISMO SE LES PIDE ENVIAR COMPROBANTE DE PAGO AL SIGUIENTE CORREO: <strong>{{$empresa->email}}</strong><br>
                        HACIENDO REFERENCIA EN CONCEPTO ALGUNO DE LOS SIGUIENTES:<br>
                            * FOLIO DE FACTURA<br>
                            * NÚMERO DE VALE O TICKET DE VENTA<br>
                            * NÚMERO DE FOLIO DE HOJA DE CONTRATO.<br>
                        ESTAMOS A SUS ORDENES
                    </p>
                </td>
            </tr>
        </tbody>
    </table>
@endif
