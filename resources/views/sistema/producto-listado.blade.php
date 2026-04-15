@extends("Plantilla")
@section('titulo', $titulo)
@section('scripts')<!--Crea los scripts -->
<link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet">
<script src="{{asset('js/datatables.min.js')}}"></script>
<script>
    globalId = '<?php echo isset($producto->idproducto) && $producto->idproducto > 0 ? $producto->idproducto : 0; ?>';
    <?php $globalId = isset($producto->idproducto) ? $producto->idproducto : "0";?>
</script>
@endsection
@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/admin">Inicio</a></li> <!--En el href el profe tiene "/home"-->
    <li class="breadcrumb-item"><a href="/admin/productos">Productos</a></li>
    <li class="breadcrumb-item active">Modificar</li>
</ol>
<ol class="toolbar">
    <li class="btn-item"><a title="Nuevo" href="/admin/sistema/productos/nuevo" class="fa fa-plus-circle" aria-hidden="true"><span>Nuevo</span></a></li>
<!--Acá el profe tiene RECARGAR, donde la ruta es "/admin/clientes/nuevo"-->
    <li class="btn-item"><a title="Recargar" href="#" class="fa fa-refresh" aria-hidden="true" onclick='window.location.replace("/admin/productos");'>Recargar</a></li>
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
@section('contenido')
<?php
if (isset($msg)) {
    echo '<div id = "msg"></div>';
    echo '<script>msgShow("' . $msg["MSG"] . '", "' . $msg["ESTADO"] . '")</script>';
}
?>
<table id="grilla" class="display">
      <thead>
            <tr>
                  <th>Nombre</th>
                  <th>Cantidad</th>
                  <th>Precio</th>
                  <th>Imagen</th>
                  <th>Tipo de producto</th>
            </tr>
      </thead>
</table>
<script>
      var dataTable = $('#grilla').DataTable({
            "processing" : true,
            "serverSide" : true,
            "bFilter" : true,
            "bInfo" : true,
            "bSearchable" : true,
            "pageLength" : 25,
            "order" : [[0, "asc"]],
            "ajax" : "{{ route('producto.cargarGrilla') }}"  
      });     
</script>
@endsection 