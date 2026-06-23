<?php

namespace App\Http\Controllers;

use App\Entidades\Proveedor;
use Illuminate\Http\Request;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Patente;
require app_path() . '/start/constants.php';

class ControladorProveedor extends Controller{
      public function nuevo(){
            $titulo = "Nuevo Proveedor";
            if(Usuario::autenticado() == true){
                  if(!Patente::autorizarOperacion("PROVEEDORESALTA")) {
                        $codigo = "PROVEEDORESALTA";
                        $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                        return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
                  }else{
                        $proveedor = new Proveedor();
                        return view('sistema.proveedor-nuevo', compact("titulo", "proveedor"));
                  }
            }else{
                  return redirect('admin/login');
            }
      }
      public function index(){      //El index va a ser basicamente el listado
            $titulo = "Listado de proveedores";
            if(Usuario::autenticado() == true){
                  if(!Patente::autorizarOperacion("PROVEEDORCONSULTA")){
                        $codigo = "PROVEEDORCONSULTA";
                        $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                        return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
                  }else{
                        $proveedor = new Proveedor();
                        return view('sistema.proveedor-listado', compact("titulo", "proveedor"));
                  }
            }else{
                  return redirect('admin/login');
            }
      }
      public function guardar(Request $request){
            try{
                  $titulo = "Modificar Proveedor";
                  $entidad = new Proveedor();
                  $entidad->cargarDesdeRequest($request);

                  //Validaciones
                  if($entidad->nombre == "" || $entidad->direccion == "" || $entidad->correo == "" || $entidad->telefono == ""){
                        $msg["ESTADO"] = MSG_ERROR;
                        $msg["MSG"] = "Complete todos los datos";
                        $proveedor = new Proveedor();
                        return view('sistema.proveedor-nuevo', compact('titulo', 'msg', 'proveedor'));
                  } else {
                        if($_POST["idproveedor"] > 0){
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
                        $_POST["idproveedor"] = $entidad->idproveedor;
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
                  $row[] = '<a href="/admin/proveedor/' . $aProveedores[$i]->idproveedor . '">' . $aProveedores[$i]->nombre . '</a>';
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
      public function editar($idproveedor){
            $titulo = "Modificar Proveedor";
            if(Usuario::autenticado() == true){
                  if(!Patente::autorizarOperacion("PROVEEDORMODIFICACION")){
                        $codigo = "PROVEEDORMODIFICACION";
                        $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                        return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
                  }else{
                        $proveedor = new Proveedor();
                        $proveedor = $proveedor->cargarDesdeBD($idproveedor); //cargarDesdeBD es un método creado para cargar los datos del proveedor a modificar
                        return view('sistema.proveedor-nuevo', compact('titulo', 'proveedor'));
                  }
            }else{
                  return redirect('admin/login');
            }
      }
      public function eliminar(Request $request){
            if(Usuario::autenticado() == true){
                  if(!Patente::autorizarOperacion("PROVEEDORELIMINAR")){
                        $resultado["err"] = EXIT_FAILURE;
                        $resultado["mensaje"] = "No tiene pemisos para la operaci&oacute;n.";
                  }else{
                        $idproveedor = $request->input("idproveedor");
                        $proveedor = new Proveedor();
                        $proveedor->idproveedor = $request->input("idproveedor");
                        $proveedor->eliminar();
                        $resultado["err"] = EXIT_SUCCESS;
                        $resultado["mensaje"] = "Registro eliminado exitosamente";
                  }
            }else{
                  $resultado["err"] = EXIT_FAILURE;
                  $resultado["mensaje"] = "No tiene pemisos para la operaci&oacute;n.";   
            }
            return json_encode($resultado);
      }
}

?>