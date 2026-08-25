<?php

namespace App\Http\Controllers;

use App\Entidades\Postulacion;
use App\Entidades\Sucursal;
use Illuminate\Http\Request;

class ControladorWebNosotros extends Controller{
      public function index(){
            $postulacion = new Postulacion();
            $aPostulacion = $postulacion->obtenerTodos();

            $msg = null;
            $sucursal = new Sucursal();
            $aSucursales = $sucursal->obtenerTodos();
            return view("web.nosotros", compact("aPostulacion", "aSucursales"));
      }
      public function insertarPostulacion(Request $request){
            $postulacion = new Postulacion();
            $postulacion->nombre = $request->input("txtNombre");
            $postulacion->apellido = $request->input("txtApellido");
            $postulacion->celular = $request->input("txtCelular");
            $postulacion->correo = $request->input("txtCorreo");
            if($request->hasFile('txtCV')){
                  $archivo = $request->file('txtCV');
                  $nombre = time() . '_' . $archivo->getClientOriginalName();
                  $archivo->move(public_path('files/postulaciones'), $nombre);
                  $postulacion->CV = $nombre;
            }
            $postulacion->insertar();

            $sucursal = new Sucursal();
            $aSucursales = $sucursal->obtenerTodos();

            return view("web.postulacion-gracias", compact("aSucursales"));
      }

}


?>