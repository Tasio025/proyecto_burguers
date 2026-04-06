@extends("Plantilla")
@section('titulo', $titulo) <!--Crea el título de la seccion-->
@section('scripts')<!--Crea los scripts -->
<script>
    globalId = '<?php echo isset($proveedor->idproveedor) && $proveedor->idproveedor > 0 ? $proveedor->idproveedor : 0; ?>';
    <?php $globalId = isset($proveedor->idproveedor) ? $proveedor->idproveedor : "0";?>
</script>
@endsection
@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/admin">Inicio</a></li>
    <li class="breadcrumb-item"><a href="/admin/proveedores">Proveedores</a></li>
    <li class="breadcrumb-item active">Modificar</li>
</ol>
<ol class="toolbar">
    <li class="btn-item"><a title="Nuevo" href="/admin/sistema/proveedores/nuevo" class="fa fa-plus-circle" aria-hidden="true"><span>Nuevo</span></a></li>
    <li class="btn-item"><a title="Guardar" href="#" class="fa fa-floppy-o" aria-hidden="true" onclick="javascript: $('#modalGuardar').modal('toggle');"><span>Guardar</span></a>
    </li>
    @if($globalId > 0)
    <li class="btn-item"><a title="Guardar" href="#" class="fa fa-trash-o" aria-hidden="true" onclick="javascript: $('#mdlEliminar').modal('toggle');"><span>Eliminar</span></a></li>
    @endif
    <li class="btn-item"><a title="Salir" href="#" class="fa fa-arrow-circle-o-left" aria-hidden="true" onclick="javascript: $('#modalSalir').modal('toggle');"><span>Salir</span></a></li>
</ol>
<script>
function fsalir(){
    location.href ="/admin/sistema/proveedores";
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
      <form id="form1" method="POST" action="/admin/proveedor/nuevo">
            <div class="row">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
                  <input type="hidden" id="id" name="id" class="form-control" value="{{$globalId}}" required>
                  <div class="form-group col-lg-6">
                    <label>Nombre:</label>
                    <input type="text" id="txtNombre" name="txtNombre" class="form-control" value="" required>
                  </div>
                  <div class="form-group col-lg-6">
                        <label for="">Dirección </label>
                        <input type="text" id="txtDireccion" name="txtDireccion" class="form-control" value="" required>
                  </div>
            </div>
            <div class="row">
                  <div class="form-group col-lg-6">
                    <label for="txtTelefono">Teléfono:</label>
                    <input type="number" id="txtTelefono" name="txtTelefono" class="form-control" required>
                  </div>
                  <div class="form-group col-lg-6">
                    <label for="txtCorreo">Correo:</label>
                    <input type="email" id="txtCorreo" name="txtCorreo" class="form-control" value="" required>
                  </div>
            </div>
      </form>
      <script>
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
