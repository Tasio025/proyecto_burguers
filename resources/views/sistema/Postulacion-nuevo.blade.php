@extends("Plantilla")
@section('titulo', $titulo)
@section('scripts')<!--Crea los scripts -->
<script>
    globalId = '<?php echo isset($postulacion->idpostulacion) && $postulacion->idpostulacion > 0 ? $postulacion->idpostulacion : 0; ?>';
    <?php $globalId = isset($postulacion->idpostulacion) ? $postulacion->idpostulacion : "0";?>
</script>
@endsection
@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/admin">Inicio</a></li>
    <li class="breadcrumb-item"><a href="/admin/postulaciones">Postulaciones</a></li>
    <li class="breadcrumb-item active">Modificar</li>
</ol>
<ol class="toolbar">
    <li class="btn-item"><a title="Nuevo" href="/admin/sistema/postulaciones/nuevo" class="fa fa-plus-circle" aria-hidden="true"><span>Nuevo</span></a></li>
     <li class="btn-item"><a title="Guardar" href="#" class="fa fa-floppy-o" aria-hidden="true" onclick="javascript: $('#modalGuardar').modal('toggle');"><span>Guardar</span></a>
    </li>
    @if($globalId > 0)
    <li class="btn-item"><a title="Guardar" href="#" class="fa fa-trash-o" aria-hidden="true" onclick="javascript: $('#mdlEliminar').modal('toggle');"><span>Eliminar</span></a></li>
    @endif
    <li class="btn-item"><a title="Salir" href="#" class="fa fa-arrow-circle-o-left" aria-hidden="true" onclick="javascript: $('#modalSalir').modal('toggle');"><span>Salir</span></a></li>
</ol>
<script>
function fsalir(){
    location.href ="/admin/sistema/postulaciones";
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
      <form id="form1" method="POST" action="/admin/postulacion/nuevo">
            <div class="row">
                <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
                <input type="hidden" id="id" name="id" class="form-control" value="{{$globalId}}" required>
                <div class="form-group col-lg-6">
                    <label>Nombre: </label>
                    <input type="text" id="txtNombre" name="txtNombre" class="form-control" value="" required>
                </div>
                <div class="form-group col-lg-6">
                        <label for="">Apellido: </label>
                        <input type="text" id="txtApellido" name="txtApellido" class="form-control" value="" required>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-lg-6">
                    <label for="txtCelular">Celular:</label>
                    <input type="number" id="txtCelular" name="txtCelular" class="form-control" value="" required>
                </div>
                <div class="form-group col-lg-6">
                    <label for="txtCorreo">Correo:</label>
                    <input type="email" id="txtCorreo" name="txtCorreo" class="form-control" value="" required>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-lg-6">
                    <label for="txtCV">CV:</label>
                    <input type="file" id="txtCV" name="txtCV" class="form-control" accept=".pdf, .doc, .docx" required>
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
