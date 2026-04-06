<?php

namespace App\Http\Controllers;

use App\Entidades\Postulacion;
use Illuminate\Http\Request;

class ControladorPostulaciones extends Controller{

      public function nuevo(){
            $titulo = "Nueva Postulación";
            return view('Sistema.postulacion-nuevo', compact("titulo")); //Envía la variable título   
      }



}



?>