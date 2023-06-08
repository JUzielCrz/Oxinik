<form id="form-data">
    @csrf
    <div class="row justify-content-center align-items-center g-2">
        <div class="col-12">
            <label for=""># Serie Concentrador</label>
            <input type="text" id="serial_number" name="serial_number" class="form-control">
        </div>
        <div class="col-12">
            <label for="">Observaciones</label>
            <textarea  id="observations" name="observations"  col-12s="30" rows="3"  class="form-control"></textarea>
        </div>
    </div>
</form>
