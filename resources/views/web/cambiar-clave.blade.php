@extends("web.plantilla")
@section("contenido")

<section class="book_section layout_padding">
      <div class="container-fluid">
            <div class="heading_container heading_center mb-4">
                  <h2 style="font-family: 'Dancing Script', cursive;">
                        Cambiar Contraseña
                  </h2>
            </div>
            <div class="row mb-4">
                  <div class="col-md-10 mx-auto">
                        <div class="form_container">
                              @if(session('msg'))
                                    <div class="alert alert-{{ session('msg')['ESTADO'] == 'success' ? 'success' : 'danger' }}">
                                          {{ session('msg')['MSG'] }}
                                    </div>
                              @endif
                        </div>
                        <form action="/cambiar-clave" id="form1" name="form1" method="POST">
                              <input type="hidden" name="_token" value="{{ csrf_token() }}">
                              <div class="mb-4">
                                    <label for="">Contraseña actual</label>
                                    <input type="password" name="txtClaveActual" id="txtClaveActual" class="form-control" placeholder="Ingresar contraseña actual" required>
                              </div>
                              <div class="mb-4">
                                    <label for="">Nueva contraseña</label>
                                    <input type="password" name="txtClaveNueva" id="txtClaveNueva" class="form-control" placeholder="Ingresar nueva contraseña" required>
                              </div>
                              <div class="mb-5">
                                    <label for="">Confirmar nueva contraseña</label>
                                    <input type="password" name="txtClaveConfirmar" id="txtClaveConfirmar" class="form-control" placeholder="Confirmar nueva contraseña" required>
                              </div>
                              <div class="btn_box text-center">
                                    <button type="submit" class="btn btn-warning rounded-pill text-white-px5" style="background-color: #ffbe33; border: none; font-weight: bold; height: 50px;">
                                          Actualizar contraseña
                                    </button>
                              </div>
                        </form>
                        <div class="text-center mb-3">
                              <a href="/mi-cuenta" style="color: #222831; text-decoration: underline;">Volver a mi pérfil</a>
                        </div>
                  </div>
            </div>
      </div>
</section>

@endsection