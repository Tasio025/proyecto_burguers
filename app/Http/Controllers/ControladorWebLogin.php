<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Entidades\Cliente;
use App\Entidades\Sucursal;
use Session;
class ControladorWebLogin extends Controller{
      public function index(){

            $sucursal = new Sucursal();
            $aSucursales = $sucursal->obtenerTodos();
            return view("web.login", compact('aSucursales')); 
      }
      public function loguearse(Request $request){
            $titulo = "Iniciar sesión";
            $sucursal = new Sucursal();
            $aSucursales = $sucursal->obtenerTodos();
            $correo = $request->input('txtCorreo');
            $clave =  $request->input('txtClave');
            $cliente = new Cliente();
            $cliente->obtenerPorCorreo($correo);
            if($cliente->correo != null){
                  if(password_verify($clave, $cliente->clave)){
                        //Usamos variables de sesión en este caso para almacenar el id del cliente, en este caso, el idcliente que está
                        //Entre comillas es un nombre que inventamos para este caso en este momento, el que esta en $cliente->idcliente
                        //Es el que viene desde la base de datos
                        Session::put("idcliente", $cliente->idcliente); //Así definimos la variable de sesión
                        return redirect('/'); //Redireccionamos a la página principal
                  }else{
                        $mensaje = "Credenciales incorrectas. ";
                        return view("web.login", compact('aSucursales', 'mensaje'));
                  }
            }else{
                  $mensaje = "Credenciales incorrectas.";
                  return view("web.login", compact('aSucursales', 'mensaje'));
            }
      }
      public function logout(){
            Session::put("idcliente", ""); //Le envía comillas vacías así elimina el numero
            return redirect('/');
      }
}

?>