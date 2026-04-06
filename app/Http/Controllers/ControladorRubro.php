<?php

namespace App\Http\Controllers;

use App\Entidades\Rubro;
use Illuminate\Http\Request;


class ControladorRubro extends Controller{

      public function nuevo(){
            $titulo = "Nuevo rubro";
            return view('Sistema.rubro-nuevo', compact("titulo"));
      }

}


?>