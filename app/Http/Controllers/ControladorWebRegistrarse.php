<?php

namespace App\Http\Controllers;

class ControladorWebRegistrarse extends Controller{
      public function index(){
            return view("web.registrarse");   //Esto nos devolvera el registrarse.blade.php(el registrarse de la plantilla) pero hay que armarlo xq aparece todo roto
      }
}


?>