<?php

namespace App\Http\Controllers;

use App\Entidades\Rubro;
use Illuminate\Http\Request;
require app_path() . '/start/constants.php';


class ControladorRubro extends Controller{

      public function nuevo(){
            $titulo = "Nuevo rubro";
            return view('Sistema.rubro-nuevo', compact("titulo"));
      }
      public function index(){      //El index va a ser basicamente el listado
            $titulo = "Listado de rubros";
            return view('sistema.rubro-listado', compact("titulo"));
      }
      public function guardar(Request $request){
            try{
                  $titulo = "Modificar rubro";
                  $entidad = new Rubro();
                  $entidad->cargarDesdeRequest($request);

                  //Validaciones
                  if($entidad->nombre == ""){
                        $msg["ESTADO"] = MSG_ERROR;
                        $msg["MSG"] = "Complete todos los datos";
                        $rubro = new Rubro();
                        return view('sistema.rubro-nuevo', compact('titulo', 'msg', 'rubro'));
                  } else {
                        if($_POST["id"] > 0){
                              //Es actualización
                              $entidad->guardar();
                              $msg["ESTADO"] = MSG_SUCCESS;
                              $msg["MSG"] = OKINSERT;
                        } else {
                              //Es nuevo
                              $entidad->insertar();
                              $msg["ESTADO"] = MSG_SUCCESS;
                              $msg["MSG"] = OKINSERT;
                        }
                        $_POST["id"] = $entidad->idrubro;
                        return redirect('/admin/rubros')->with('msg', $msg);
                  }
            } catch (\Exception $e) {
                  $msg["ESTADO"] = MSG_ERROR;
                  $msg["MSG"] = $e->getMessage();
                  $titulo = "Modificar rubro";
                  $rubro = new Rubro();
                  return view('sistema.rubro-nuevo', compact('titulo', 'msg', 'rubro'));
            }
      }

}


?>