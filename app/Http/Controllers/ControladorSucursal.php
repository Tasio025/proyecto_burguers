<?php

namespace App\Http\Controllers;

use App\Entidades\Sucursal;
use Illuminate\Http\Request;

      class ControladorSucursal extends Controller{
            public function nuevo(){
                  $titulo = "Nueva sucursal";
                  return view('Sistema.sucursal-nuevo', compact("titulo"));
            }
      }


?>