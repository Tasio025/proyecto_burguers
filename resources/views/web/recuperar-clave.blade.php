@extends('web.plantilla')
@section("contenido")

<section class="book_section layout_padding">
      <div class="container-fluid">
            <div class="heading_container heading_center mb-4">
                  <h2>¿Olvidaste tu clave?</h2>
            </div>
            <div class="row">
                  <div class="col-md-6 mx-auto">
                        <div class="form-container">
                              <p class="text-center mb-4">Ingresá tu correo con el que te hayas registrado y te enviaremos las indicaciones para cambiar tu clvae</p>
                        @if(isset($msg))
                        <div class="alert alert-{{ $msg['ESTADO'] }} text-center">
                        {{ $msg['MSG'] }}      
                        </div>
                        @endif
                        <form action="/recuperar-clave" method="POST">
                              @csrf
                              <div class="mb-4">
                                    <label for="txtCorreo">Correo electrónico</label>
                                    <input type="email" class="form-control" name="txtCorreo" id="txtCorreo" placeholder="Ingresar correo" required>
                              </div>
                              <div class="btn_box text-center">
                                    <button type="submit" class="btn btn-warning rounded-pill px5 text-white" style="background-color: #ffbe33; border: none; font-weight: bold; height: 50px;">RECUPERAR</button>
                              </div>
                        </form>
                        <div class="text-center mt-4">
                              <a href="/login">Volver a iniciar sesión</a>
                        </div>
                  </div>
            </div>
      </div>
</section>

@endsection