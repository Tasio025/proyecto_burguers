@extends("web.plantilla")
@section("contenido")

@php use App\Entidades\Cliente; @endphp
<section class="book_section layout_padding">
      <div class="heading_container mt-5">
            <h2>Mi carrito</h2>
      </div>
      <div class="row">
            @if(!Cliente::autenticado())
            <!--Iniciar sesión-->
            <div class="alert alert-warning">
                  Debe iniciar sesión para poder ver su carrito 
                  <a href="{{ route('web.login') }}">Iniciar sesión</a>
            </div>
            @elseif($aCarritos == NULL)
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
                                    <th>Subtotal</th>
                              </tr>
                        </thead>
                        <tbody>
                              <tr>  <!--Esto lo tengo que revisar, no se si está bien-->                        
                                    <td>{{ $carritos->nombre }}</td>
                                    <td>{{ $carritos->precio }}</td>
                                    <td>{{ $carritos->cantidad }}</td>
                                    <td>{{ $carritos->total }}</td>
                              </tr>
                        </tbody>
                  </table>
            </div>
            @endif
      </div>

</section>



@endsection 