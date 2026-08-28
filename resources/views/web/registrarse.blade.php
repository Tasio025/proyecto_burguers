@extends("web.plantilla")
@section("contenido")
<!--Book section (o bueno es basicamente la seccion para registrarse)-->
<section class="book_section layout_padding">
      <div class="container">
            <div class="heading_container">
                  <h2>Registrarse</h2>
            </div>
            @if(isset($msg))
            <div class="alert alert-{{ $msg['ESTADO'] }}">
                  {{ $msg['MSG'] }}
            </div>
            @endif
            <div class="row">
                  <div class="col-md-6">
                        <div class="form_container">
                              <form id="form1" action="/registrarse" method="POST">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <div>
                                          <input type="text" id="txtNombre" name="txtNombre" class="form-control" placeholder="Nombre" required> 
                                    </div>
                                    <div>
                                          <input type="text" id="txtApellido" name="txtApellido" class="form-control" placeholder="Apellido" required> 
                                    </div>
                                    <div>
                                          <input type="number" id="txtTelefono" name="txtTelefono" class="form-control" placeholder="Número de telefono" required>   
                                    </div>
                                    <div>
                                          <input type="number" id="txtWhatsapp" name="txtWhatsapp" class="form-control" placeholder="Número de Whatsapp" required>   
                                    </div>
                                    <div>
                                          <input type="text" id="txtCorreo" name="txtCorreo" class="form-control" placeholder="Email" required>
                                    </div>
                                    <div>
                                          <input type="text" id="txtDni" name="txtDni" class="form-control" placeholder="DNI" required>
                                    </div>
                                    <div>
                                          <input type="text" id="txtDireccion" name="txtDireccion" class="form-control" placeholder="Dirección" required>
                                    </div>
                                    <div>
                                          <input type="password" id="txtClave" name="txtClave" class="form-control" placeholder="Clave" required>
                                    </div>
                                    <div class="btn_box">
                                          <button type="submit" class="btn btn-primary">
                                                Registrarse
                                          </button>
                                    </div>
                              </form>
                        </div>
                  </div>
            </div>
      </div>
</section>
<!--Faltaría revisar si los datos se envían bien. También tengo que hacer que se linkee con el botón de la personita que está
al lado del carrito-->
@endsection