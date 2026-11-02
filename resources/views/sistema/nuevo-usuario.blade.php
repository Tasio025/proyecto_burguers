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
    /* Tarjeta de una empresa */
    .emp-card { border: 1px solid #dee2e6; border-radius: 8px; overflow: hidden; margin-bottom: 16px; background: #fff; }
    .emp-oculta { display: none; }                      /* empresas que el usuario todavía no tiene */

    /* Encabezado: nombre y contador a la izquierda, tacho a la derecha */
    .emp-head { display: flex; justify-content: space-between; align-items: center; padding: 14px 20px; background: #f1f3f5; }
    .emp-nombre { font-weight: 600; }
    .emp-contador { color: #6c757d; font-size: .85rem; }
    .emp-quitar { border: 0; background: transparent; color: #6c757d; cursor: pointer; padding: 4px 8px; }
    .emp-quitar:hover { color: #dc3545; }               /* rojo al pasar el mouse */

    /* Cada permiso: texto a la izquierda, interruptor a la derecha */
    .emp-fila { display: flex; justify-content: space-between; align-items: center; margin: 0; padding: 14px 20px; border-top: 1px solid #eee; font-weight: normal; cursor: pointer; }
    .emp-texto strong { display: block; font-weight: 400; }
    .emp-texto small { display: block; color: #6c757d; font-size: .85rem; }

    /* Interruptor */
    .emp-fila input.sw {
        -webkit-appearance: none; appearance: none;
        box-sizing: border-box !important;
        width: 40px !important; min-width: 40px !important;
        height: 22px !important; min-height: 22px !important;
        margin: 0 !important; padding: 0 !important; border: 0 !important;
        border-radius: 22px;
        background: #ced4da radial-gradient(circle, #fff 8px, transparent 9px) left center / 22px 22px no-repeat;
        box-shadow: none !important; cursor: pointer;
        transition: background-color .2s, background-position .2s;
    }
    .emp-fila input.sw:checked { background-color: #1a73e8; background-position: right center; }
    .emp-fila input.sw:focus-visible { outline: 2px solid #1a73e8; outline-offset: 2px; }

    #pieEmpresas { color: #6c757d; padding-top: 4px; }
</style>

<div class="row">
    <div id="msg"></div>
    <?php
    if (isset($msg)) {
        echo '<script>msgShow("' . $msg["MSG"] . '", "' . $msg["ESTADO"] . '")</script>';
    }
    ?>
</div>

<form id="form1" method="POST" action="/admin/usuarios/nuevo">
    <div class="row">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
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

    @php
        // Empresas donde el usuario ya tiene al menos un permiso (ej: ["1"])
        $empresasActivas = array();
        foreach (($array_permisos_usuario ?? array()) as $par) {
            $empresasActivas[] = explode('_', $par)[1];      // "9_1" -> toma el "1" (la empresa)
        }
    @endphp
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-3">
                <div class="card-header">
                    <i class="fa fa-building-o"></i> <strong>Empresas clientes</strong>
                    <div>
                        <button type="button" class="btn btn-secondary" title="Agregar empresa" onclick="abrirAgregarEmpresa()"><i class="fa fa-plus-circle"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <div id="tarjetasEmpresas">
                        @foreach($array_grupo as $grupo)
                        {{-- una tarjeta por empresa; oculta si el usuario no tiene permisos en ella --}}
                        <div class="emp-card {{ in_array((string)$grupo->idarea, $empresasActivas) ? '' : 'emp-oculta' }}"
                             id="emp_{{ $grupo->idarea }}" data-nombre="{{ $grupo->ncarea }}">
                            <div class="emp-head">
                                <div>
                                    <div class="emp-nombre">{{ $grupo->ncarea }}</div>
                                    <div class="emp-contador"></div>   {{-- lo completa el JS --}}
                                </div>
                                <button type="button" class="emp-quitar" title="Quitar empresa" onclick="quitarEmpresa({{ $grupo->idarea }})">
                                    <i class="fa fa-trash-o"></i>
                                </button>
                            </div>
                            @foreach($array_familia as $familia)
                                @php $clave = $familia->idfamilia . '_' . $grupo->idarea; @endphp
                                <label class="emp-fila">
                                    <span class="emp-texto">
                                        <strong>{{ $familia->nombre }}</strong>
                                        <small>{{ $familia->descripcion }}</small>
                                    </span>
                                    {{-- mismo name de siempre: guardar() en PHP no cambia --}}
                                    <input type="checkbox" class="sw" name="chk_Familia_{{ $clave }}" value="1"
                                           @if(in_array($clave, $array_permisos_usuario ?? array())) checked @endif>
                                </label>
                            @endforeach
                        </div>
                        @endforeach
                    </div>
                    <div id="pieEmpresas"></div>
                </div>
            </div>
        </div>
    </div>
</form>

<div class="modal fade" id="modalAgregarEmpresa" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agregar empresa</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="listaEmpresasDisponibles" class="list-group"></div>   <!-- lo llena el JS -->
            </div>
        </div>
    </div>
</div>

<script>
    $("#form1").validate();

    // Recalcula el contador de cada tarjeta y el pie de página
    function actualizarEmpresas() {
        var total = $('.emp-card').length;                           // empresas del sistema
        var visibles = $('.emp-card:not(.emp-oculta)').length;       // las que tiene el usuario

        $('.emp-card').each(function () {
            var cantidad = $(this).find('input.sw').length;          // permisos totales
            var habilitados = $(this).find('input.sw:checked').length;
            $(this).find('.emp-contador').text(habilitados + ' de ' + cantidad + ' permisos habilitados');
        });

        if (visibles === 0) {
            $('#pieEmpresas').text('Todavía no se agregó ninguna empresa.');
        } else {
            $('#pieEmpresas').text('Mostrando ' + visibles + ' de un total de ' + total + ' empresas');
        }
    }

    // Tacho: apaga todos los interruptores y oculta la tarjeta
    function quitarEmpresa(id) {
        var $card = $('#emp_' + id);
        $card.find('input.sw').prop('checked', false);   // sin checks no se envía nada de esta empresa
        $card.addClass('emp-oculta');
        actualizarEmpresas();
    }

    // Botón +: lista las empresas que están ocultas
    function abrirAgregarEmpresa() {
        var $lista = $('#listaEmpresasDisponibles').empty();
        $('.emp-card.emp-oculta').each(function () {
            $lista.append(
                $('<button type="button" class="list-group-item list-group-item-action">')
                    .text($(this).attr('data-nombre'))                          // nombre visible
                    .attr('data-id', this.id.replace('emp_', ''))               // id de la empresa
            );
        });
        if ($lista.children().length === 0) {
            $lista.append('<p class="text-muted m-3">No hay más empresas disponibles.</p>');
        }
        $('#modalAgregarEmpresa').modal('show');
    }

    // Al elegir una empresa del modal: se muestra su tarjeta
    $('#listaEmpresasDisponibles').on('click', 'button', function () {
        $('#emp_' + $(this).attr('data-id')).removeClass('emp-oculta');
        $('#modalAgregarEmpresa').modal('hide');
        actualizarEmpresas();
    });

    // Cada vez que se mueve un interruptor se recalculan los contadores
    $('#tarjetasEmpresas').on('change', 'input.sw', actualizarEmpresas);

    function guardar() {
        if ($("#form1").valid()) {
            // Una empresa visible sin permisos no deja filas en la base y desaparecería al recargar
            var vacias = [];
            $('.emp-card:not(.emp-oculta)').each(function () {
                if ($(this).find('input.sw:checked').length === 0) {
                    vacias.push($(this).attr('data-nombre'));
                }
            });
            if (vacias.length > 0) {
                $("#modalGuardar").modal('toggle');
                msgShow("Habilitá al menos un permiso en: " + vacias.join(', ') + ", o quitá la empresa.", "danger");
                return false;
            }
            modificado = false;
            form1.submit();
        } else {
            $("#modalGuardar").modal('toggle');
            msgShow("Corrija los errores e intente nuevamente.", "danger");
            return false;
        }
    }

    actualizarEmpresas();   // pinta los contadores al abrir la pantalla
</script>
@endsection