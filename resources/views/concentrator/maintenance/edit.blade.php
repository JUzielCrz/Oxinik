<form id="form-return-edit">
    @csrf
    <div class="row justify-content-center align-items-center g-2">
        
        <div class="col-12">
            <label for="">#Id Registro</label>
            <input type="text" id="id_edit" name="id_edit" class="form-control" readonly>
        </div>
        <div class="col-12">
            <label for=""># Serie Concentrador</label>
            <input type="text" id="serial_number_edit" class="form-control" readonly>
        </div>
        <div class="col-12">
            <label for="">Estatus Devolución</label>
            <select name="status_edit" id="status_edit" class="form-control">
                <option value="PENDIENTE">PENDIENTE</option>
                <option value="OK">OK</option>
            </select>
        </div>
        <div class="col-12">
            <label for="">Observaciones</label>
            <textarea  id="observations_edit" name="observations_edit"  col-12s="30" rows="3"  class="form-control"></textarea>
        </div>
    </div>
</form>
