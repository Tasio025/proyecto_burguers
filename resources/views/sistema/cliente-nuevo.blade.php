@extends("plantilla") <!--Trae la plantilla a esa sección de la página-->
@section('titulo', $titulo) <!--Crea el título de la seccion-->
@section('scripts')<!--Crea los scripts -->
<script>
    globalId = '<?php echo isset($cliente->idcliente) && $cliente->idcliente > 0 ? $cliente->idcliente : 0; ?>';
    <?php $globalId = isset($cliente->idcliente) ? $cliente->idcliente : "0";?> 
</script>
@endsection
@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/admin">Inicio</a></li>
    <li class="breadcrumb-item"><a href="/admin/clientes">Clientes</a></li>
    <li class="breadcrumb-item active">Modificar</li>
</ol>
<ol class="toolbar">
    <li class="btn-item"><a title="Nuevo" href="/admin/sistema/clientes/nuevo" class="fa fa-plus-circle" aria-hidden="true"><span>Nuevo</span></a></li>
    <li class="btn-item"><a title="Guardar" href="#" class="fa fa-floppy-o" aria-hidden="true" onclick="javascript: $('#modalGuardar').modal('toggle');"><span>Guardar</span></a>
    </li>
    @if($globalId > 0)
    <li class="btn-item"><a title="Guardar" href="#" class="fa fa-trash-o" aria-hidden="true" onclick="javascript: $('#mdlEliminar').modal('toggle');"><span>Eliminar</span></a></li>
    @endif
    <li class="btn-item"><a title="Salir" href="#" class="fa fa-arrow-circle-o-left" aria-hidden="true" onclick="javascript: $('#modalSalir').modal('toggle');"><span>Salir</span></a></li>
</ol>
<script>
function fsalir(){
    location.href ="/admin/sistema/clientes";
}
</script>
@endsection
@section('contenido')<!--Crea el contenido de la sección-->
<?php
if (isset($msg)) {
    echo '<div id = "msg"></div>';
    echo '<script>msgShow("' . $msg["MSG"] . '", "' . $msg["ESTADO"] . '")</script>';
}
?>
<div class="panel-body">
      <form id="form1" name="form1" method="POST" action="/admin/cliente/nuevo">
            <div class="row">
                <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
                <input type="hidden" id="id" name="id" class="form-control" value="{{$globalId}}" required>
                <div class="form-group col-lg-6">
                    <label>Nombre: </label>
                    <input type="text" id="txtNombre" name="txtNombre" class="form-control" value="{{ $cliente->nombre}}" required>
                </div>
                <div class="form-group col-lg-6">
                        <label for="">Dirección:</label>
                        <input type="text" id="txtDireccion" name="txtDireccion" class="form-control" value="{{ $cliente->direccion}}" required>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-lg-6">
                    <label for="txtCorreo">Correo:</label>
                    <input type="email" id="txtCorreo" name="txtCorreo" class="form-control" value="{{ $cliente->correo}}" required>
                </div>
                <div class="form-group col-lg-6">
                    <label for="txtDni">DNI:</label>
                    <input type="number" id="txtDni" name="txtDni" class="form-control" min="1000000" max="99999999" value="{{ $cliente->dni}}" required>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-lg-6">
                    <label for="txtTelefono">Teléfono:</label>
                    <input type="number" id="txtTelefono" name="txtTelefono" class="form-control" value="{{ $cliente->telefono}}" required>
                </div>
                <div class="form-group col-lg-6">
                    <label for="txtClave">Clave:</label>
                    <input type="password" id="txtClave" name="txtClave" class="form-control" value="{{ $cliente->clave}}" required>
                </div>
            </div>
      </form>
      <script>

    /*$(document).ready(function() {
        if (typeof $.fn.validate === 'function') {
            $("#form1").validate();
        }
    });*/
    $("#form1").validate();

    function guardar(){
        if($("#form1").valid()) {
            modificado = false;
            form1.submit();
        }else{
            $("#modalGuardar").modal('toggle');
            msgShow("Corrija los errores e intente nuevamente.", "danger");
            return false;
        }
    }
</script>
@endsection
