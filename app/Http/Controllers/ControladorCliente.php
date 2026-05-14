<?php

namespace App\Http\Controllers;

use App\Entidades\Cliente;  
use App\Entidades\Pedido;
use Illuminate\Http\Request;  
require app_path() . '/start/constants.php';

class ControladorCliente extends Controller{

      public function nuevo(){
            $titulo = "Nuevo clientes";
            $cliente = new Cliente();
            return view('sistema.cliente-nuevo', compact("titulo", "cliente")); //Envía la variable título
      }
      public function index(){
            $titulo = "Listado de clientes";
            $cliente = new Cliente();
            return view('sistema.cliente-listar', compact("titulo", "cliente"));
      }
      public function guardar(Request $request){
            try{
                  $titulo = "Modificar cliente";
                  $entidad = new Cliente();
                  $entidad->cargarDesdeRequest($request);

                  //Validaciones
                  if($entidad->nombre == "" || $entidad->direccion == "" || $entidad->correo == "" || $entidad->dni == "" || $entidad->celular == "" || $entidad->clave == ""){
                        $msg["ESTADO"] = MSG_ERROR;
                        $msg["MSG"] = "Complete todos los datos";
                        $cliente = new Cliente();
                        return view('sistema.cliente-nuevo', compact('titulo', 'msg', 'cliente'));
                  } else {
                        if($_POST["idcliente"] > 0){   //Si el id es > a 0 es xq estamos editando, si no viene el id estamos insertando
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
                        $_POST["idcliente"] = $entidad->idcliente;
                        return redirect('/admin/clientes')->with('msg', $msg);
                  }
            } catch (\Exception $e) {
                  $msg["ESTADO"] = MSG_ERROR;
                  $msg["MSG"] = $e->getMessage();
                  $titulo = "Modificar cliente";
                  $cliente = new Cliente();
                  return view('sistema.cliente-nuevo', compact('titulo', 'msg', 'cliente'));
            }
      }
      public function cargarGrilla(Request $request){
            $request = $_REQUEST;
            $entidad = new Cliente();
            $aClientes = $entidad->obtenerFiltrado();  //Método creado para cargar la grilla de clientes
            $data = array();  
            $cont = 0;
            $inicio = $request['start'];
            $registros_por_pagina = $request['length'];

            for($i = $inicio; $i<count($aClientes) && $cont < $registros_por_pagina; $i++){ //Este for recorre el array de clientes y devuelve en formato Json
                  $row = array();   //Cada uno de estos campos son cada campo de la grilla
                  $row[] = '<a href="/admin/cliente/' . $aClientes[$i]->idcliente . '">' . $aClientes[$i]->nombre . '</a>'; //El href acá me servirá para editar al cliente
                  $row[] = $aClientes[$i]->direccion;
                  $row[] = $aClientes[$i]->correo;
                  $row[] = $aClientes[$i]->dni;
                  $row[] = $aClientes[$i]->celular;
                  $row[] = $aClientes[$i]->clave;
                  $cont++;
                  $data[] = $row;
            }
            $json_data = array(
                  "draw" => intval($request['draw']),
                  "recordsTotal" => count($aClientes),
                  "recordsFiltered" => count($aClientes),
                  "data" =>$data,
            );
            return json_encode($json_data);

      }
      public function editar($idcliente){
            $titulo = "Edición de cliente";
            $cliente = new Cliente();
            //$cliente->idcliente = $idcliente;
            $cliente = $cliente->obtenerPorId($idcliente);
            return view("sistema.cliente-nuevo", compact("titulo", "cliente"));     //Los que tengan desplegables, hay que enviar también los desplegables
      }
      public function eliminar(Request $request){
            $idcliente = $request->input("idcliente");
            $cliente = new Cliente();
            $pedido = new Pedido();
                    
            //Si el cliente tiene un pedido asociado no se tiene que poder eliminar
            if($pedido->existePedidoPorCliente($idcliente)){
                  $resultado["err"] = EXIT_FAILURE;
                  $resultado["mensaje"] = "No se puede eliminar el cliente porque tiene pedidos asociados";
            }else{
                  //Sino, si se puede eliminar
                  $cliente->idcliente = $request->input("idcliente");
                  $cliente->eliminar();
                  $resultado["err"] = EXIT_SUCCESS; //EXIT_SUCCESS es una constante que se encuentra en el archivo constants.php que es igual a 0, es decir, no hubo error
                  $resultado["mensaje"] = "Registro eliminado exitosamente";
            }           
            return json_encode($resultado);
      }
}

?>