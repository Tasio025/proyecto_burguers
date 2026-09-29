@extends('plantilla')
@section('titulo', $titulo)

@section('scripts')

//LA DEJO UNICAMENTE POR LAS DUDAS
<script>
    globalId = '<?php echo isset($usuario->idusuario) && $usuario->idusuario > 0 ? $usuario->idusuario : 0; ?>';
    <?php $globalId = isset($usuario->idusuario) ? $usuario->idusuario : "0"; ?>
</script>
@endsection

@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/admin">Inicio</a></li>
    <li class="breadcrumb-item"><a href="/admin/usuario">Usuarios</a></li>
    <li class="breadcrumb-item active">{{ $globalId > 0 ? 'Modificar' : 'Nuevo' }}</li>
</ol>

<ol class="toolbar">
    <li class="btn-item">
        <a title="Nuevo"
           href="/admin/usuario/nuevo"
           class="fa fa-plus-circle"
           aria-hidden="true">
            <span>Nuevo</span>
        </a>
    </li>

    <li class="btn-item">
        <a title="Guardar"
           href="#"
           class="fa fa-floppy-o"
           aria-hidden="true"
           onclick="javascript: $('#modalGuardar').modal('toggle');">
            <span>Guardar</span>
        </a>
    </li>

    @if($globalId > 0)
    <li class="btn-item">
        <a title="Eliminar"
           href="#"
           class="fa fa-trash-o"
           aria-hidden="true"
           onclick="javascript: $('#mdlEliminar').modal('toggle');">
            <span>Eliminar</span>
        </a>
    </li>
    @endif

    <li class="btn-item">
        <a title="Salir"
           href="#"
           class="fa fa-arrow-circle-o-left"
           aria-hidden="true"
           onclick="javascript: $('#modalSalir').modal('toggle');">
            <span>Salir</span>
        </a>
    </li>
</ol>

<script>
function fsalir(){
    location.href = "/admin/usuario";
}
</script>
@endsection

@section('contenido')
<?php
if (isset($msg)) {
    echo '<div id="msg"></div>';
    echo '<script>msgShow("' . $msg["MSG"] . '", "' . $msg["ESTADO"] . '")</script>';
}
?>
<div id="msg"></div>
<div class="panel-body">
    <form id="form1" name="form1" method="POST" action="/admin/usuario/nuevo">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" id="idusuario" name="idusuario" value="{{ $globalId }}">
        <div class="row">
            <div class="form-group col-lg-6">
                <label for="txtNombre">Nombre:</label>
                <input type="text" id="txtNombre" name="txtNombre" class="form-control" value="{{ $usuario->nombre }}" maxlength="50" required>
            </div>
            <div class="form-group col-lg-6">
                <label for="txtApellido">Apellido:</label>

                <input type="text"
                       id="txtApellido"
                       name="txtApellido"
                       class="form-control"
                       value="{{ $usuario->apellido }}"
                       maxlength="50"
                       required>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-lg-6">
                <label for="txtEmail">Correo:</label>
                <input type="email" id="txtEmail" name="txtEmail" class="form-control" value="{{ $usuario->mail }}" maxlength="100" autocomplete="email" required>
            </div>
            
            <div class="form-group col-lg-6">
                <label for="txtClave">Clave:</label>
                <input type="password" id="txtClave" name="txtClave" class="form-control" value="" placeholder="Ingrese una contraseña" required>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-lg-6">
                <label>Autenticación de dos factores:</label>
                <div class="checkbox">
                    <label for="chk2faCorreo">
                        <input type="checkbox"
                               id="txtdosFa_correo"
                               name="txtdosFa_correo"
                               value="1"
                               required>
                        2FA por correo
                    </label>
                </div>
                <div class="checkbox">
                    <label for="chk2faAuthenticator">
                        <input type="checkbox"
                               id="dosFa_authenticator"
                               name="dosFa_authenticator"
                               value="1"
                               required>
                        2FA Authenticator
                    </label>
                </div>
            </div>
      </div>
      @if(isset($array_familia) && isset($array_area))
        <div class="row">
            <div class="form-group col-lg-12">
                <label>Permisos por línea de negocio:</label>
                <table class="table table-bordered table-sm">
                    <thead>
                        <tr>
                            <th>Permiso</th>
                            @foreach($array_area as $area)
                            <th class="text-center">
                                {{ $area->descarea }}
                            </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($array_familia as $familia)
                        <tr>
                            <td>
                                {{ $familia->nombre }}
                            </td>
                            @foreach($array_area as $area)
                            <?php
                                $clave = $familia->idfamilia . '_' . $area->idarea;
                            ?>
                            <td class="text-center">
                                <input type="checkbox"
                                       name="chk_Familia_{{ $clave }}"
                                       aria-label="{{ $familia->nombre }} en {{ $area->descarea }}"
                                       value="1"
                                       @if(isset($array_permisos_usuario) && in_array($clave, $array_permisos_usuario)) checked @endif>
                            </td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </form>

    <script>
        $("#form1").validate();
        function guardar(){
            if($("#form1").valid()) {
                modificado = false;
                form1.submit();
            }else{
                $("#modalGuardar").modal('toggle');
                msgShow(
                    "Corrija los errores e intente nuevamente.",
                    "danger"
                );
                return false;
            }
      }
      function eliminar(){
            $.ajax({
                type: "GET",
                url: "{{ asset('/admin/usuario/eliminar') }}",
                data: {
                    idusuario: globalId
                },
                async: true,
                dataType: "json",
                success: function(data){
                    if(data.err == 0){
                        msgShow(data.mensaje, "success");
                    }else{
                        msgShow(data.mensaje, "danger");
                    }
                    $('#mdlEliminar').modal('toggle');
                }
            });
      }
    </script>

</div>

@endsection