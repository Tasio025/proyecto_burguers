<?php

namespace App\Http\Controllers;

use App\Entidades\Postulacion;
use Illuminate\Http\Request;
require app_path() . '/start/constants.php';

class ControladorPostulacion extends Controller{

      public function nuevo(){
            $titulo = "Nueva Postulación";
            return view('Sistema.postulacion-nuevo', compact("titulo")); //Envía la variable título   
      }
      public function guardar(Request $request){
            try{
                  $titulo = "Modificar Postulación";
                  $entidad = new Postulacion();
                  $entidad->cargarDesdeRequest($request);

                  //Validaciones
                  if($entidad->nombre == "" || $entidad->apellido == "" || $entidad->celular == "" || $entidad->dni == "" || $entidad->correo == "" || $entidad->clave == ""){
                        $msg["ESTADO"] = MSG_ERROR;
                        $msg["MSG"] = "Complete todos los datos";
                        $postulacion = new Postulacion();
                        return view('sistema.postulacion-nuevo', compact('titulo', 'msg', 'postulacion'));
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
                        $_POST["id"] = $entidad->idpostulacion;
                        return redirect('/admin/postulaciones')->with('msg', $msg);
                  }
            } catch (\Exception $e) {
                  $msg["ESTADO"] = MSG_ERROR;
                  $msg["MSG"] = $e->getMessage();
                  $titulo = "Modificar Postulación";
                  $postulacion = new Postulacion();
                  return view('sistema.postulacion-nuevo', compact('titulo', 'msg', 'postulacion'));
            }
      }



}



?>