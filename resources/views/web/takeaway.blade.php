@extends("web.plantilla")
@section("contenido")
@if(isset($msg))
  {{ $msg["MSG"] }}
@endif
  <!-- food section -->
  <section class="food_section layout_padding">
    <div class="container">
      <div class="heading_container heading_center">
        <h2>
          Nuestro Menú
        </h2>
      </div>
      <ul class="filters_menu">
        <li class="active" data-filter="*">TODO</li>
        @foreach($aCategorias as $categoria)
          <li data-filter=".cat-{{ $categoria->idcategoria }}">{{ $categoria->nombre }}</li>
        @endforeach
      </ul>
      <div class="filters-content">
<!--Acá debería haber un foreach que me devuelva todos los productos o tipo de productos que haya en la base de datos-->
        <div class="row grid">
         @foreach($aProductos as $producto)
          <div class="col-sm-6 col-lg-4 all cat-{{ $producto->fk_idcategoria }}">
            <div class="box"> 
              <div>
                <div class="img-box">
                  <img src="/files/productos/{{ $producto->imagen }}" alt="">
                </div>
                <div class="detail-box">
                  <h5>
                    {{ $producto->nombre }}
                  </h5>
                  <p>
                    {{ $producto->descripcion ?? ''}}  
                  </p>
                  <div class="options">
                    <h6>
                     $ {{ number_format($producto->precio, 0, ',', '.') }}
                    </h6>
                    <form action="/takeaway" method="POST" class="d-flex align-items-center gap-2">
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <input type="hidden" name="idproducto" id="idproducto-{{ $producto->idproducto }}" value="{{ $producto->idproducto }}">
                      <input type="number" name="txtCantidad" id="txtCantidad-{{ $producto->idproducto }}" class="form-control text-center" style="width: 65px;" value="0" required>
                      <button type="submit" class="btn btn-warning d-flex align-items-center justify-content-center">
                        <i class="bi bi-cart-plus-fill">
                        </i>
                      </button>
                    </form>
                    <!--Cantidad del producto que desea agregar al carrito-->
                    <!--<form action="/carrito" method="POST" class="d-flex align-items-center">
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <input type="hidden" id="idproducto" name="idproducto" class="form-control" style="width: 50px;" value="{{ $producto->idproducto }}" required>
                      <input type="number" name="txtCantidad" id="txtCantidad" class="form-control" style="width: 50px; text-align:center; margin-right: 100px" value="0" required>-->
                      <!--Acá cambié el nombre del producto por el id del producto como campo oculto así el formulario sabe que producto 
                      estamos agregando-->
                      <!--<button type="submit" class="btn btn-warning d-flex align-items-center justify-content-center">
                        <i class="bi bi-cart-plus-fill"></i>      
                      </button>
                    </form>-->
                    <!--<a href="/carrito?idproducto={{ $producto->idproducto }}">
                      <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 456.029 456.029" style="enable-background:new 0 0 456.029 456.029;" xml:space="preserve">
                        <g>
                          <g>
                            <path d="M345.6,338.862c-29.184,0-53.248,23.552-53.248,53.248c0,29.184,23.552,53.248,53.248,53.248
                         c29.184,0,53.248-23.552,53.248-53.248C398.336,362.926,374.784,338.862,345.6,338.862z" />
                          </g>
                        </g>
                        <g>
                          <g>
                            <path d="M439.296,84.91c-1.024,0-2.56-0.512-4.096-0.512H112.64l-5.12-34.304C104.448,27.566,84.992,10.67,61.952,10.67H20.48
                         C9.216,10.67,0,19.886,0,31.15c0,11.264,9.216,20.48,20.48,20.48h41.472c2.56,0,4.608,2.048,5.12,4.608l31.744,216.064
                         c4.096,27.136,27.648,47.616,55.296,47.616h212.992c26.624,0,49.664-18.944,55.296-45.056l33.28-166.4
                         C457.728,97.71,450.56,86.958,439.296,84.91z" />
                          </g>
                        </g>
                        <g>
                          <g>
                            <path d="M215.04,389.55c-1.024-28.16-24.576-50.688-52.736-50.688c-29.696,1.536-52.224,26.112-51.2,55.296
                         c1.024,28.16,24.064,50.688,52.224,50.688h1.024C193.536,443.31,216.576,418.734,215.04,389.55z" />
                          </g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                      </svg>
                    </a>-->
                  </div>
                </div>
              </div>
            </div>
          </div>
         @endforeach
         
        </div>
      </div>
      <div class="btn-box">
        <a href="">
          View More
        </a>
      </div>
    </div>
  </section>

  <!-- end food section -->

 @endsection