<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Entidades\Cliente;
class ControladorWebLogin extends Controller{
      public function index(){
            return view("web.login"); 
      }
      public function loguearse(Request $request){
            $titulo = "Iniciar sesión";
            $correo = $request->input('txtCorreo');
            $clave = $request->input('txtClave');
            $cliente = new Cliente();
            $cliente = $cliente->obtenerPorCorreo($correo);
            if($cliente != null){
                  dd([
                        'clave_ingresada' => $clave,
                        'clave_bd' => $cliente->clave,
                        'verifica' => password_verify($clave, $cliente->clave)
                        ]);
                  if(password_verify($clave, $cliente->clave)){
                  //login correcto
                  session(['usuario_id' => $cliente->idcliente]);
                  session(['usuario_nombre' => $cliente->nombre]);
                  return redirect("/takeaway");
                  }else{
                  //Contraseña incorrecta
                  return redirect('/login')->with('msg', [
                        'ESTADO' => 'danger',
                        'MSG' => 'La contraseña ingresada es incorrecta!'
                  ]);
                  }
            }else{
                  //usuario no existe
                  return redirect('/login')->with('msg',[
                        'ESTADO' => 'danger',
                        'MSG' => 'El correco electrónico no se encuentra!'
                  ]);
            }
      }
}

?>