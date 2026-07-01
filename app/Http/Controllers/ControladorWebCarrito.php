<?php

namespace App\Http\Controllers;

class ControladorWebCarrito extends Controller{
      public function index(){
            return view("web.carrito");   //Esto nos devolvera el carrito.blade.php(el carrito de la plantilla) pero hay que armarlo xq aparece todo roto   
      }
}

?>