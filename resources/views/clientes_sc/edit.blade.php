    @csrf
    <input type="hidden" id="id_edit" name="id_edit">
    <div class="form-row">
        <div class="col">
            <!-- Nombre Completo-->
            
            <div class="form-row">
                <div class="col">
                    <label for="">Nombre</label>
                    <input type="text" name="nombre_edit" id="nombre_edit" class="form-control form-control-sm solo-texto" placeholder="Nombre">
                </div>
                {{--<div class="col">
                    <label for="">Ap Paterno</label>
                    <input type="text" name="apPaterno_edit" id="apPaterno_edit" class="form-control form-control-sm solo-texto" placeholder="Ap. Paterno">
                </div>
                <div class="col">
                    <label for="">Ap Materno</label>
                    <input type="text" name="apMaterno_edit" id="apMaterno_edit" class="form-control form-control-sm solo-texto"placeholder="Ap. Materno">
                </div> --}}
            </div>

            <!-- Telefono y correo-->
            <div class="form-row">
                <div class="col">
                    <label for="">Teléfono</label>
                    <input name="telefono_edit" id="telefono_edit" type="number" class="form-control form-control-sm numero-entero-positivo lenght-telefono" placeholder="#">
                </div>
                <div class="col">
                    <label for="">Correo</label>
                    <input name="email_edit" id="email_edit" type="email" class="form-control form-control-sm" placeholder="ejemplo@gmail.com">
                </div>
            </div>

            <!-- Direccion-->
            <div class="form-row">
                <div class="col">
                    <label for="">Dirección</label>
                    <textarea name="direccion_edit" id="direccion_edit" cols="30" rows="3" class="form-control"></textarea>
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
                <input name="cfdi_edit" id="cfdi_edit" type="text" class="form-control form-control-sm" placeholder="texto">
            </div>
            <div class="col">
                <label for="">RFC</label>
                <input name="rfc_edit" id="rfc_edit" type="text" class="form-control form-control-sm" placeholder="texto">
            </div>
        </div>
        <div class="row"> 
            <div class="col">
                <label>Dirección:</label>
                <textarea name="direccion_factura_edit" id="direccion_factura_edit" class="form-control form-control-sm" cols="30" rows="2" required></textarea>
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
                <textarea name="direccion_envio_edit" id="direccion_envio_edit" class="form-control form-control-sm" cols="30" rows="2" required></textarea>
            </div>
        </div>
        <div class="row"> 
                <div class="col">
                    <label>Referencias:</label>
                    <textarea name="referencia_envio_edit" id="referencia_envio_edit" class="form-control form-control-sm" cols="30" rows="2" required></textarea>
                </div>
        </div>
        <div class="row"> 
            <div class="col">
                <label>Link Ubicación:</label>
                <textarea name="link_ubicacion_envio_edit" id="link_ubicacion_envio_edit" class="form-control form-control-sm" cols="30" rows="2" required></textarea>
            </div>
        </div>
        <div class="row"> 
                <div class="col">
                    <label>Precio:</label>
                    <input name="precio_envio_edit" id="precio_envio_edit" type="number" id="precio_envio" class="form-control form-control-sm numero-decimal-positivo" required>
                </div>
        </div>
        </div>
    </div>