<?php

namespace App\Http\Controllers;

class ControladorWebContactoGracias extends Controller{
      public function index(){
            return view("web.contactogracias");   //Esto nos devolvera el contactogracias.blade.php(el contactogracias de la plantilla) pero hay que armarlo xq aparece todo roto   
      }
}

?>