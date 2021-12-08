<form id="form-cliente-sc">
    @csrf
    <input type="hidden" id="id" name="id">
    <div class="form-row">
        <div class="col">
            <!-- Nombre Completo-->
            
            <div class="form-row">
                <div class="col">
                    <label for="">Nombre</label>
                    <input type="text" name="nombre" id="nombre" class="form-control form-control-sm solo-texto" placeholder="Nombre">
                </div>
                <div class="col">
                    <label for="">Ap Paterno</label>
                    <input type="text" name="apPaterno" id="apPaterno" class="form-control form-control-sm solo-texto" placeholder="Ap. Paterno">
                </div>
                <div class="col">
                    <label for="">Ap Materno</label>
                    <input type="text" name="apMaterno" id="apMaterno" class="form-control form-control-sm solo-texto"placeholder="Ap. Materno">
                </div>
            </div>

            <!-- Telefono y correo-->
            <div class="form-row">
                <div class="col">
                    <label for="">Teléfono</label>
                    <input name="telefono" id="telefono" type="number" class="form-control form-control-sm numero-entero-positivo lenght-telefono" placeholder="#">
                </div>
                <div class="col">
                    <label for="">Correo</label>
                    <input name="email" id="email" type="email" class="form-control form-control-sm" placeholder="ejemplo@gmail.com">
                </div>
            </div>

            <!-- Direccion-->
            <div class="form-row">
                <div class="col">
                    <label for="">Dirección</label>
                    <textarea name="direccion" id="direccion" cols="30" rows="3" class="form-control"></textarea>
                </div>
            </div>
            <hr>
    {{-- DATOS FACTURACIÓN --}}
        <div class="card-header bg-secondary mb-2" style="font-size: 13px">
            DATOS FACTURACIÓN
        </div>
        <div class="row">
            <div class="col">
                <label for="">CFDI</label>
                <input name="cfdi" id="cfdi" type="text" class="form-control form-control-sm" placeholder="texto">
            </div>
            <div class="col">
                <label for="">RFC</label>
                <input name="rfc" id="rfc" type="text" class="form-control form-control-sm" placeholder="texto">
            </div>
        </div>
        <div class="row"> 
            <div class="col">
                <label>Dirección:</label>
                <textarea name="direccion_factura" id="direccion_factura" class="form-control form-control-sm" cols="30" rows="2" required></textarea>
            </div>
        </div>
        <hr>
    {{-- ENVIO --}}
    <div class="card-header bg-secondary mb-2" style="font-size: 13px">
        DATOS ENVIO
    </div>
        <div class="row"> 
            <div class="col">
                <label>Dirección:</label>
                <textarea name="direccion_envio" id="direccion_envio" class="form-control form-control-sm" cols="30" rows="2" required></textarea>
            </div>
        </div>
        <div class="row"> 
                <div class="col">
                    <label>Referencias:</label>
                    <textarea name="referencia_envio" id="referencia_envio" class="form-control form-control-sm" cols="30" rows="2" required></textarea>
                </div>
        </div>
        <div class="row"> 
            <div class="col">
                <label>Link Ubicación:</label>
                <textarea name="link_ubicacion_envio" id="link_ubicacion_envio" class="form-control form-control-sm" cols="30" rows="2" required></textarea>
            </div>
        </div>
        <div class="row"> 
                <div class="col">
                    <label>Precio:</label>
                    <input name="precio_envio" id="precio_envio" type="number" id="precio_envio" class="form-control form-control-sm numero-decimal-positivo" required>
                </div>
        </div>
        </div>
    </div>
</form>