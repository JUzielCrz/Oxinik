{{-- DATOS  CLIENTE --}}
<div class="card mt-2">
    <div class="card-header p-2" >
        <div class="form-row">
            <div class="col">
                DATOS CLIENTE
            </div>
            <div class="col text-right">
                <button id="btn-editar-cliente" class="btn btn-sm btn-amarillo"  type="button" data-toggle="modal" data-target="#modal-editar-cliente"><span class="fas fa-edit"></span> Editar</button>
            </div>
        </div>
            
    </div>
    <div class="card-body ">
            <!-- Nombre Completo-->
            <div class="form-row">
                <div class="input-group input-group-sm mb-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-sm">Num. Cliente:</span>
                    </div>
                    <input id="id_show" name="id_show" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" readonly>
                </div>
            </div>
            <!-- Nombre Completo-->
            <div class="form-row">
                <div class="input-group input-group-sm mb-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-sm">Nombre:</span>
                    </div>
                    <input name="nombre_show" id="nombre_show" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" disabled>
                </div>
            </div>

            <!-- Telefono-->
            <div class="form-row">
                <div class="input-group input-group-sm mb-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-sm">Telefono:</span>
                    </div>
                    <input id="telefono_show" type="number" class="form-control form-control-sm lenght-telefono" placeholder="#" disabled>
                </div>
            </div>

            <!-- Correo-->
            <div class="form-row">
                <div class="input-group input-group-sm mb-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-sm">Correo:</span>
                    </div>
                    <input id="email_show" type="email" class="form-control form-control-sm" placeholder="ejemplo@gmail.com" disabled>
                </div>
            </div>
            <!-- Direccion-->
            <div class="form-row">
                <div class="input-group input-group-sm">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-sm">Dirección:</span>
                    </div>
                    <textarea id="direccion_show" cols="30" rows="3" class="form-control" disabled></textarea>
                </div>
            </div>
    </div>

    <div class="accordion" id="accordionExample">
        {{-- DATOS FACTURACIÓN --}}
        <div class="card mr-2 ml-2">
            <div class="card-header p-2 bg-secondary" id="headingOne">
                <button class="btn btn-link btn-block text-left text-white p-0" style="font-size: 13px" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseOne">
                    DATOS FACTURACIÓN<i class="fas fa-caret-down ml-2"></i></i>
                </button>
            </div>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                <div class="card-body">
                    <!-- RFC-->
                    <div class="form-row">
                        <div class="input-group input-group-sm mb-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-sm">RFC:</span>
                            </div>
                            <input id="rfc_show" type="text" class="form-control form-control-sm" placeholder="texto" disabled>
                        </div>
                    </div>

                    <!-- CFDI-->
                    <div class="form-row">
                        <div class="input-group input-group-sm mb-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-sm">CFDI:</span>
                            </div>
                            <input id="cfdi_show" type="text" class="form-control form-control-sm" placeholder="texto" disabled>
                        </div>
                    </div>

                    <!-- direccion factura-->
                    <div class="form-row">
                        <div class="input-group input-group-sm mb-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-sm">Direccion Factura:</span>
                            </div>
                            <textarea id="direccion_factura_show" class="form-control form-control-sm" cols="30" rows="2" disabled></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- DATOS ENVÍO --}}
        <div class="card mr-2 ml-2 mb-2">
            <div class="card-header p-2 bg-secondary" id="headingThree">
                <button class="btn btn-link btn-block text-left text-white p-0"  style="font-size: 13px" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseOne">
                    DATOS ENVÍO <i class="fas fa-caret-down ml-2"></i></i>
                </button>
            </div>
            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                <div class="card-body">
                    <div class="form-row">
                        <div class="input-group input-group-sm mb-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-sm">Dirección:</span>
                            </div>
                            <textarea id="direccion_envio_show" class="form-control form-control-sm" cols="30" rows="2" disabled></textarea>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="input-group input-group-sm mb-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-sm">Referencias:</span>
                            </div>
                            <textarea id="referencia_envio_show" class="form-control form-control-sm" cols="30" rows="2" disabled></textarea>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="input-group input-group-sm mb-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-sm">Link Ubicación:</span>
                            </div>
                            <textarea id="link_ubicacion_envio_show" class="form-control form-control-sm" cols="30" rows="2" disabled></textarea>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="input-group input-group-sm mb-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-sm">Precio Envio:</span>
                            </div>
                            <input id="precio_envio_show" type="number" value=0 class="form-control form-control-sm numero-decimal-positivo" disabled>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- EDITAR CLIENTE-->
<div class="modal fade bd-example-modal-md" id="modal-editar-cliente" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalinsertarTitle">Editar Cliente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                    <span aria-hidden="true" class="fas fa-times"></span>
                </button>
            </div>
            <div class="modal-body">
                @include('clientes_sc.edit')
                <!-- botones Aceptar y cancelar-->
                <div class="row justify-content-center" >
                    <div class="btn-group col-auto" style="margin:10px" >
                        <button type="button" class="btn btn-amarillo" id="btn-cliente-edit-save">Aceptar</button>
                    </div>
                    <div class="btn-group col-auto" style="margin:10px">
                        <button  class="btn btn-amarillo" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>