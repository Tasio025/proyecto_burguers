<?php

namespace App\Http\Controllers;

use App\Entidades\Producto;
use App\Entidades\Tipoproducto;
use Illuminate\Http\Request;
require app_path() . '/start/constants.php';   

class ControladorProducto extends Controller{
 
      public function nuevo(){
            $titulo = 'Nuevo Producto';   
            $categoria = new Tipoproducto(); //->(entidad categoria) Esto se hace para todas las clases que tengan un desplegable, ya que es necesario traer todos
            $aCategorias = $categoria->obtenerTodos();
            return view('sistema.producto-nuevo', compact("titulo", "aCategorias"));      //Esto lo pasa al blade via compact
      }
      public function index(){      //El index va a ser basicamente el listado
            $titulo = "Listado de productos";
            return view('sistema.producto-listado', compact("titulo"));
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
                        $categoria = new Tipoproducto(); 
            $aCategorias = $categoria->obtenerTodos();
                        return view('sistema.producto-nuevo', compact('titulo', 'msg', 'producto', 'aCategorias'));
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
                  $categoria = new Tipoproducto(); 
                  $aCategorias = $categoria->obtenerTodos();
                  return view('sistema.producto-nuevo', compact('titulo', 'msg', 'producto', 'aCategorias'));
            }
      }
}
?>