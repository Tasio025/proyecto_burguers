<?php

namespace App\Http\Controllers;

class ControladorWebPostulacionGracias extends Controller{
      public function index(){
            return view("web.postulaciongracias");   //Esto nos devolvera el postulaciongracias.blade.php(el postulaciongracias de la plantilla) pero hay que armarlo xq aparece todo roto
      }
}

?>