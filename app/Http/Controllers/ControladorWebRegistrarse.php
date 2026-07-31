<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Entidades\Cliente;

class ControladorWebRegistrarse extends Controller{
      public function index(){
            return view("web.registrarse");   //Esto nos devolvera el registrarse.blade.php(el registrarse de la plantilla) pero hay que armarlo xq aparece todo roto
      }
      public function registrarse(Request $request){
            $titulo = "Nuevo registro";
            $cliente = New Cliente();
//O podría llamar al método "cargarDesdeRequest()" que settea todo de golpe para que no quede un codigo más largo
            $cliente->nombre = $request->input("txtNombre");//Setteamos el cliente, lo traemos del request
            $cliente->apellido = $request->input("txtApellido");
            $cliente->direccion = $request->input("txtDireccion");
            $cliente->correo = $request->input("txtCorreo");
            $cliente->dni = $request->input("txtDni");
            $cliente->celular = $request->input("txtTelefono");
            $cliente->whatsapp = $request->input("txtWhatsapp");
            //La contraseña se settea así para encriptarla
            $cliente->clave = password_hash($request->input("txtClave"), PASSWORD_DEFAULT);

            if($cliente->nombre == "" || $cliente->apellido == "" || $cliente->direccion == "" || $cliente->correo == "" || $cliente->dni == "" || $cliente->celular == "" || $cliente->whatsapp == "" || $cliente->clave == ""){
               $msg["ESTADO"] = MSG_ERROR;
               $msg["MSG"] = "Complete todos los campos";   
            }else{
                  //Ahora que termino de settear todo llamo al método insertar
                  $cliente->insertar();
                  return redirect('/login');
            }
      }
}


?>