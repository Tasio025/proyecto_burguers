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
                Somos Gula Burguers SRL
              </h2>
            </div>
            <p>
              Nacimos en 2026, en la zona oeste de Buenos Aires, con la idea de ofrecer hamburguesas artesanales y de rápida preparación para nuestros clientes. Con el paso del tiempo, fuimos explorando nuevas opciones y descubrimos nuestro gusto por la variedad, incorporando diferentes tipos de comidas sin dejar de lado nuestras raíces.
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
                  Me sorprendió la calidad de las comidas, sobre todo de las haburguesas! el pan de muy buena calidad y la carne siempre al punto justo! definitivamente recomendaría comer aquí
                </p>
                <h6>
                  Brisa Quinteros
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
                  Me llevé una sorpresa con las pizzas cuando pedí para llevar la ultima juntada con mis amigos, definitivamente muy conformes con la comida y el sistema de pedidos!
                </p>
                <h6>
                  Bruno Larosa
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
        
        <form action="" method="POST" class="row justify-content-center" enctype="multipart/form-data">
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
            <label for="txtCV">Cargar CV</label>
            <input type="file" name="txtCV" id="txtCV" class="form-control-file" accept=".pdf, .doc, .docx" required>
            <small class="d-block">Archivos admitidos: .pdf, .doc, .docx</small>
          </div>
          <div class="col-md-12 text center">
            <button type="submit" class="btn btn-warning">Enviar postulación</button>
          </div>
        </form>
    </div>
   </section>
  @endsection