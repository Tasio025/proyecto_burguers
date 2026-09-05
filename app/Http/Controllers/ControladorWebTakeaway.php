<?php

namespace App\Http\Controllers;
use App\Entidades\Producto;
use App\Entidades\Categoria;
use App\Entidades\Carrito;
use App\Entidades\Sucursal;
use Illuminate\Http\Request;
use Session;
require app_path() . '/start/constants.php';//Revisar esto
class ControladorWebTakeaway extends Controller{
      public function index(){
            $msg = null;
            $producto = new Producto();
            $aProductos = $producto->obtenerTodos(); //Esto me va a traer todos los productos de la base de datos

            $categoria = new Categoria(); 
            $aCategorias = $categoria->obtenerTodos(); //Esto me va a traer todas las categorias de la base de datos
            
            $sucursal = new SUcursal();
            $aSucursales = $sucursal->obtenerTodos();


            return view("web.takeaway", compact("msg", "aProductos", "aCategorias", "aSucursales"));
      }
      public function insertar(Request $request ){
            $idcliente = Session::get('idcliente');
            $idproducto = $request->input("idproducto");
            $cantidad = $request->input("txtCantidad");

            $producto = new Producto();
            $aProductos = $producto->obtenerTodos();

            $categoria = new Categoria();
            $aCategorias = $categoria->obtenerTodos();

            $sucursal = new Sucursal();
            $aSucursales = $sucursal->obtenerTodos();

            if(isset($idcliente) && $idcliente>0){
                  if(isset($cantidad) && $cantidad>0){
                        $carrito = new Carrito();
                        $carrito->fk_idcliente = $idcliente;
                        $carrito->fk_idproductos = $idproducto;
                        $carrito->cantidad = $cantidad;
                        $carrito->insertar();


                        $msg["ESTADO"] = MSG_SUCCESS;
                        $msg["MSG"] = "El producto se agregó correctamente";
                        return view('web.takeaway', compact('msg', 'aCategorias', 'aSucursales', 'aProductos'));
                  }else{
                        $msg["ESTADO"] = MSG_ERROR;
                        $msg["MSG"] = "No se agregó ningún producto al carrito";
                        return view('web.takeaway', compact('msg', 'aCategorias', 'aSucursales', 'aProductos'));
                  }
            }else{
                  $msg["ESTADO"] = MSG_ERROR;
                  $msg["MSG"] = "Debe iniciar sesión para realizar un pedido";
                  return view('web.takeaway', compact('msg', 'aCategorias', 'aSucursales', 'aProductos'));
            }
      }

}


?>