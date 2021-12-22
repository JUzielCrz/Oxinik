<form id="idFormReserva">
    @csrf
    <div class="row justify-content-center ">
        <div class="col-sm-10">
            <select name="incidencia" id="incidencia" class="form-control form-control-sm">
                <option value="">SELECCIONA</option>
                <option value="ENTRADA">ENTRADA</option>
                <option value="SALIDA">SALIDA</option>
            </select>
        </div>
    </div>
    <div class="row justify-content-center mt-2">
        <div class="col-sm-10">
            <div class="input-group input-group-sm">
                <input id="serie_tanque" type="text" class="form-control form-control-sm" placeholder="# SERIE" disabled>
                <div class="input-group-prepend">
                    <button id="btn-insertar-cilindro" class="btn btn-amarillo" type="button">Agregar</button>
                </div>
                
            </div>
            <span id="serie_tanqueError" class="alert-danger"></span>
        </div>
    </div>
    
    
    <hr>
    <span  id="serie_tanque_entradaError" class="text-danger"></span>
    <div class="table-responsive mt-2">
        <table class="table table-sm table-hover table-bordered">
            <thead>
                <tr style="font-size: 13px">
                    <th scope="col">#SERIE</th>
                    <th scope="col">DESCRIPCIÓN</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody id="tbody-reserva-tanques" style="font-size: 13px">
            </tbody>
        </table>
    </div>
</form>

