<?php

namespace App\Http\Controllers;

use App\Entidades\Producto;
use Illuminate\Http\Request;
require app_path() . '/start/constants.php';   

class ControladorProducto extends Controller{

      public function nuevo(){
            $titulo = 'Nuevo Producto';
            return view('sistema.producto-nuevo', compact("titulo"));
      }
      public function guardar(Request $request){
            try{
                  $titulo = "Modificar producto";
                  $entidad = new Producto();
                  $entidad->cargarDesdeRequest($request);

                  //Validaciones
                  if($entidad->nombre == "" || $entidad->cantidad == "" || $entidad->precio == "" || $entidad->fk_idcategoria == ""){
                        $msg["ESTADO"] = MSG_ERROR;
                        $msg["MSG"] = "Complete todos los datos";
                        $producto = new Producto();
                        return view('sistema.producto-nuevo', compact('titulo', 'msg', 'producto'));
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
                        $_POST["id"] = $entidad->idproducto;
                        return redirect('/admin/productos')->with('msg', $msg);
                  }
            } catch (\Exception $e) {
                  $msg["ESTADO"] = MSG_ERROR;
                  $msg["MSG"] = $e->getMessage();
                  $titulo = "Modificar producto";
                  $producto = new Producto();
                  return view('sistema.producto-nuevo', compact('titulo', 'msg', 'producto'));
            }
      }
}
?>