
<form id="form_create" method="POST">
    @csrf
    <input type="hidden" id="id">
    <div class="row justify-content-center ">
        <div class="col-10">
            <label for="">Fecha</label>
            <input type="date" class="form-control form-control-sm" id="fecha"  name="fecha">
        </div>
        <div class="col-10">
            <label for="">Vehículo</label>
            <select name="car_id" id="car_id" class="form-control form-control-sm">
                <option value="">SELECCIONA</option>
                @foreach ($cars as $car)
                    <option value="{{$car->id}}">{{$car->nombre." ".$car->modelo}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-10">
            <label for="">Chofer</label>
            <select name="driver_id" id="driver_id" class="form-control form-control-sm">
                <option value="">SELECCIONA</option>
                @foreach ($drivers as $driver)
                    <option value="{{$driver->id}}">{{$driver->nombre." ".$driver->apellido}}</option>
                @endforeach
            </select>
        </div>
    </div>
</form>