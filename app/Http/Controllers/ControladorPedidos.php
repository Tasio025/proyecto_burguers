<?php

namespace App\Http\Controllers;

use App\Entidades\Pedido;
use Illuminate\Http\Request;

class ControladorPedidos extends Controller{

      public function nuevo(){
            $titulo = "Nuevo Pedido";
            return view('Sistema.pedido-nuevo', compact("titulo"));
      }
}



?>