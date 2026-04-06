<?php

namespace App\Http\Controllers;

use App\Entidades\Categoria;
use Illuminate\Http\Request;

      class ControladorCategoria extends Controller{
            public function nuevo(){
                  $titulo = "Nueva categoria";
                  return view('Sistema.categoria-nuevo', compact("titulo"));
            }
      }

?>