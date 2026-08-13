<?php

namespace App\Http\Controllers;
use App\Entidades\Producto;
use App\Entidades\Categoria;
use Session;
class ControladorWebTakeaway extends Controller{
      public function index(){
            $producto = new Producto();
            $aProductos = $producto->obtenerTodos(); //Esto me va a traer todos los productos de la base de datos

            $categoria = new Categoria();
            $aCategorias = $categoria->obtenerTodos(); //Esto me va a traer todas las categorias de la base de datos
            return view("web.takeaway", compact("aProductos", "aCategorias"));
      }
      public function insertar(Request $request){
            $icliente = Session::get('idcliente');
            $idproducto = $request->input("idproducto");
            $cantidad = $request->input("txtCantidad");
      }

}


?>