<?php

namespace App\Http\Controllers;

use App\Entidades\Postulacion;
use App\Entidades\Sucursal;
use Illuminate\Http\Request;

class ControladorWebNosotros extends Controller{
      public function index(){
            /*$postulacion = new Postulacion();
            $aPostulacion = $postulacion->obtenerTodos();*/

            $sucursal = new Sucursal();
            $aSucursales = $sucursal->obtenerTodos();
            return view("web.nosotros", compact("aPostulacion", "aSucursales"));
      }
      public function guardar(Request $request){
            $postulacion = new Postulacion();
            $postulacion->nombre = $request->input("txtNombre");
            $postulacion->apellido = $request->input("txtApellido");
            $postulacion->celular = $request->input("txtCelular");
            $postulacion->correo = $request->input("txtCorreo");
            $postulacion->CV = $request->input("txtCV");
            $postulacion->insertar();

            $sucursal = new Sucursal();
            $aSucursales = $sucursal->obtenerTodos();

            return view("web.nosotros", compact("aSucursales"));
      }

}


?>