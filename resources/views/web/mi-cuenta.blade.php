@extends("web.plantilla")
@section("contenido")

<section class="book_sectin layout_padding">
      <div class="container-fluid">
            <!--Acá van los datos del usuario-->
            <div class="heading_container heading_center mb-4">
                  <h2 style="font-family: 'Dancing script', cursive; margin-bottom: 30px;">
                        Mi Cuenta
                  </h2>
            </div>
            <form class="text-center" id="form1" name="form1" method="POST" action='/mi-cuenta'>
                  <div class="row mb-4">
                         <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
                        <div class="col-md-6">
                              <input type="text" class="form-control" name="txtNombre" id="txtNombre" placeholder="Nombre" value="" required>
                        </div>
                        <div class="col-md-6">
                              <input type="text" class="form-control" name="txtApellido" id="txtApellido" placeholder="Apellido" value="" required>
                        </div>
                  </div>
                  <div class="row mb-4">
                        <div class="col-md-6">
                              <input type="number" class="form-control" name="txtTelefono" id="txtTelefono" placeholder="Teléfono" value="" required>
                        </div>
                        <div class="col-md-6">
                              <input type="number" class="form-control" name="txtWpp" id="txtWpp" placeholder="WhatsApp" value="" required>
                        </div>
                  </div>
                  <div class="row mb-4">
                        <div class="col-md-6">
                              <input type="email" class="form-control" name="txtCorreo" id="txtCorreo" placeholder="Email" value="" required>
                        </div>
                  </div>
            </form>
            <!--Acá van a venir los pedidos que tenga activos-->
            <div class="heading_container mt-5">
                  <h3>Pedidos activos</h3>
            </div>
            <div class="row">
                  <div class="col-12">
                        <table class="table table-bordered table-striped">
                              <thead>
                                    <tr>
                                          <th>#</th>
                                          <th>Fecha</th>
                                          <th>Sucursal</th>
                                          <th>Total</th>
                                          <th>Estado</th>
                                    </tr>
                              </thead>
                              <tbody>
                                    @if(isset($aPedidos) && count($aPedidos) > 0)
                                    @foreach($aPedidos as $pedido)
                                    <tr>
                                          <td>{{ $pedido->idpedido }}</td>
                                          <td>{{ $pedido->fecha }}</td>
                                          <td>{{ $pedido->sucursal }}</td>
                                          <td>{{ $pedido->total }}</td>
                                          <td>{{ $pedido->estado }}</td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                          <td colspan="5" class="text-center">
                                                No tiene pedidos activos
                                          </td>
                                    </tr>
                                    @endif
                              </tbody>
                        </table>
                  </div>
            </div>
      </div>
</section>

@endsection