<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Entidades\Carrito;
use App\Entidades\Producto;
use App\Entidades\Sucursal;
use App\Entidades\Cliente;

class ControladorWebCarrito extends Controller{
      public function index(){
            $idcliente = 1; // Este debería ser el ID del cliente logueado
            $carritos = new Carrito();
            //Acá el profe llama a la función obtenerPorCliente y le pasa el idcliente, porque hay que traer los carritos del cliente logueado
            $aCarritos = $carritos->obtenerPorCliente($idcliente);
            $sucursal = new Sucursal();
            $aSucursales = $sucursal->obtenerTodos();
            return view("web.carrito", compact('carritos', 'aCarritos', 'aSucursales', 'sucursal'));   //Esto nos devolvera el carrito.blade.php(el carrito de la plantilla) pero hay que armarlo xq aparece todo roto
      }
      /*public function agregarProducto($idproducto){
            $titulo = "Agregar productos";
            $producto = new Producto();
            $producto->obtenerPorId($idproducto);
      }*/
      public function guardar(Request $request){
            $titulo = "Agregar productos";
            $producto = new Producto();
            $aProductos = $producto->obtenerTodos();
      }
}

?>