@extends("web.plantilla")
@section("contenido")

<section class="book_section layout_padding">
      <div class="container-fluid">
            <!--Acá van los datos del usuario-->
            <div class="heading_container heading_center mb-4">
                  <h2 style="font-family: 'Dancing script', cursive; margin-bottom: 30px;">
                        Mi Cuenta
                  </h2>
            </div>
            <div class="row">
                  <div class="col-md-10 mx-auto">
                        <div class="form_container">
                              <form class="text-center" id="form1" name="form1" method="POST" action='/mi-cuenta'>
                                    <div class="row mb-4">
                                          <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
                                          <div class="col-md-6">
                                                <input type="text" class="form-control" name="txtNombre" id="txtNombre" placeholder="Nombre" value="{{ $cliente->nombre ?? '' }}" required>
                                          </div>
                                          <div class="col-md-6">
                                                <input type="text" class="form-control" name="txtApellido" id="txtApellido" placeholder="Apellido" value="{{ $cliente->apellido ?? '' }}" required>
                                          </div>
                                    </div>
                                    <div class="row mb-4">
                                          <div class="col-md-6">
                                                <input type="number" class="form-control" name="txtTelefono" id="txtTelefono" placeholder="Teléfono" value="{{ $cliente->celular ?? '' }}" required>
                                          </div>
                                          <div class="col-md-6">
                                                <input type="number" class="form-control" name="txtWpp" id="txtWpp" placeholder="WhatsApp" value="{{ $cliente->whatsapp ?? '' }}" required>
                                          </div>
                                    </div>
                                    <div class="row mb-4">
                                          <div class="col-md-6">
                                                <input type="email" class="form-control" name="txtCorreo" id="txtCorreo" placeholder="Email" value="{{ $cliente->correo ?? '' }}" required>
                                          </div>
                                    </div>
                                    <!--Guardar cambios-->
                                    <div class="row mb-4">
                                          <div class="col-md-12 text center">
                                                <button type="submit" class="btn btn-warning rounded-pill px-5 text-white" style="background-color: #ffbe33;">GUARDAR</button>
                                          </div>
                                    </div>
                                    <div class="row mb-4">
                                          <div class="col-md-12 text-center">
                                                <a href="/cambiar-clave" style="color: #222831; text-decoration: underline;">CAMBIAR CONTRASEÑA</a>
                                          </div>
                                    </div>
                              </form>
                        </div>
                  </div>
            </div>
            <!--Acá van a venir los pedidos que tenga activos-->
            <div class="heading_container mt-5">
                  <h3>Pedidos activos</h3>
            </div>
            <div class="row">
                  <div class="col-12">
                        <table class="table table-bordered table-striped">
                              <thead>
                                    <tr>  <!--Acá van todos los datos de la tabla pedidos-->
                                          <th>#</th><!--idpedido-->
                                          <th>Fecha</th>
                                          <th>Descripción</th>
                                          <th>Importe Total</th>
                                          <th>Sucursal</th>
                                          <th>Estado</th>
                                    </tr>
                              </thead>
                              <tbody>
                                    @if(isset($aPedidos) && count($aPedidos) > 0)
                                    @foreach($aPedidos as $pedido)
                                    <tr>
                                          <td>{{ $pedido->idpedido }}</td>
                                          <td>{{ $pedido->fecha }}</td>
                                          <td>{{ $pedido->descripcion }}</td>
                                          <td>{{ number_format($pedido->total, 2, ',', '.') }}</td>
                                          <td>{{ $pedido->nombre_sucursal }}</td>
                                          <td>{{ $pedido->nombre_estado }}</td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                          <td colspan="6" class="text-center">
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