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
            $cliente = new Cliente();
            $cliente = $request->input('txtCorreo');
            $cliente = $request->input('txtClave');
            $cliente = $cliente->obtenerPorCorreo($request->input('txtCorreo'));
            if($cliente != null){
                  if(password_verify($request->input('txtClave'), $cliente->clave)){
                  //login correcto
                  session(['usuario_id' => $cliente->idcliente]);
                  session(['usuario_nombre' => $cliente->nombre]);
                  return redirect("web.takeaway");
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