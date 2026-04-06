<?php

namespace App\Http\Controllers;

use App\Entidades\Cliente;  //AGREGADO X COP
use Illuminate\Http\Request;  //AGREGADO X COP
require app_path() . '/start/constants.php';

class ControladorCliente extends Controller{

      public function nuevo(){
            $titulo = "Nuevo clientes";
            return view('Sistema.cliente-nuevo', compact("titulo")); //Envía la variable título
      }
      public function guardar(Request $request){
            try{
                  $titulo = "Modificar cliente";
                  $entidad = new Cliente();
                  $entidad->cargarDesdeRequest($request);

                  //Validaciones
                  if($entidad->nombre == "" || $entidad->direccion == "" || $entidad->correo == "" || $entidad->dni == "" || $entidad->celular == ""){
                        $msg["ESTADO"] = MSG_ERROR;
                        $msg["MSG"] = "Complete todos los datos";
                        $cliente = new Cliente();
                        return view('Sistema.cliente-nuevo', compact('titulo', 'msg', 'cliente'));
                  } else {
                        if($_POST["id"] > 0){
                              //Es actualización
                              $entidad->guardar();
                              $msg["ESTADO"] = MSG_SUCCESS;
                              $msg["MSG"] = OKINSERT;
                        } else {
                              //Es nuevo
                              $entidad->insertar();
                              $msg["ESTADO"] = MSG_SUCCESS;
                              $msg["MSG"] = OKINSERT;
                        }
                        $_POST["id"] = $entidad->idcliente;
                        return redirect('/admin/clientes')->with('msg', $msg);
                  }
            } catch (\Exception $e) {
                  $msg["ESTADO"] = MSG_ERROR;
                  $msg["MSG"] = $e->getMessage();
                  $titulo = "Modificar cliente";
                  $cliente = new Cliente();
                  return view('Sistema.cliente-nuevo', compact('titulo', 'msg', 'cliente'));
            }
      }
}

?>