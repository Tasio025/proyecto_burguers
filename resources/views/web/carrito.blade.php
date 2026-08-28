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
                                          <td>${{ $carritos->precio }}</td>
                                          <td>
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}"><!--El profe no tiene esto acá-->
                                                <!-- El profe agrega esta linea acá no se por que o donde debería agregarla<input type="hidden" class="form-control" value="{{ $carrito->fk_idproducto }}" type="number" name="txtCantidad" id="txtCantidad">-->
                                                <input type="hidden" name="txtCarrito" id="txtCarrito" class="form-control" value="{{ $carritos->idcarritos }}">
                                                <input class="form-control" type="number" value="{{ $carritos->cantidad }}" name="txtCantidad" id="txtCantidad" min="1">
                                          </td>
                                          <td><img src="/files/productos/{{ $carritos->imagen }}" alt="{{ $carritos->producto }}" width="100"></td>
                                          <td>${{ number_format($carritos->precio * $carritos->cantidad) }}</td>
                                          <td>
                                                <a href="/carrito/eliminar/{{ $carritos->idcarritos }}" class="btn btn-danger">Eliminar</a>
                                          </td>
                                          <td>
                                                <button type="submit" class="btn btn-info">Actualizar</button>
                                          </td>
                                    </form>
                                    <!--Version del profe-->
                                        <!--  <td>{{ $carritos->producto }}</td>
                                          <td>${{ number_format($carritos->precio, 2) }}</td>
                                          <td style="width: 0px;">
                                                <form action="">
                                                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                      <input type="hidden" id="txtCarrito" name="txtCarrito" class="form-control" value="{{ $carritos->idcarritos }}">
                                                      <input type="number" id="txtCantidad" name="txtCantidad" min="0" class="form-control" style="width: 65px;" value="{{ $carritos->cantidad }}">
                                                </form>
                                          </td>
                                          <td>
                                                <img src="/files/productos/{{ $carritos->imagen }}" alt="{{ $carritos->producto }}" class="img-thumbnail">
                                          </td>
                                          <td>${{ number_format($carritos->precio * $carritos->cantidad, 2) }}</td>
                                          <td>
                                                <div class="btn-group">
                                                      <button type="submit" class="btn btn-info" id="btnActualizar" name="btnActualizar" form="formCarrito{{ $carritos->idcarritos }}">
                                                            <i class="bi bi-arrow-clockwise">Actualizar</i>
                                                      </button>
                                                      <button type="submit" class="btn btn-danger" id="btnBorrar" name="btnBorrar" form="formCarrito{{ $carritos->idcarritos }}">
                                                            <i class="bi bi-trash">Eliminar</i>
                                                      </button>
                                                </div>
                                          </td>-->
                              </tr>
                              @endforeach
                        </tbody>
                  </table>
            </div>
            <div class="col-md-3">
                  <div class="row mt-2 p-2">
                        <div class="col-md-12">
                              <table class="table">
                                    <thead>
                                          <tr>
                                                <th>TOTAL: </th>
                                          </tr>
                                    </thead>
                                    <form action="" method="POST">
                                    <tbody>
                                          <tr>
                                                <td>
                                                      <label>Sucursal: </label>
                                                      <select name="lstSucursal" id="lstSucursal" class="form-select">
                                                            <option value="" disabled selected>Seleccionar</option>
                                                            @foreach($aSucursales as $sucursal)
                                                            <option value="{{ $sucursal->idsucursal }}">{{ $sucursal->idsucursal }}</option>
                                                            @endforeach
                                                      </select>
                                                </td>
                                          </tr>
                                          <tr>
                                                <label>Método de pago:</label>
                                                <select name="lstPago" id="lstPago" class="form-select" required>
                                                      <option value="" disabled selected>Seleccionar</option>
                                                      <option value="mercado">MercadoPago</option>
                                                      <option value="credito">Crédito</option>
                                                      <option value="debito">Débito</option>
                                                      <option value="efectivo">Efectivo</option>
                                                </select>
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