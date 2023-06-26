
<form id="form_concentrators" method="POST">
    @csrf
        <input type="hidden" name="id" id="id" >
        <!-- Nombre Completo-->
        
        <div class="row">
            <div class="col-md-6">
                <label for="">Número de Serie</label>
                <input type="text" id="serial_number" name="serial_number" class="form-control">
            </div>
            <div class="col-md-6">
                <label for="">Marca</label>
                <input type="text" id="brand" name="brand" class="form-control">
            </div>
            <div class="col-md-6">
                <label for="">Horas de Trabajo</label>
                <input type="number" id="work_hours" name="work_hours" class="form-control">
            </div>
            <div class="col-md-6">
                <label for="">Capacidad</label>
                <input type="number" id="capacity" name="capacity" class="form-control">
            </div>
            <div class="col-md-12">
                <label for="">Descripción</label>
                <textarea name="description" id="description" class="form-control"></textarea>
            </div>
        </div>

</form>
