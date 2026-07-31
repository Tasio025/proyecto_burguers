<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class ControladorWebRecuperarClave extends Controller{
      public function index(Request $request){
            $titulo = "Recuperar clave";
            return view("web.recuperar-clave", compact("titulo"));
      }
}

?>