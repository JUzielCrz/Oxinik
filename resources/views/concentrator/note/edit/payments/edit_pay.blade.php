<form id="form_update_payment">
    @csrf
    <input type="hidden" id="payment_id">
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col table-responsive">
                <table class="table table-sm">
                    <tbody>
                        <tr>
                            <td ><h5 class="text-end">SubTotal: </h5></td>
                            <td><h5>$ <span id="modal-subtotal"></span></h5></td>
                        </tr>
                        <tr>
                            <td ><h5 class="text-end">IVA: </h5></td>
                            <td><h5>$ <span id="modal-iva"></span></h5></td>
                        </tr>
                        <tr>
                            <td ><h5 class="text-end">Total: </h5></td>
                            <td><h5>$ <span id="modal-total"></span></h5></td>
                        <input type="hidden" id="total_pay">
                        </tr>
                    </tbody>
                </table>
            </div> 
        </div>
    </div>
</div>
<hr>
<div class="card mt-3">
    <div class="card-body">
        <div class="row ">
            
            <div class="col-12">
                <label for="">Método de pago: </label>
                <select name="payment_method" id="payment_method" class="form-control form-control-sm">
                    <option value="">Selecciona</option>
                    <option value="Efectivo">Efectivo</option>
                    <option value="Transferencia">Transferencia</option>
                    <option value="Tarjeta Credito">Tarjeta Credito</option>
                    <option value="Tarjeta Debito">Tarjeta Debito</option>
                    <option value="Cheque">Cheque</option>
                </select>
            </div>
            <div class="col-12">
                <label for="">Ingrese Efectivo</label>
                <input type="number" id="effective" class="form-control form-control-sm" disabled>
            </div>
            <div class="col-12">
                <label for="">Cambio:</label>
                <input type="number" id="change" class="form-control form-control-sm" readonly>
            </div>
        </div>
    </div>
</div>
</form>

<script>
    $(document).ready(function () {
        // Change Date
        $(document).on("change","#payment_method", function (){

            if ($("#payment_method").val() == "Efectivo") {
                $("#effective").prop("disabled", false);
                $("#change").prop("disabled", false);
            } else {
                $("#effective").prop("disabled", true);
                $("#change").prop("disabled", true);
                $("#effective").val('');
                $("#change").val('');
            }
        }); 
        $(document).on("keyup","#effective", function (){
            console.log(total_pay.value)
           let resta =   effective.value - total_pay.value;
            change.value = resta;
        }); 
        
    });
</script>