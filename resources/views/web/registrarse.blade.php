@extends("web.plantilla")
@section("contenido")
<!--Book section (o bueno es basicamente la seccion para registrarse)-->
<section class="book_section layout_padding">
      <div class="container">
            <div class="heading_container">
                  <h2>Registrarse</h2>
            </div>
            <div class="row">
                  <div class="col-md-6">
                        <div class="form_container">
                              <form action="" method="POST">
                                    <div>
                                          <input type="text" id="txtNombre" name="txtNombre" class="form-control" placeholder=""  > 
                                    </div>
                                    <div>
                                          <input type="text" id="txtTelefono" name="txtTelefono" class="form-control" placeholder=""  >   
                                    </div>
                                    <div>
                                          <input type="text" id="txtCorreo" name="txtCorreo" class="form-control" placeholder=""  >
                                    </div>
                                    <div>
                                          <input type="text" id="txtDni" name="txtDni" class="form-control" placeholder=""  >
                                    </div>
                                    <div>
                                          <input type="text" id="txtDireccion" name="txtDireccion" class="form-control" placeholder=""  >
                                    </div>
                                    <div>
                                          <input type="text" id="txtClave" name="txtClave" class="form-control" placeholder=""  >
                                    </div>
                                    <div class="btn_box">
                                          <button>
                                                Registrarse
                                          </button>
                                    </div>
                              </form>
@endsection