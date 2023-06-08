    <div class="card">
        <div class="card-body">
            <h5>Tiempo de renta</h5>
            <hr>
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Tiempo</th>
                            <th>Cantidad</th>
                            <th></th>
                            <th>Precio Renta</th>
                            <th></th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Días</td>
                            <td>
                                <select id="day" name="day" class="form-control form-control-sm">
                                    <option value=0>Selecciona</option>
                                    @for ($i = 1; $i <= 7; $i++)
                                        <option value={{$i}}>{{$i}}</option>
                                    @endfor
                                </select>
                            </td>
                            <td>X</td>
                            <td><input type="number" id="price_day" name="price_day" class="form-control form-control-sm" value = 0></td>
                            <td>=</td>
                            <td><input type="number" id="total_day" name="total_day"  class="form-control form-control-sm" value = 0 disabled></td>
                        </tr>
                        <tr>
                            <td>Semanas</td>
                            <td>
                                <select id="week" name="week" class="form-control form-control-sm">
                                    <option value=0>Selecciona</option>
                                    @for ($i = 1; $i <= 4; $i++)
                                        <option value={{$i}}>{{$i}}</option>
                                    @endfor
                                </select>
                            </td>
                            <td>X</td>
                            <td><input type="number" id="price_week" name="price_week"  class="form-control form-control-sm" value = 0></td>
                            <td>=</td>
                            <td><input type="number" id="total_week" name="total_week" class="form-control form-control-sm" value = 0 disabled></td>
                        </tr>
                        <tr>
                            <td>Meses</td>
                            <td>
                                <select id="mount"  name="mount" class="form-control form-control-sm">
                                    <option value=0>Selecciona</option>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value={{$i}}>{{$i}}</option>
                                    @endfor
                                </select>
                            </td>
                            <td>X</td>
                            <td><input type="number" id="price_mount" name="price_mount" class="form-control form-control-sm" value = 0></td>
                            <td>=</td>
                            <td><input type="number" id="total_mount"  name="total_mount" class="form-control form-control-sm" value = 0 disabled></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="card mt-3">
        <div class="card-body">
            <div class="form-row">
                <div class="input-group input-group-sm mb-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-sm">Depósito en Garantía:</span>
                    </div>
                    <input type="number" id="deposit_garanty" name="deposit_garanty" class="form-control" value = 0 aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" >
        
                </div>
            </div>
        </div>
    </div>

     

    <div class="card mt-3">
        <div class="card-body">
            <div class="row align-items-end ">
                <div class="col-md-4">
                    <label for="">Subtotal: </label>
                    <input type="number" id="rent_subtotal" name="rent_subtotal"  class="form-control form-control-sm" placeholder="$0.0" readonly>
                </div>
                <div class="col-md-4">
                    <label for="">IVA: </label>
                    <input type="number" id="rent_iva"  name="rent_iva" class="form-control form-control-sm" placeholder="$0.0" readonly>
                </div>
                <div class="col-md-4">
                    <label for="">TOTAL: </label>
                    <input type="number" id="rent_total" name="rent_total" class="form-control form-control-sm" placeholder="$0.0" readonly>
                </div>
            </div>
        </div>
    </div>

   
    
    <div class="card mt-3">
        <div class="card-body">
            <div class="row">
                
                <div class="col-md-6">
                    <label for="">Fecha Inicio Renta</label>
                    <input type="date" id="date_start"  name="date_start"  class="form-control">
                </div>
                <div class="col-md-6">
                    <label for="">Fecha Fin Renta</label>
                    <input type="date" id="date_end" name="date_end" class="form-control">
                </div>
            </div>
        </div>
    </div>


    

<script>
       
</script>