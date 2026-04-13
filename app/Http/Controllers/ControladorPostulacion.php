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
      public function index(){      //El index va a ser basicamente el listado
            $titulo = "Listado de postulaciones";
            return view('sistema.postulacion-listado', compact("titulo"));
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
      public function cargarGrilla(Request $request){
            $request = $_REQUEST;
            $entidad = new Postulacion();
            $aPostulaciones = $entidad->obtenerFiltrado();
            $data = array();
            $cont = 0;
            $inicio = $request['start'];
            $registros_por_pagina = $request['length'];
            for($i = $inicio; $i < count($aPostulaciones) && $cont < $registros_por_pagina; $i++){
                  $row = array();
                  $row[] = '<a href="/admin/sistema/postulacion/' . $aPostulaciones[$i]->idpostulacion . '">' . $aPostulaciones[$i]->nombre . '</a>';
                  $row[] = $aPostulaciones[$i]->apellido;
                  $row[] = $aPostulaciones[$i]->celular;
                  $row[] = $aPostulaciones[$i]->correo;
                  $row[] = "<a href=''> . Descargar </a>" ;
                  $cont++;
                  $data[] = $row;
            }
            $json_data = array(
                  "draw" => intval($request['draw']),
                  "recordsTotal" => count($aPostulaciones),
                  "recordsFiltered" => count($aPostulaciones),
                  "data" => $data,
            );
            return json_encode($json_data);
      }
}



?>