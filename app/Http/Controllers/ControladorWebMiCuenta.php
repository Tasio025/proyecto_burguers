<?php

namespace App\Http\Controllers;
use App\Entidades\Cliente;
use Illuminate\Support\Facades\Redis;

class ControladorWebMiCuenta extends Controller{
      public function index(){
            $idcliente = 1;   
            $cliente = new Cliente();     
            $cliente = $cliente->obtenerPorID($idcliente);
            return view("web.mi-cuenta", compact('cliente'));
      }
      public function guardar(Request $request){      //Request para recibir los valores del formulario

      }
      
}

?>