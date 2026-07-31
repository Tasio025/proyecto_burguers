@extends("web.plantilla")
@section("contenido")

<section class="book_section layout_padding">
      <div class="heading_container mt-5">
            <h2>Mi carrito</h2>
      </div>
      <div class="row">
            <div class="col-12">
                  <table class="table table-bordered table-striped">
                        <thead>
                              <tr>
                                    <th>Precio</th>
                                    <th>Cantidad</th>
                                    <th>Subtotal</th>
                              </tr>
                        </thead>
                        <tbody>
                              <tr>  <!--Esto lo tengo que revisar, no se si está bien-->
                                    <td>{{ $carrito->precio }}</td>
                                    <td>{{ $carrito->cantidad }}</td>
                                    <td>{{ $carrito->total }}</td>
                              </tr>
                        </tbody>
                  </table>
            </div>
      </div>

</section>



@endsection 