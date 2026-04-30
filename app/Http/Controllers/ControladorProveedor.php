<?php

namespace App\Http\Controllers;

use App\Entidades\Proveedor;
use Illuminate\Http\Request;
require app_path() . '/start/constants.php';

class ControladorProveedor extends Controller{
      public function nuevo(){
            $titulo = "Nuevo Proveedor";
            $proveedor = new Proveedor();
            return view('Sistema.proveedor-nuevo', compact("titulo", "proveedor"));
      }
      public function index(){      //El index va a ser basicamente el listado
            $titulo = "Listado de proveedores";
            $proveedor = new Proveedor();
            return view('sistema.proveedor-listado', compact("titulo", "proveedor"));
      }
      public function guardar(Request $request){
            try{
                  $titulo = "Modificar Proveedor";
                  $entidad = new Proveedor();
                  $entidad->cargarDesdeRequest($request);

                  //Validaciones
                  if($entidad->nombre == "" || $entidad->direccion == "" || $entidad->correo == "" || $entidad->telefono == "" || $entidad->ruc == ""){
                        $msg["ESTADO"] = MSG_ERROR;
                        $msg["MSG"] = "Complete todos los datos";
                        $proveedor = new Proveedor();
                        return view('sistema.proveedor-nuevo', compact('titulo', 'msg', 'proveedor'));
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
                        $_POST["id"] = $entidad->idproveedor;
                        return redirect('/admin/proveedores')->with('msg', $msg);
                  }
            } catch (\Exception $e) {
                  $msg["ESTADO"] = MSG_ERROR;
                  $msg["MSG"] = $e->getMessage();
                  $titulo = "Modificar Proveedor";
                  $proveedor = new Proveedor();
                  return view('sistema.proveedor-nuevo', compact('titulo', 'msg', 'proveedor'));
            }
      }
      public function cargarGrilla(Request $request){
            $request = $_REQUEST;
            $entidad = new Proveedor();
            $aProveedores = $entidad->obtenerFiltrado();  //Método creado para cargar la grilla de proveedores
            $data = array();  
            $cont = 0;
            $inicio = $request['start'];
            $registros_por_pagina = $request['length'];

            for($i = $inicio; $i < count($aProveedores) && $cont < $registros_por_pagina; $i++){
                  $row = array();
                  $row[] = '<a href="/admin/proveedores/' . $aProveedores[$i]->idproveedor . '" class="btn btn-warning btn-sm mr-2"><i class="fas fa-edit"></i></a>';
                  $row[] = $aProveedores[$i]->nombre;
                  $row[] = $aProveedores[$i]->direccion;
                  $row[] = $aProveedores[$i]->telefono;
                  $row[] = $aProveedores[$i]->correo;
                  $cont++;
                  $data[] = $row;
            }
            $json_data = array(
                  "draw" => intval($request['draw']),
                  "recordsTotal" => count($aProveedores),
                  "recordsFiltered" => count($aProveedores),
                  "data" => $data,
            );
            return json_encode($json_data);

      }
      public function edutar($idproveedor){
            $titulo = "Modificar Proveedor";
            $proveedor = new Proveedor();
            $proveedor = $proveedor->cargarDesdeBD($idproveedor);
            return view('sistema.proveedor-nuevo', compact('titulo', 'proveedor'));
      }
}

?>