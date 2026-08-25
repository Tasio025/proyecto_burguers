@extends("web.plantilla")
@section("contenido")
<section class="book_section layout_padding">
      <div class="heading_container mt-5">
            <h2>Mi carrito</h2>
      </div>
      <div class="row">
            <!--Pregunta: Podría ir un if con "!Cliente::autenticado()" ?--> 
            @if(!Session::get("idcliente"))
            <!--Iniciar sesión-->
            <div class="alert alert-warning">
                  Debe iniciar sesión para poder ver su carrito 
                  <a href="/login">Iniciar sesión</a>
            </div>
            @elseif($aCarritos == null)
            <!--Mostrar tabla vacía ("No hay productos seleccionados")-->
            <div class="alert alert-warning">
                  No hay productos seleccionados.      
            </div>
            @else
            <div class="col-12">
                  <table class="table table-bordered table-striped">
                        <thead>
                              <tr>
                                    <th>Producto</th>
                                    <th>Precio</th>
                                    <th>Cantidad</th>
                                    <th>Imagen</th>
                                    <th>Subtotal</th>
                                    <th>Eliminar</th>
                              </tr>
                        </thead>
                        <tbody>
                               @foreach($aCarritos as $carritos)
                              <tr>  <!--Esto lo tengo que revisar, no se si está bien-->
                                    <<!--Version mia-->      
                                    <form action="" method="POST">                  
                                          <td>{{ $carritos->producto }}</td>
                                          <td>{{ $carritos->precio }}</td>
                                          <td>{{ $carritos->cantidad }}</td>
                                          <td><img src="/files/productos/{{ $carritos->imagen }}" alt="{{ $carritos->producto }}" width="100"></td>
                                          <td>{{ $carritos->precio * $carritos->cantidad }}</td>
                                          <td>
                                                <a href="/carrito/eliminar/{{ $carritos->idcarritos }}" class="btn btn-danger">Eliminar</a>
                                          </td>
                                    </form>
                                    <!--Version del profe-->
                                    <form action="" method="POST">
                                          <td style="width: 0px;">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="hidden" id="txtCarrito" name="txtCarrito" class="form-control">
                                          </td>
                                          <td style="width: 100px;">
                                                <img src="/files/productos/{{ $carritos->imagen }}" alt="{{ $carritos->producto }}" class="img-thumbnail">
                                          </td>
                                          <td>
                                                {{ $carrito->producto }}
                                          </td>
                                          <td>
                                                ${{ $carrito->precio }}
                                          </td>
                                          <td style="width: 15px">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="number" class="form-contol" value="{{ $carrito->cantidad }}">
                                          </td>
                                          <td>
                                                <div class="btn-group">
                                                      <button type="submit" class="btn btn-info" id="btnActualizar" name="btnActualizar"></button>
                                                      <button type="submit" class="btn btn-danger" id="btnBorrar" name="btnBorrar"></button>
                                                </div>
                                          </td>
                                    </form>
                              </tr>
                              @endforeach
                        </tbody>
                  </table>
            </div>
            @endif
      </div>

</section>



@endsection 