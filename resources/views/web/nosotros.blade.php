@extends("web.plantilla")
@section("contenido")
  <!-- about section -->

  <section class="about_section layout_padding">
    <div class="container  ">

      <div class="row">
        <div class="col-md-6 ">
          <div class="img-box">
            <img src="web/images/about-img.png" alt="">
          </div>
        </div>
        <div class="col-md-6">
          <div class="detail-box">
            <div class="heading_container">
              <h2>
                Somos Feane
              </h2>
            </div>
            <p>
              There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration
              in some form, by injected humour, or randomised words which don't look even slightly believable. If you
              are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in
              the middle of text. All
            </p>
            <a href="">
              Leer más
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- end about section -->

<!-- client section -->

  <section class="client_section layout_padding-bottom">
    <div class="container">
      <div class="heading_container heading_center psudo_white_primary mb_45">
        <h2>
          Comentarios de nuestros clientes
        </h2>
      </div>
      <div class="carousel-wrap row ">
        <div class="owl-carousel client_owl-carousel">
          <div class="item">
            <div class="box">
              <div class="detail-box">
                <p>
                  Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam
                </p>
                <h6>
                  Moana Michell
                </h6>
                <p>
                  Magna Aliqua
                </p>
              </div>
              <div class="img-box">
                <img src="web/images/client1.jpg" alt="" class="box-img">
              </div>
            </div>
          </div>
          <div class="item">
            <div class="box">
              <div class="detail-box">
                <p>
                  Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam
                </p>
                <h6>
                  Mike Hamell
                </h6>
                <p>
                  Magna Aliqua
                </p>
              </div>
              <div class="img-box">
                <img src="web/images/client2.jpg" alt="" class="box-img">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--FALTA AGREGAR EL "TRABAJÁ CON NOSOTROS"-->
  </section>

  <!-- end client section --> 
   <section class="layout_padding">
    <div class="container">
      <div class="heading_container heading_center mb_45">
        <h2>¡Trabajá con nosotros!</h2>
      </div>
      @if(isset($msg))
        <div class="alert alert-{{ $msg['ESTADO'] }}">
          {{ $msg['MSG'] }}
        </div>
        @endif

        <form action="/nosotros" method="POST" class="row justify-content-center">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <div class="col-md-6 mb-3">
            <label for="txtNombre" class="form-label">Nombre</label>
            <input type="text" name="txtNombre" id="txtNombre" class="form-control" required>
          </div>
          <div class="col-md-6 mb-3">
            <label for="txtApellido" class="form-label">Apellido</label>
            <input type="text" name="txtApellido" id="txtApellido" class="form-control" required>
          </div>
          <div class="col-md-6 mb-3">
            <label for="txtCelular" class="form-label">Número de teléfono</label>
            <input type="text" name="txtCelular" id="txtCelular" class="form-control" placeholder="+54..." required>
          </div>
          <div class="col-md-6 mb-3">
            <label for="txtCorreo" class="form-label">Correo electrónico</label>
            <input type="email" name="txtCorreo" id="txtCorreo" class="form-control" required>
          </div>
          <div class="col-md-6 mb-3">
            <label for="txtCV" class="form-label">Link a tu CV</label>
            <input type="text" name="txtCV" id="txtCV" class="form-control" placeholder="Linkedin, Drive, etc...">
          </div>
          <div class="col-md-12 text center">
            <button type="submit" class="btn btn-warning">Enviar postulación</button>
          </div>
        </form>
    </div>
   </section>
  @endsection