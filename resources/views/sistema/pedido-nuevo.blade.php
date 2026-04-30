@extends("PLantilla")
@section('titulo', $titulo)
@section('scripts')
<script>
    globalId = '<?php echo isset($pedidos->idpedido) && $pedidos->idpedido > 0 ? $pedidos->idpedido : 0; ?>';
    <?php $globalId = isset($pedidos->idpedido) ? $pedidos->idpedido : "0";?>
</script>
@endsection 
@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/admin">Inicio</a></li>
    <li class="breadcrumb-item"><a href="/admin/pedido">Pedidos</a></li>
    <li class="breadcrumb-item active">Modificar</li>
</ol>
<ol class="toolbar">
    <li class="btn-item"><a title="Nuevo" href="/admin/sistema/pedidos/nuevo" class="fa fa-plus-circle" aria-hidden="true"><span>Nuevo</span></a></li>
    <li class="btn-item"><a title="Guardar" href="#" class="fa fa-floppy-o" aria-hidden="true" onclick="javascript: $('#modalGuardar').modal('toggle');"><span>Guardar</span></a>
    </li>
    @if($globalId > 0)
    <li class="btn-item"><a title="Guardar" href="#" class="fa fa-trash-o" aria-hidden="true" onclick="javascript: $('#mdlEliminar').modal('toggle');"><span>Eliminar</span></a></li>
    @endif
    <li class="btn-item"><a title="Salir" href="#" class="fa fa-arrow-circle-o-left" aria-hidden="true" onclick="javascript: $('#modalSalir').modal('toggle');"><span>Salir</span></a></li>
</ol>
<script>
function fsalir(){
    location.href ="/admin/sistema/pedidos";
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
      <form id="form1" method="POST" action="/admin/pedido/nuevo">
            <div class="row">
                <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
                <input type="hidden" id="id" name="id" class="form-control" value="{{$globalId}}" required>
                <div class="form-group col-lg-6">
                    <label>Fecha </label>
                    <input type="date" id="txtFecha" name="txtFecha" class="form-control" value="{{$pedido->fecha ?? ''}}" required>
                </div>
                <div class="form-group col-lg-6">
                        <label for="txtSucursal">Sucursal: </label>
                        <input type="text" id="txtSucursal" name="txtSucursal" class="form-control" value="{{$pedido->fk_idsucursal ?? ''}}" required>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-lg-6">
                    <label for="txtCliente">Cliente: </label>
                    <input type="text" id="txtCliente" name="txtCliente" class="form-control" value="{{$pedido->fk_idcliente ?? ''}}" required>
                </div>
                <div class="form-group col-lg-6">
                    <label for="txtEstado">Estado del pedido</label>
                    <select name="txtEstado" id="txtEstado" class="form-control" required>
                        <option value="">Seleccionar...</option>
                        <option value="1">Pendiente (pendiente por pago)</option>
                        <option value="2">En preparacion</option>
                        <option value="3">Entregado</option>
                        <option value="4">Cancelado</option>
                        <option value="5">Pendiente (pago por MP)</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-lg-6">
                    <label for="txtTotal">Total: </label>
                    <input type="number" id="txtTotal" name="txtTotal" class="form-control" required>
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
