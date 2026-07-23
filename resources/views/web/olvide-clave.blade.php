@extends("web.plantilla")
@section("contenido")

<section>
      <div class="container">
            <div class="card card-login mx-auto mt-5">
                  <div class="card-header">Recuperar clave</div>
                  <div class="card-body">
                        <form name="fr" class="form-signin" method="POST" action="{{ route('olvide-clave') }}">
                              <div class="form-group">
                                    <div class="form-label-group">
                                          <input type="text" id="txtCorreo" name="txtCorreo" class="form-control" placeholder="Correo electrónico" required="required" autofocus="autofocus">
                                          <label for="txtCorreo">Correo electrónico</label>
                                    </div>
                              </div>
                              <button type="submit" class="btn btn-primary btn-block">Recuperar clave</button>
                        </form>
                  </div>
            </div>
      </div>
</section>
<!--Bueno creo que ahí puede llegar a estar bien-->
@endsection 