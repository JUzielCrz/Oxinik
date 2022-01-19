<style>
    .tdWidth{
        width: 60px;
        overflow: auto;
    }
</style>

<form id="form-asignacion-minus">
    @csrf
    <span>DISMINUCIÓN</span>
    <div class="table-responsive">
        <table class="table table-sm" id="table-asignaciones" style="font-size: 13px">
            <thead>
                <tr>
                    <th>CILINDROS</th>
                    <th>#CIL(RESTAR)</th>
                    <th>GAS</th>
                    <th>TIPO</th>
                    <th>MATERIAL</th>
                    <th>PRECIO</th>
                    <th>CAPACIDAD</th>
                    <th>U.M.</th>
                    <th>DEV.DEP.GRNT.</th>
                </tr>
            </thead>
            <center>
                <div id="msg-asignacion-minus" style="display:none" class="alert" role="alert">
                </div>
            </center>
            <tbody id="tbody-asignacion-minus">
            </tbody>
        </table>
    </div>
</form>

