@extends('plantilla')
@section('titulo', "Datos del usuario")
@section('scripts')
<link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet">
<script src="{{ asset('js/datatables.min.js') }}"></script>
<script>
    globalId = '<?php echo isset($usuario->idusuario) && $usuario->idusuario > 0 ? $usuario->idusuario : 0; ?>';
    <?php $globalId = isset($usuario->idusuario) ? $usuario->idusuario : "0"; ?>

</script>
@endsection
@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/admin/home">Inicio</a></li>
    <li class="breadcrumb-item"><a href="/admin/usuarios">Usuarios</a></li>
    <li class="breadcrumb-item active">Modificar</li>
</ol>
<ol class="toolbar">
    <li class="btn-item"><a title="Nuevo" href="/admin/usuarios/nuevo" class="fa fa-plus-circle" aria-hidden="true"><span>Nuevo</span></a></li>
    <li class="btn-item"><a title="Guardar" href="#" class="fa fa-floppy-o" aria-hidden="true" onclick="javascript: $('#modalGuardar').modal('toggle');"><span>Guardar</span></a>
    </li>
    <li class="btn-item"><a title="Salir" href="#" class="fa fa-arrow-circle-o-left" aria-hidden="true" onclick="javascript: $('#modalSalir').modal('toggle');"><span>Salir</span></a></li>
</ol>
<script>
function fsalir(){
    location.href ="/usuarios";
}
</script>
@endsection
@section('contenido')
<style>
    /* Tarjetas: una por permiso */
    #grilla, #grilla tbody { display: block; width: 100% !important; }
    #grilla thead { display: none; }
    #grilla tbody tr {
        display: block;
        margin-bottom: 12px;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        overflow: hidden;
        background: #fff !important;
    }

    /* Cada área: nombre + estado a la izquierda, interruptor a la derecha */
    #grilla tbody td {
        display: grid;
        grid-template-columns: 1fr auto;
        grid-template-areas: "titulo interruptor" "sub interruptor";
        align-items: center;
        column-gap: 12px;
        padding: 12px 16px;
        border: 0;
        border-top: 1px solid #eee;
        background: transparent !important;
        cursor: pointer;
    }

    /* Interruptor */
    #grilla input[type=checkbox] {
    grid-area: interruptor;
    -webkit-appearance: none;
    appearance: none;
    display: block;
    box-sizing: border-box !important;
    width: 36px !important;
    min-width: 36px !important;
    height: 20px !important;
    min-height: 20px !important;
    margin: 0 !important;
    padding: 0 !important;
    border: 0 !important;
    border-radius: 20px;
    background: #ced4da radial-gradient(circle, #fff 7px, transparent 8px) left center / 20px 20px no-repeat;
    box-shadow: none !important;
    cursor: pointer;
    transition: background-color .2s, background-position .2s;
}
    #grilla input[type=checkbox]:checked { background-color: #1a73e8; background-position: right center; }
    #grilla input[type=checkbox]:focus-visible { outline: 2px solid #1a73e8; outline-offset: 2px; }

    /* Encabezado de la tarjeta (nombre del permiso + tacho) */
    #grilla tbody td:first-child {
        display: block;
        padding: 0;
        border-top: 0;
        background: #f1f3f5 !important;
        cursor: default;
    }
      .perm-head { display: flex; justify-content: space-between; align-items: center; padding: 12px 16px; }
    /*.perm-nombre { font-weight: 600; }*/
      .perm-nombre { display: block; font-weight: 600; }
      .perm-desc { display: block; color: #6c757d; font-size: .8rem; }
      .perm-quitar { border: 0; background: transparent; color: #6c757d; cursor: pointer; padding: 4px; line-height: 1; }
      .perm-quitar:hover { color: #dc3545; }

    /* Textos de cada área */
    #grilla tbody td:nth-child(n+2)::before { grid-area: titulo; font-weight: 500; }
    #grilla tbody td:nth-child(n+2)::after {
        grid-area: sub;
        content: "Sin acceso en esta área";
        color: #6c757d;
        font-size: .8rem;
    }
    #grilla tbody td:nth-child(n+2):has(input:checked)::after { content: "Habilitado en esta área"; }

    @foreach($array_grupo as $grupo)
    #grilla tbody td:nth-child({{ $loop->iteration + 1 }})::before { content: {!! json_encode($grupo->ncarea) !!}; }
    @endforeach

    #grilla tbody td.dataTables_empty { display: block; text-align: center; color: #6c757d; cursor: default; }
    #grilla_info { color: #6c757d; padding-top: 8px; }

    #grilla.dataTable, #grilla.dataTable.no-footer { border-bottom: 0 !important; }
</style>
<?php
if (isset($msg)) {
    echo '<div id = "msg"></div>';
    echo '<script>msgShow("' . $msg["MSG"] . '", "' . $msg["ESTADO"] . '")</script>';
}
?>
<div class="row">
    <div id = "msg"></div>
    <?php
    if (isset($msg)) {
        echo '<script>msgShow("' . $msg["MSG"] . '", "' . $msg["ESTADO"] . '")</script>';
    }
    ?>
</div>
<form id="form1" method="POST" action="/admin/usuarios/nuevo">
    <div class="row">
        <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
        <input type="hidden" id="id" name="id" class="form-control" value="{{$globalId}}" required>
        <div class="form-group col-lg-2">
            <label>Usuario: *</label>
        </div>
       <div class="form-group col-lg-4">
            <input type="text" id="txtUsuario" name="txtUsuario" class="form-control" value="{{$usuario->usuario }}" required>
            <input type="hidden" id="txtLegajo" name="txtLegajo" value="{{$usuario->fk_legajo_id }}" required>
        </div>
        <div class="form-group col-lg-2">
            <label>Nombre:</label>
       </div>
        <div class="form-group col-lg-4">
            <input type="text" id="txtNombre" name="txtNombre" class="form-control" value="{{$usuario->nombre }}">
        </div>
        <div class="form-group col-lg-2">
            <label>Apellido:</label>
        </div>
        <div class="form-group col-lg-4">
            <input type="text" id="txtApellido" name="txtApellido" class="form-control" value="{{$usuario->apellido }}">
        </div>
        <div class="form-group col-lg-2">
            <label>Email: *</label>
        </div>
        <div class="form-group col-lg-4">
            <input type="email" id="txtEmail" name="txtEmail" class="form-control" required value="{{$usuario->mail }}">
        </div>
        <div class="form-group col-lg-2">
            <label>Clave: <?php echo $globalId == 0 ? '*' : '';  ?></label>
        </div>
        <div class="form-group col-lg-4">
            <input type="password" id="txtClave" name="txtClave" class="form-control" {{ $globalId == 0 ? 'required' : '' }}>
        </div>
        <div class="form-group col-lg-2">
            <label>Activo: *</label>
        </div>
        <div class="form-group col-lg-4">
            <select id="lstEstado" name="lstEstado" class="form-control" required>
                <option value="" disabled selected>Seleccionar</option>
                <option value="1" {{isset($usuario) && $usuario->activo == 1? 'selected' : ''}}>Si</option>
                <option value="0" {{isset($usuario) && $usuario->activo == 0? 'selected' : ''}}>No</option>
            </select>
        </div>
        <div class="form-group col-lg-2">
            <label>Área predeterminada: *</label>
        </div>
        <div class="form-group col-lg-4">
            <select id="lstArea" name="lstArea" class="form-control" required>
                <option value="" disabled selected>Seleccionar</option>
                @for ($i = 0; $i < count($array_area); $i++)
                    @if (isset($usuario) and $array_area[$i]->idarea == $usuario->areapredeterminada)
                        <option selected value="{{ $array_area[$i]->idarea }}">{{ $array_area[$i]->ncarea }}</option>
                    @else

                        <option value="{{ $array_area[$i]->idarea }}">{{ $array_area[$i]->ncarea }}</option>
                    @endif
                @endfor
            </select>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-lg-2">
            <label for="txtIps">IPS permitidas</label>
        </div>
        <div class="form-group col-lg-4">
            <textarea id="txtIps" name="txtIps" class="form-control" rows="4" placeholder="Ingresar una IP por linea">{{ $ips ?? '' }}</textarea>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-lg-2">
            <label for="txtdosFa_correo">2FA por correo:</label>
        </div>
        <div class="form-group col-lg-4">
            <input type="checkbox" id="txtdosFa_correo" name="txtdosFa_correo" value="1" {{ isset($usuario) && $usuario->dosFa_correo == 1 ? 'checked' : '' }}>
        </div>
        <div class="form-group col-lg-2">
            <label for="txtdosFa_authenticator">2FA Authenticator:</label>
        </div>
        <div class="form-group col-lg-4">
            <input type="checkbox" id="txtdosFa_authenticator" name="txtdosFa_authenticator" value="1" {{ isset($usuario) && $usuario->dosFa_authenticator == 1 ? 'checked' : '' }}>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-3">
                <div class="card-header">
                    <i class="fa fa-table"></i> Permisos asignados
                    <div class="pull-right">
                        <button type="button" class="btn btn-secondary fa fa-plus-circle" onclick="abrirAgregarPatentes()"></button>
                    </div>
                </div>
                <div class="card-body">
                    <table id="grilla" class="display">
                        <thead>
                            <tr>
                                <th>familia_id</th>
                                <th>Permiso</th>
                               @foreach($array_grupo as $grupo)
                                    <th>{{ $grupo->ncarea }}</th>
                                @endforeach
                              <!--@foreach($array_grupo as $grupo)
                                    #grilla tbody td:nth-child({{ $loop->iteration + 1 }})::before { content: {!! json_encode($grupo->ncarea, JSON_UNESCAPED_UNICODE) !!}; }
                              @endforeach-->
                            </tr>
                        </thead>
                    </table> 
                </div>
            </div>
        </div>
    </div>
</form>
<div class="modal fade" id="modalAgregar" tabindex="-1" role="dialog" aria-labelledby="modalAgregarLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalBuscarLabel">Permisos del sistema</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                    <table id="grillaPermisos" class="display">
                        <thead>
                            <tr>
                                <th>familia_id</th>
                                <th></th>
                                <th>Nombre</th>
                                <th>Descripci&oacute;n</th>
                            </tr>
                        </thead>
                    </table> 
    
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="agregarPatentesGrilla();">Agregar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalAgregarGrupos" tabindex="-1" role="dialog" aria-labelledby="modalAgregarGruposLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalBuscarLabel">Grupos del sistema</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                    <table id="grillaTodosLosGrupos" class="display">
                        <thead>
                            <tr>
                                <th>grupo_id</th>
                                <th></th>
                                <th>Nombre</th>
                            </tr>
                        </thead>
                    </table> 
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="agregarGruposGrilla();">Agregar</button>
            </div>
        </div>
    </div>
</div>
<script>
    $("#form1").validate();
    cargarGrillaPermisos();
    cargarGrilla();

    function guardar() {
        if ($("#form1").valid()) {
            modificado = false;
            form1.submit(); 
        } else {
            $("#modalGuardar").modal('toggle');
            msgShow("Corrija los errores e intente nuevamente.", "danger");
            return false;
        }
    }
    function cargarGrilla() {
           var grilla = $('#grilla').DataTable({
            "processing": true,
            "serverSide": false,
            "bFilter": false,
            "bInfo": true,
            "bSearchable": false,
            "paging": false,
            "ajax": "{{ asset('admin/usuarios/cargarGrillaFamiliasDelUsuario?us='.$globalId) }}",
            "columnDefs": [
                {
                    "targets": [0],
                    "visible": false,
                    "searchable": false
                },
                 {
                    "targets": [1],
                    "visible": true,
                    "searchable": true,
                    "width": 200
                }
                @php ($pos = 2)
                @foreach($array_grupo as $grupo)
                ,
                {
                    "targets": [@php (print_r($pos))],
                    "visible": true,
                    "searchable": true,
                    "width": 30,
                    "className": "dt-head-center"
                }
                @php ($pos++)
                @endforeach
            ]
        });
    }
    function cargarGrillaPermisos() {
        var grilla = $('#grillaPermisos').DataTable({
            "processing": true,
            "serverSide": true,
            "bFilter": true,
            "bInfo": true,
            "bSearchable": true,
            "pageLength": 10,
            "ajax": "{{ asset('admin/usuarios/cargarGrillaFamiliaDisponibles?fam='.$globalId) }}",
            "columnDefs": [
                {
                    "targets": [0],
                    "visible": false,
                    "searchable": false
                }
            ]
        });
    }

    function abrirAgregarPatentes() {
        $('#modalAgregar').modal('toggle');
    }
 
    function agregarPatentesGrilla() {
        var grilla = $('#grilla').DataTable();
        var grillaPermisos = $('#grillaPermisos').DataTable();
        var pos = 0;

        $('#grillaPermisos input[type=checkbox]').each(function () {
            if (this.checked) {
                id = grillaPermisos.row(pos).data()[0];

                if ($("[name*='chk_Familia_" + id + "']").length == 0) {
                    //Si no esta lo agrega
                    grilla.row.add([
                        id,
                        grillaPermisos.row(pos).data()[2]
                        @php ($pos = 2)

                        @foreach($array_grupo as $grupo)
                            ,
                            "<input id='chk_Familia_" + id + "_{{$grupo->idarea}}' name='chk_Familia_" +  id + "_{{$grupo->idarea}}' type='checkbox' class='form-control' />"
                            @php ($pos++)
                        @endforeach

                    ]).draw();
                }
            }
            pos++;
        });
        $('#modalAgregar').modal('toggle');
    }
 
</script>
@endsection