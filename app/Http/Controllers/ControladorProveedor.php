<?php

namespace App\Http\Controllers;

use App\Entidades\Proveedor;
use Illuminate\Http\Request;
require app_path() . '/start/constants.php';

class ControladorProveedor extends Controller{
      public function nuevo(){
            $titulo = "Nuevo Proveedor";
            return view('Sistema.proveedor-nuevo', compact("titulo"));
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
}

?>