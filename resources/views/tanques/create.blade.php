<center>
    <div id="divmsg" style="display:none" class="alert" role="alert">
    </div>
  </center>

  <form id="idFormTanque">
    @csrf

        <!-- Nombre Completo-->
        <div class="form-row">
            <div class="form-group col-md-4">
                {!! Form::label('Número de serie') !!}
                {!! Form::text('num_serie', null, ['id'=>'num_serie', 'class' => 'form-control form-control-sm', 'placeholder'=>'#serie', 'required' ]) !!}
                <span  id="num_serieError" class="text-danger"></span>
            </div>

            <div class="form-group col-md-2">
                {!! Form::label('Capacidad') !!}
                
                <select name="unidadmedida" id="unidadmedida" class="form-control form-control-sm">
                    <option value="">Selecione</option>
                    <option value="Carga">Carga</option>
                    <option value="m3">m3</option>
                    <option value="kilos">kilos</option>
                </select>
            </div>
            
            <div class="form-group col-md-2">
                {!! Form::label('*') !!}
                {!! Form::number('capacidadnum', null, ['id'=>'capacidadnum', 'class' => 'form-control form-control-sm', 'max'=>'10','placeholder'=>'#']) !!}
                <span  id="capacidadError" class="text-danger"></span>
            </div>

            <div class="form-group col-md-2">
                <label for="">PH</label>
                <select name="ph_mes" id="ph_mes" class="form-control form-control-sm">
                    <option value="">Mes</option>
                    <option value="01">01</option>
                    <option value="02">02</option>
                    <option value="03">03</option>
                    <option value="04">04</option>
                    <option value="05">05</option>
                    <option value="06">06</option>
                    <option value="07">07</option>
                    <option value="08">08</option>
                    <option value="09">09</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                </select>
                <span  id="phError" class="text-danger"></span>
            </div>
            <div class="form-group col-md-2">
                <label for="">.</label>
                <input type="number" name="ph_anio" id="ph_anio" class="form-control form-control-sm anio_format" placeholder="Año">
            </div>
        </div>
        
        <div class="form-row">
            
            
            <div class="form-group col-md-3">
                {!! Form::label('Material') !!}
                {{ Form::select('material',['Acero' => 'Acero', 'Aluminio' => 'Aluminio' ],null,['id' => 'material','class'=>'form-control form-control-sm', 'placeholder'=>'selecciona'])}}
                <span  id="materialError" class="text-danger"></span>
            </div>
            <div class="form-group col-md-3">
                {!! Form::label('Tipo') !!}
                {{ Form::select('tipo_tanque',['Industrial' => 'Industrial', 'Medicinal' => 'Medicinal' ],null,['id' => 'tipo_tanque','class'=>'form-control form-control-sm', 'placeholder'=>'selecciona'])}}
                <span  id="tipo_tanqueError" class="text-danger"></span>
            </div>

            <div class="form-group col-md-2">
                {!! Form::label('Fabricante') !!}
                {{ Form::select('fabricanteoficial',['Infra' => 'Infra', 'Praxair' => 'Praxair', 'Otros' => 'Otros' ],null,['id' => 'fabricanteoficial','class'=>'form-control form-control-sm', 'placeholder'=>'selecciona'])}}
                <span  id="fabricanteError" class="text-danger"></span>
            </div>
            <div class="form-group col-md-4">
                {!! Form::label('*') !!}
                {!! Form::text('otrofabricante', null, ['id'=>'otrofabricante', 'class' => 'form-control form-control-sm',  'required', 'disabled' ]) !!}
                <span  id="fabricanteotrosError" class="text-danger"></span>
            </div>
        </div>

        <div class="form-row">

            <div class="form-group col-md-7">
                {!! Form::label('Gas') !!}
                {{ Form::select('tipo_gas', $catalogo, null, ['id'=>'tipo_gas', 'class' => 'form-control form-control-sm', 'required', 'placeholder'=>'selecciona' ]) }}
                <span  id="tipo_gasError" class="text-danger"></span>
            </div>

            <div class="form-group col-md-4">
                {!! Form::label('estatus') !!}
                {{ Form::select('estatus',[
                    'VACIO-ALMACEN' => 'VACIO-ALMACEN', 
                    'LLENO-ALMACEN' => 'LLENO-ALMACEN', 
                    'INFRA' => 'INFRA', 
                    'ENTREGADO-CLIENTE' => 'ENTREGADO-CLIENTE' ,
                    'MANTENIMIENTO' => 'MANTENIMIENTO',
                    'TANQUE-CAMBIADO' => 'TANQUE-CAMBIADO' ],null,['id' => 'estatus','class'=>'form-control form-control-sm', 'placeholder'=>'selecciona'])}}
                <span  id="estatusError" class="text-danger"></span>
            </div>

        </div>

</form>
