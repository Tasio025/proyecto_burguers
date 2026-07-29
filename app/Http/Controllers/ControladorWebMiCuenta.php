<?php

namespace App\Http\Controllers;
use App\Entidades\Cliente;

class ControladorWebMiCuenta extends Controller{
      public function index(){
            $idcliente = 3;
            $cliente = new Cliente();
            $cliente = $cliente->obtenerPorID($idcliente);
            return view("web.mi-cuenta", compact('cliente'));
      }
}

?>