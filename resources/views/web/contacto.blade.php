@extends("web.plantilla")
@section("contenido")
  <!-- book section -->
  <section class="book_section layout_padding">
    <div class="container">
      <div class="heading_container">
        <h2>
          Contactanos
        </h2>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form_container">
            <form action="" name="form1" id="form1" method="POST">
              <div>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
              </div>
              <div>
                <input type="text" class="form-control" placeholder="Tu nombre" />
              </div>
              <div>
                <input type="text" class="form-control" placeholder="Número de teléfono" />
              </div>
              <div>
                <input type="email" class="form-control" placeholder="Tu correo electrónico" />
              </div>
              <div>
                <select class="form-control nice-select wide">
                  <option value="" disabled selected>
                    Cuantas personas?
                  </option>
                  <option value="">
                    1
                  </option>
                  <option value="">
                    2
                  </option>
                  <option value="">
                    3
                  </option>
                  <option value="">
                    4
                  </option>
                  <option value="">
                    5
                  </option>
                </select>
              </div>
              <div>
                <input type="date" class="form-control">
              </div>
              <div class="btn_box">
                <button>
                  Book Now
                </button>
              </div>
            </form>
          </div>
        </div>
        <div class="col-md-6">
          <div class="map_container ">
            <div id="googleMap"></div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- end book section -->

@endsection