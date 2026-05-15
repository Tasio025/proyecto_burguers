@extends("Plantilla")
@section('titulo', $titulo)
@section('scripts')
<script>
    globalId = '<?php echo isset($producto->idproducto) && $producto->idproducto > 0 ? $producto->idproducto : 0; ?>';
    <?php $globalId = isset($producto->idproducto) ? $producto->idproducto : "0";?>
</script>
@endsection
@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/admin">Inicio</a></li>
    <li class="breadcrumb-item"><a href="/admin/productos">Productos</a></li>
    <li class="breadcrumb-item active">Modificar</li>
</ol>
<ol class="toolbar">
    <li class="btn-item"><a title="Nuevo" href="/admin/sistema/producto/nuevo" class="fa fa-plus-circle" aria-hidden="true"><span>Nuevo</span></a></li>
    <li class="btn-item"><a title="Guardar" href="#" class="fa fa-floppy-o" aria-hidden="true" onclick="javascript: $('#modalGuardar').modal('toggle');"><span>Guardar</span></a>
    </li>
    @if($globalId > 0)
    <li class="btn-item"><a title="Guardar" href="#" class="fa fa-trash-o" aria-hidden="true" onclick="javascript: $('#mdlEliminar').modal('toggle');"><span>Eliminar</span></a></li>
    @endif
    <li class="btn-item"><a title="Salir" href="#" class="fa fa-arrow-circle-o-left" aria-hidden="true" onclick="javascript: $('#modalSalir').modal('toggle');"><span>Salir</span></a></li>
</ol>
<script>
function fsalir(){
    location.href ="/admin/sistema/productos";
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
<div id = "msg"></div>
<div class="panel-body">
      <form id="form1" method="POST" action="/admin/producto/nuevo" enctype="multipart/form-data">
            <div class="row">
                <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
                <input type="hidden" id="idproducto" name="idproducto" class="form-control" value="{{$globalId}}" required>
                <div class="form-group col-lg-6">
                    <label>Nombre: </label>
                    <input type="text" id="txtNombre" name="txtNombre" class="form-control" value="{{ $producto->nombre ?? '' }}" required>
                </div>
                <div class="form-group col-lg-6">
                        <label for="">Cantidad:</label>
                        <input type="number" id="txtCantidad" name="txtCantidad" class="form-control" value="{{ $producto->cantidad ?? '' }}" required>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-lg-6">
                    <label for="txtCorreo">Precio:</label>
                    <input type="number"  id="txtPrecio" name="txtPrecio" class="form-control" value="{{ $producto->precio ?? '' }}" required>
                </div>
                <div class="form-group col-lg-6">
                    <label>Imagen:</label>
                    <input type="file" id="txtImagen" name="txtImagen" class="form-control-file">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-lg-6">
                    <label for="lstTipoproducto">Tipo de producto: </label>
                    <select name="lstTipoproducto" id="lstTipoproducto" class="form-control">
                        @foreach($aCategorias as $categoria)
                        <!--<option value="{{$categoria->idtipoproducto}}">{{$categoria->nombre}}</option>-->
                        <option value="{{$categoria->idtipoproducto}}" {{ $producto->fk_idcategoria == $categoria->idtipoproducto ? 'selected' : '' }}>{{$categoria->nombre}}</option>
                        @endforeach
                    </select>

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
    function eliminar(){
        $.ajax({
            type: "GET",
            url: "{{ asset('/admin/producto/eliminar')}}",
            data: {idproducto:globalId},
            async: true,
            success: function(data){
                if(data.err == 0){
                    msgShow(data.mensaje, "success");
                    $("#btnEnviar").hide();
                    $("#btnEliminar").hide();
                    $("#mdlEliminar").modal("toggle");
                }else{
                    msgShow(data.mensaje, "danger");
                    $("#mdlEliminar").modal("toggle");
                }
            }
        })
    }
</script>

@endsection


