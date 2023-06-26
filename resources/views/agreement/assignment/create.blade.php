<div class="form-row">
    <div class="form-group col">
        <label for="">Cilindros</label>
        <input id="tank_number" type="number" class="form-control form-control-sm" placeholder="0">
        <span class="text-danger"  id="tank_numberError"></span>
    </div>
    <div class="form-group col">
        <label for="">Gas</label>
        <select id="gas_type" class="form-control form-control-sm">
            <option value="">Selecciona</option>
            @foreach ($gases as $gas)
                <option value="{{$gas->nombre}}">{{$gas->nombre}}</option>
            @endforeach
        </select>
        <span class="text-danger"  id="gas_typeError"></span>
    </div>
    <div class="form-group col">
        <label for="">Tipo de Cilindro</label>
        <select id="tank_type" class="form-control form-control-sm">
            <option value="">Selecciona</option>
            <option value="Medicinal">Medicinal</option>
            <option value="Industrial">Industrial</option>
        </select>
        <span class="text-danger"  id="tank_typeError"></span>
    </div>
</div>

<div class="form-row">
    <div class="form-group col">
        <label for="">Material del Cilindro</label>
        <select id="material_type" class="form-control form-control-sm">
            <option value="">Selecciona</option>
            <option value="Acero">Acero</option>
            <option value="Aluminio">Aluminio</option>
        </select>
        <span class="text-danger"  id="material_typeError"></span>
    </div>
    <div class="form-group col">
        <label for="">Capacidad</label>
        <input id="capacity" type="number" class="form-control form-control-sm" placeholder="0">
        <span class="text-danger"  id="capacityError"></span>
    </div>
    <div class="form-group col">
        <label for="">Unidad de Medida</label>
        <select id="unit_measurement" class="form-control form-control-sm">
            <option value="">Selecciona</option>
            <option value="Carga">Carga</option>
            <option value="m3">m3</option>
            <option value="kg">kg</option>
        </select>
        <span class="text-danger"  id="unit_measurementError"></span>
    </div>
</div>

<div class="form-row">
    <div class="form-group col">
        <label for="">Precio para cliente:</label>
        <input id="price" type="number" class="form-control form-control-sm" placeholder="0">
        <span class="text-danger"  id="priceError"></span>
    </div>
    
    <div class="form-group col">
        <label for="">Dep. Garantía Unitario</label>
        <input id="unit_guarantee_deposit" type="number" class="form-control form-control-sm" placeholder="0">
        <span class="text-danger"  id="unit_guarantee_depositError"></span>
    </div>
</div>

<script src="{{ asset('js/agreement/assignment/create.js') }}"></script>
