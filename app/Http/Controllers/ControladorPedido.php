<?php

namespace App\Http\Controllers;

use App\Entidades\Pedido;
use App\Entidades\Pedido_producto;
use App\Entidades\Sucursal;
use App\Entidades\Cliente;
use Illuminate\Http\Request;
use APP\Entidades\Sistema\Usuario;
use APP\Entidades\Sistema\Patente;
require app_path() . '/start/constants.php';

class ControladorPedido extends Controller{

      public function nuevo(){
            $titulo = "Nuevo Pedido";
            if(Usuario::autenticado() == true){
                  if(!Patente::autorizarOperacion("PEDIDOALTA")){
                        $codigo = "PEDIDOALTA";
                        $mensaje = "No tiene permisos para la operación";
                        return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            }else{
                  $pedido = new Pedido();
                  $sucursal = new Sucursal();
                  $aSucursales = $sucursal->obtenerTodos();
                  $cliente = new Cliente();
                  $aClientes = $cliente->obtenerTodos();
                  return view('sistema.pedido-nuevo', compact("titulo", "pedido", "aSucursales", "aClientes")); //Envía la variable título
            }
      }else{
            return redirect('admin/login');
      }
}
      public function index(){      //El index va a ser basicamente el listado
            $titulo = "Listado de pedidos";
            if(Usuario::autenticado() == true){
                  if(!Patente::autorizarOperacion("PEDIDOCONSULTA")){
                        $codigo = "PEDIDOCONSULTA";
                        $mensaje = "No tiene permisos para la operación";
                        return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
                  }else{
                        $pedido = new Pedido();
                        return view('sistema.pedido-listado', compact("titulo", "pedido"));
                  }
            }else{
                  return redirect('admin/login');
            }
      }
      public function guardar(Request $request){
            //dd($request->all());  Esa función me permite mostrar que datos llegan en el request
            try{
                  $titulo = "Modificar Pedido";
                  $entidad = new Pedido();
                  $entidad->cargarDesdeRequest($request);

                  //Validaciones
                  if($entidad->fecha == "" || $entidad->descripcion == "" || $entidad->total == "" || $entidad->fk_idsucursal == "" || $entidad->fk_idcliente == "" || $entidad->fk_idestado == ""){
                        $msg["ESTADO"] = MSG_ERROR;
                        $msg["MSG"] = "Complete todos los datos";
                        $pedido = new Pedido();
                        $sucursal = new Sucursal();
                        $aSucursales = $sucursal->obtenerTodos();
                        $cliente = new Cliente();
                        $aClientes = $cliente->obtenerTodos();
                        return view('sistema.pedido-nuevo', compact('titulo', 'msg', 'pedido', 'aSucursales', 'aClientes'));
                  } else {
                        if($_POST["idpedido"] > 0){   //Si viene el id y es > a 0 estoy guardando, sino estoy insertando
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
                        //$request->request->set('idpedido', $entidad->idpedido);
                        return redirect('/admin/pedidos')->with('msg', $msg);
                  }
            } catch (\Exception $e) {
                  //dd($e->getMessage()); FUNCIÓN QUE MUESTRA LOS ERRORES QUE PUEDEN SURGIR EN EL CODIGO
                  $msg["ESTADO"] = MSG_ERROR;
                  $msg["MSG"] = $e->getMessage();
                  $titulo = "Modificar Pedido";
                  $pedido = new Pedido();
                  $sucursal = new Sucursal();
                  $aSucursales = $sucursal->obtenerTodos();
                  $cliente = new Cliente();
                  $aClientes = $cliente->obtenerTodos();
                  return view('sistema.pedido-nuevo', compact('titulo', 'msg', 'pedido', 'aSucursales', 'aClientes'));
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
                  $row[] = '<a href="/admin/pedido/' . $aPedidos[$i]->idpedido . '">' . $aPedidos[$i]->fecha . '</a>';
                  $row[] = $aPedidos[$i]->descripcion;
                  $row[] = $aPedidos[$i]->total;
                  $row[] = $aPedidos[$i]->nombre_sucursal;
                  $row[] = $aPedidos[$i]->nombre_cliente;
                  $row[] = $aPedidos[$i]->nombre_estado;
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
            if(Usuario::aautenticacion()){
                  if(!Patente::autorizarOperacion("PEDIDOEDITAR")){
                        $codigo = "PEDIDOEDITAR";
                        $mensaje = "No tiene permisos para la operación";
                        return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
                  }else{
                        $pedido = new Pedido();
                        $pedido = $pedido->obtenerPorId($idpedido);
                        $sucursal = new Sucursal();
                        $aSucursales = $sucursal->obtenerTodos();
                        $cliente = new Cliente();
                        $aClientes = $cliente->obtenerTodos();
                        return view('sistema.pedido-nuevo', compact('titulo', 'pedido', 'aSucursales', 'aClientes'));
                  }
            }else{
                  return redirect('admin/login');
            }
      }
      public function eliminar(Request $request){
            if(Usuario::autenticado() == true){
                  if(!Patente::autorizarOperacion("PEDIDOELIMINAR")){
                        $resultado["err"] = EXIT_FAILURE;
                        $resultado["mensaje"] = "No tiene permisos para la operación";
                  }else{
                        $idpedido = $request->input("idpedido");
                        $pedido_producto = new pedido_producto();
                        $pedido_producto->eliminarPorPedido($idpedido); //Elimina los productos asociados al pedido
                        $pedido = new Pedido();
                        $pedido->idpedido = $idpedido;
                        $pedido->eliminar();
                        $resultado["err"] = EXIT_SUCCESS;
                        $resultado["mensaje"] = "Registro eliminado exitosamente";
                  }
            }else{
                  $resultado["err"] = EXIT_FAILURE;
                  $resultado["mensaje"] = "Usuario no está autenticado";
            }
            return json_encode($resultado);
      }
}



?>