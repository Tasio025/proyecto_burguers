<?php

namespace App\Http\Controllers;
use App\Entidades\Carrito;
use App\Entidades\Producto;

class ControladorWebCarrito extends Controller{
      public function index(){
            $idcarritos = 1;
            $carritos = new Carrito();
            $aCarritos = $carritos->obtenerPorId($idcarritos);
            return view("web.carrito", compact('carritos', 'aCarritos'));   //Esto nos devolvera el carrito.blade.php(el carrito de la plantilla) pero hay que armarlo xq aparece todo roto
      }
      public function agregarProducto($idproducto){
            $titulo = "Agregar productos";
            $producto = new Producto();
            $producto->obtenerPorId($idproducto);
      }
}

?>