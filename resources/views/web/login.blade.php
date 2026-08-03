@extends("web.plantilla")
@section("contenido")

<section class="book_section layout_padding">
      <div class="container">
            <div class="heading_container">
                  <h2>Iniciar sesión</h2>
            </div>
            <div class="row">
                  <div class="col-md-6">
                        <div class="form_container">
                               @if (session('msg'))
                        <div class="alert alert-{{ session('msg')['ESTADO'] }}">
                              {{ session('msg')['MSG'] }}
                        </div>
                        @endif
                              <form action="/login" id="form1" name="form1" method="POST">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <div>
                                          <input type="email" id="txtCorreo" name="txtCorreo" class="form-control" placeholder="Ingresar email"  required>
                                    </div>
                                    <div>
                                          <input type="password" id="txtClave" name="txtClave" class="form-control" placeholder="Ingresar contraseña" required>
                                    </div>
                                    <div class="btn_box">
                                          <button class="btn btn-primary" type="submit">
                                                Aceptar
                                          </button>
                                    </div>
                                    <div class="text-center mt-3">
                                          <a href="/recuperar-clave">
                                                ¿Olvidaste tu contraseña?
                                          </a>
                                    </div>
                                    <div class="text-center mt-2">
                                          ¿No tenés cuenta?
                                          <a href="/registrarse">
                                                Registrate
                                          </a>
                                    </div>
                              </form>
                        </div>
                  </div>
            </div>
      </div>
</section>

@endsection