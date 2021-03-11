<fieldset disabled>

                    <!-- Nombre Completo-->
                    <div class="row">
                        <div class="form-group col-md-6">
                            {!! Form::label('Folio Nota*') !!}
                            {!! Form::number('folio_nota', null, ['id'=>'folio_nota', 'class' => 'form-control', 'placeholder'=>'Folio', 'required' ]) !!}
                            <span  id="folio_notaError" class="text-danger"></span>
                        </div>
                        <div class="form-group col-md-6">
                            {!! Form::label('Fecha*') !!}
                            {!! Form::date('fecha', null, ['id'=>'fecha', 'class' => 'form-control' ]) !!}
                            <span  id="fechaError" class="text-danger"></span>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            {!! Form::label('Pago Realizado*') !!}
                            {!! Form::text('pago_realizado', null, ['id'=>'pago_realizado', 'class' => 'form-control', ]) !!}

                            <span  id="pago_realizadoError" class="text-danger"></span>
                        </div>

                        <div class="form-group col-md-6">
                            {!! Form::label('Metodo de Pago*') !!}
                            {!! Form::text('metodo_pago', null, ['id'=>'metodo_pago', 'class' => 'form-control', ]) !!}
                        </div>
                    </div>



            <div class="card mt-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col"># SERIE</th>
                                    <th scope="col">DESCRIPCIÓN</th>
                                    <th scope="col">PRECIO</th>
                                    <th scope="col">REGULADOR</th>
                                    <th scope="col">TAPA</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody id="tbodylisttanqinfo">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
</fieldset>