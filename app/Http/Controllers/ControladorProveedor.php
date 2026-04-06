<?php

namespace App\Http\Controllers;

use App\Entidades\Proveedor;
use Illuminate\Http\Request;

class ControladorProveedor extends Controller{
      public function nuevo(){
            $titulo = "Nuevo Proveedor";
            return view('Sistema.proveedor-nuevo', compact("titulo"));
      }
}

?>