<?php

namespace App\Http\Controllers;

use App\Entidades\Pedido;
use Illuminate\Http\Request;
require app_path() . '/start/constants.php';

class ControladorPedido extends Controller{

      public function nuevo(){
            $titulo = "Nuevo Pedido";
            $pedido = new Pedido();
            return view('sistema.pedido-nuevo', compact("titulo", "pedido"));
      }
      public function index(){      //El index va a ser basicamente el listado
            $titulo = "Listado de pedidos";
            $pedido = new Pedido();
            return view('sistema.pedido-listado', compact("titulo", "pedido"));
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
      public function cargarGrilla(Request $request){
            $request = $_REQUEST;
            $entidad = new Pedido();
            $aPedidos = $entidad->obtenerFiltrado();
            $data = array();
            $cont = 0;
            $inicio = $request['start'];
            $registros_por_pagina = $request['length'];

            for($i = $inicio; $i<count($aPedidos) && $cont < $registros_por_pagina; $i++){
                  $row = array();
                  $row[] = '<a href="/admin/sistema/pedido/' . $aPedidos[$i]->idpedido . '">' . $aPedidos[$i]->fecha . '</a>';
                  $row[] = $aPedidos[$i]->descripcion;
                  $row[] = $aPedidos[$i]->total;
                  $row[] = $aPedidos[$i]->fk_idsucursal;
                  $row[] = $aPedidos[$i]->fk_idcliente;
                  $row[] = $aPedidos[$i]->fk_idestado;
                  $cont++;
                  $data[] = $row;
            }
            $json_data = array(
                  "draw" => intval($request['draw']),
                  "recordsTotal" => count($aPedidos),
                  "recordsFiltered" => count($aPedidos),
                  "data" => $data,
            );
            return json_encode($json_data);
      }
      public function editar($idpedido){
            $titulo = "Edición de pedido";
            $pedido =  new Pedido();
            $pedido = $pedido->obtenerPorId($idpedido);
            return view('sistema.pedido-nuevo', compact('titulo', 'pedido'));
      }
}



?>