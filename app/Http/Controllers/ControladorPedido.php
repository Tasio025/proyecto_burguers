<?php

namespace App\Http\Controllers;

use App\Entidades\Pedido;
use Illuminate\Http\Request;
require app_path() . '/start/constants.php';

class ControladorPedido extends Controller{

      public function nuevo(){
            $titulo = "Nuevo Pedido";
            return view('sistema.pedido-nuevo', compact("titulo"));
      }
      public function index(){      //El index va a ser basicamente el listado
            $titulo = "Listado de pedidos";
            return view('sistema.pedido-listado', compact("titulo"));
      }
      public function guardar(Request $request){
            try{
                  $titulo = "Modificar Pedido";
                  $entidad = new Pedido();
                  $entidad->cargarDesdeRequest($request);

                  //Validaciones
                  if($entidad->fecha == "" || $entidad->descripcion == "" || $entidad->total == "" || $entidad->fk_idsucursal == "" || $entidad->fk_idcliente == "" || $entidad->fk_idestado == ""){
                        $msg["ESTADO"] = MSG_ERROR;
                        $msg["MSG"] = "Complete todos los datos";
                        $pedido = new Pedido();
                        return view('sistema.pedido-nuevo', compact('titulo', 'msg', 'pedido'));
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
                        $_POST["id"] = $entidad->idpedido;
                        return redirect('/admin/pedidos')->with('msg', $msg);
                  }
            } catch (\Exception $e) {
                  $msg["ESTADO"] = MSG_ERROR;
                  $msg["MSG"] = $e->getMessage();
                  $titulo = "Modificar Pedido";
                  $pedido = new Pedido();
                  return view('sistema.pedido-nuevo', compact('titulo', 'msg', 'pedido'));
            }
      }
}



?>