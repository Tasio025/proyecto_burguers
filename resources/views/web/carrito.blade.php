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
                                          <th>Actualizar</th>
                                    </tr>
                              </thead>
                              <input type="hidden" name="_token" value="{{ csrf_token() }}">
                              <tbody>
                                    <?php
                                    $subtotal = 0;
                                    ?>
                                    @foreach($aCarritos as $carritos)
                                    <?php
                                    $subtotal += $carritos->precio * $carritos->cantidad;
                                    ?>
                                    <form id="formCarrito{{ $carritos->idcarritos }}" action="/carrito" method="POST"></form>
                                    <tr>
                                          <!--Version mia-->                      
                                                <td>
                                                      <input type="hidden" name="_token" value="{{ csrf_token() }}" form="formCarrito{{ $carritos->idcarritos }}">
                                                      <input type="hidden" name="txtCarrito" id="txtCarrito" class="form-control" value="{{ $carritos->idcarritos }}" form="formCarrito{{ $carritos->idcarritos }}">  
                                                      {{ $carritos->producto }}
                                                </td>
                                               <!-- <td style="width: 100px;">
                                                      <img src="/files/productos/{{ $carritos->imagen }}" alt="{{ $carritos->producto }}" width="100">
                                                </td>-->
                                                <td>${{ $carritos->precio }}</td>
                                                <td>
                                                      <input type="hidden" class="form-control" value="{{ $carritos->fk_idproductos }}" type="number" name="txtProducto" id="txtProducto" form="formCarrito{{ $carritos->idcarritos }}">
                                                      <input class="form-control" type="number" value="{{ $carritos->cantidad }}" name="txtCantidad" id="txtCantidad" min="1" form="formCarrito{{ $carritos->idcarritos }}">
                                                </td>
                                                <td><img src="/files/productos/{{ $carritos->imagen }}" alt="{{ $carritos->producto }}" width="100"></td>
                                                <td>${{ number_format($carritos->precio * $carritos->cantidad) }}</td>
                                                <td>
                                                      @if(isset($msg))
                                                            <div class="alert alert-{{ $msg['ESTADO'] }}">
                                                                  {{ $msg['MSG'] }}
                                                            </div>
                                                      @endif 
                                                      <a href="/carrito/eliminar/{{ $carritos->idcarritos }}" class="btn btn-danger">Eliminar</a>
                                                </td>
                                                <td>
                                                      <button type="submit" class="btn btn-info" name="btnActualizar" form="formCarrito{{ $carritos->idcarritos }}">Actualizar</button>
                                                </td>      
                                    </tr>
                                    <!--</form>-->
                                    @endforeach
                              </tbody>
                              <!--</form>-->
                        </table>
            </div>
            <div class="col-md-3">
                  <!--<form action="/carrito" method="POST">-->
                        <div class="row mt-2 p-2">
                              <div class="col-md-12">
                                    <table class="table">
                                          <thead>
                                                <tr>
                                                      <?php $resultado = 0; 
                                                      foreach($aCarritos as $carrito){
                                                            ($resultado += $carrito->cantidad * $carrito->precio);

                                                      }
                                                      ?>
                                                      <th>TOTAL: ${{ number_format($resultado, 2) }}</th>
                                                </tr>
                                          </thead>
                                          <form action="/carrito" method="POST">
                                          <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
                                                <tbody>
                                                      <tr>
                                                            <td>
                                                                  <label class="d-block">Sucursal: </label>
                                                                  <select name="lstSucursal" id="lstSucursal" class="form-select" required>
                                                                        <option value="" disabled selected>Seleccionar</option>
                                                                        @foreach($aSucursales as $sucursal)
                                                                        <option value="{{ $sucursal->idsucursales }}">{{ $sucursal->idsucursales }}</option>
                                                                        @endforeach
                                                                  </select>
                                                            </td>
                                                      </tr>
                                                      <tr>
                                                            <td>
                                                                  <label class="d-block">Método de pago:</label>
                                                                  <select name="lstPago" id="lstPago" class="form-select" required>
                                                                        <option value="" disabled selected>Seleccionar</option>
                                                                        <option value="MercadoPago">MercadoPago</option>
                                                                        <option value="Tarjeta de Crédito">Crédito</option>
                                                                        <option value="Tarjeta de Débito">Débito</option>
                                                                        <option value="Efectivo">Efectivo</option>
                                                                  </select>
                                                            </td>
                                                      </tr>
                                                      <tr>
                                                            <td>
                                                                  <button type="submit" class="btn btn-success" id="btnFinalizar" name="btnFinalizar">Finalizar Compra</button>
                                                            </td>
                                                      </tr>
                                                </tbody>
                                          </form>
                                    </table>
                              </div>
                        </div>
            </div>
            @endif
      </div>

</section>



@endsection 