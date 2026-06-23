<?php

namespace App\Http\Controllers;

use App\Entidades\Postulacion;
use Illuminate\Http\Request;
use APP\Entidades\Sistema\Usuario;
use APP\Entidades\Sistema\Patente;
require app_path() . '/start/constants.php';

class ControladorPostulacion extends Controller{

      public function nuevo(){
            $titulo = "Nueva Postulación";
            if(Usuario::autenticado() == true){
                  if(!Patente::autorizarOperacion("POSTULACIONALTA")){
                        $codigo = "POSTULACIONALTA";
                        $mensaje = "No tiene permisos para la operación";
                        return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
                  }else{
                        $postulacion = new Postulacion();
                        return view('sistema.postulacion-nuevo', compact("titulo", "postulacion")); //Envía la variable título
                  }
            }else{
                  return redirect('admin/login');
            }
      }
      public function index(){      //El index va a ser basicamente el listado
            $titulo = "Listado de postulaciones";
            if(Usuario::autenticado() == true){
                  if(!Patente::autorizarOperacion("POSTULACIONCONSULTA")){
                        $codigo = "POSTTULACIONCONSULTA";
                        $mensaje = "No tiene permisos para la operación";
                        return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
                  }else{
                        return view('sistema.postulacion-listado', compact("titulo", "postulacion"));
                  }
            }else{
                  return redirect('admin/login');
            }
      }
      public function guardar(Request $request){
            try{
                  $titulo = "Modificar Postulación";
                  $entidad = new Postulacion();
                  $entidad->cargarDesdeRequest($request);

                  //Validaciones
                  if($entidad->nombre == "" || $entidad->apellido == "" || $entidad->celular == "" || $entidad->correo == "" || $entidad->CV == ""){
                        $msg["ESTADO"] = MSG_ERROR;
                        $msg["MSG"] = "Complete todos los datos";
                        $postulacion = new Postulacion();
                        return view('sistema.postulacion-nuevo', compact('titulo', 'msg', 'postulacion'));
                  } else {
                        if($_POST["idpostulacion"] > 0){
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
                        $_POST["idpostulacion"] = $entidad->idpostulacion;
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
                  $row[] = '<a href="/admin/postulacion/' . $aPostulaciones[$i]->idpostulacion . '">' . $aPostulaciones[$i]->nombre . '</a>';
                  $row[] = $aPostulaciones[$i]->apellido;
                  $row[] = $aPostulaciones[$i]->celular;
                  $row[] = $aPostulaciones[$i]->correo;
                  $row[] = $aPostulaciones[$i]->CV;
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
      public function editar($idpostulacion){
            $titulo = "Editar postulación";
            if(Usuario::autenticado() == true){
                  if(!Patente::autorizarOperacion("POSTULACIONEDITAR")){
                        $codigo = "POSTULACIONEDITAR";
                        $mensaje = "No tiene permisos para la operación";
                        return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
                  }else{
                        return view('sistema.postulacion-nuevo', compact('titulo', 'postulacion'));
                  }
            }else{
                  return redirect('admin/login');
            }
      }
      public function eliminar(Request $request){
            if(Usuario::autenticado() == true){
                  if(!Patente::autorizarOperacion("POSTTULACIONBAJA")){
                        $resultado["err"] = EXIT_FAILURE;
                        $resultado["mensaje"] = "No tiene permisos para la operación";
                  }else{
                        $idpostulacion = $request->input("idpostulacion");
                        $postulacion = new Postulacion();
                        $postulacion->idpostulacion = $request->input("idpostulacion");
                        $postulacion->eliminar();
                        $resultado["err"] = EXIT_SUCCESS;
                        $resultado["mensaje"] = "Registro eliminado exitosamente";
                        return json_encode($resultado);
                  }
            }else{
                  $resultado["err"] = EXIT_FAILURE;
                  $resultado["mensaje"] = "No tiene permisos para la operación";
                  
            }
            return json_encode($resultado);
      }
}



?>