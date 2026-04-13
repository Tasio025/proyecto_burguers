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
      public function cargarGrilla(Request $request){
            $request = $_REQUEST;
            $entidad = new Producto();
            $aProductos = $entidad->obtenerFiltrado();
            $data = array();
            $cont = 0;
            $inicio = $request['start'];
            $registros_por_pagina = $request['length'];

            for($i = $inicio; $i<count($aProductos) && $cont < $registros_por_pagina; $i++){
                  $row = array();
                  $row[] = '<a href="/admin/sistema/producto/' . $aProductos[$i]->idproducto . '">' . $aProductos[$i]->nombre . '</a>';
                  $row[] = $aProductos[$i]->cantidad;
                  $row[] = $aProductos[$i]->precio;
                  $row[] = '<img src="/files/productos/' . $aProductos[$i]->imagen . '" class="img-thumbnail" width="100px">';
                  $row[] = $aProductos[$i]->fk_idcategoria;
                  $cont++;
                  $data[] = $row;
            }
            $json_data = array(
                  "draw" => intval($request['draw']),
                  "recordsTotal" => count($aProductos),
                  "recordsFiltered" => count($aProductos),
                  "data" => $data,
            );
            return json_encode($json_data);
      }
}
?>