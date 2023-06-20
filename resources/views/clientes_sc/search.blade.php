<div class="card">
    <div class="card-header p-2" >
        <div class="form-row">
            <div class="col">
                BUSCAR CLIENTE
            </div>
            <div class="col text-right">
                <button id="btn-registrar-cliente" class="btn btn-sm btn-amarillo"  type="button" data-toggle="modal" data-target="#modal-create-cliente"><span class="fas fa-edit"></span> Registar</button>
            </div>
        </div>
            
    </div>
    <div class="card-body">
        <div class="row">
            <input type="hidden"  name="contrato_id" id="contrato_id">
            <div class="input-group input-group-sm ">
                <div class="input-group-prepend">
                    <span class="input-group-text fas fa-search" id="inputGroup-sizing-sm"></span>
                </div>
                <input id="search_cliente" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" >
            </div>
        </div>
        <div id="listarclientes"></div>
    </div>
</div>

<!-- CREATE CLIENTE-->
<div class="modal fade bd-example-modal-md" id="modal-create-cliente" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalinsertarTitle">Registrar Cliente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                    <span aria-hidden="true" class="fas fa-times"></span>
                </button>
            </div>
            <div class="modal-body">
                @include('clientes_sc.create')
                <!-- botones Aceptar y cancelar-->
                <div class="row justify-content-center" >
                    <div class="btn-group col-auto" style="margin:10px" >
                        <button type="button" class="btn btn-amarillo" id="btn-cliente-create-save">Aceptar</button>
                    </div>
                    <div class="btn-group col-auto" style="margin:10px">
                        <button  class="btn btn-amarillo" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>