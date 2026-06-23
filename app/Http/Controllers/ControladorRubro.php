<?php

namespace App\Http\Controllers;

use App\Entidades\Rubro;
use Illuminate\Http\Request;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Patente;
require app_path() . '/start/constants.php';


class ControladorRubro extends Controller{

      public function nuevo(){
            $titulo = "Nuevo rubro";
            if(Usuario::autenticado() == true){
                  if(!Patente::autorizarOperacion("RUBROALTA")){
                        $codigo = "RUBROALTA";
                        $mensaje = "No tiene permisos para la operación";
                        return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
                  }else{            
                        $rubro = new Rubro();
                        return view('sistema.rubro-nuevo', compact("titulo", 'codigo', 'mensaje', "rubro"));
                  }
            }else{
                  return redirect('admin/login');
            }
      }
      public function index(){      //El index va a ser basicamente el listado
            $titulo = "Listado de rubros";
            if(Usuario::autenticado() == true){
                  if(!Patente::autorizarOperacion("RUBROCONSULTA")){
                        $codigo = "RUBROCONSULTA";
                        $mensaje = "No tiene permisos para la operación";
                        return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
                  }else{
                        
            $rubro = new Rubro();
            return view('sistema.rubro-listado', compact("titulo", 'codigo', 'mensaje', "rubro"));
                  }
            }else{
                  return redirect('admin/login');
            }
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
                        if($_POST["idrubro"] > 0){
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
                        $_POST["idrubro"] = $entidad->idrubro;
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
      public function cargarGrilla(Request $request){
            $request = $_REQUEST;
            $entidad = new Rubro();
            $aRubros = $entidad->obtenerFiltrado();  //Método creado para cargar la grilla de rubros
            $data = array();  
            $cont = 0;
            $inicio = $request['start'];
            $registros_por_pagina = $request['length'];

            for($i = $inicio; $i<count($aRubros) && $cont < $registros_por_pagina; $i++){
                  $row = array();
                  $row[] = '<a href="/admin/rubro/' . $aRubros[$i]->idrubro . '">' . $aRubros[$i]->nombre . '</a>';
                  //$row[] = $aRubros[$i]->nombre;
                  $cont++;
                  $data[] = $row;
            }
            $json_data = array(
                  "draw" => intval($request['draw']),
                  "recordsTotal" => count($aRubros),
                  "recordsFiltered" => count($aRubros),
                  "data" => $data,
            );
            return json_encode($json_data);
      }
      public function editar($idrubro){
            $titulo = "Modificar rubro";
            if(Usuario::autenticado() == true){
                  if(!Patente::autorizarOperacion("RUBROEDITAR")){
                        $codigo = "RUBROEDIAR";
                        $mensaje = "No tiene permisos para la operación";
                        return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
                  }else{      
                        $rubro = new Rubro();
                        $rubro = $rubro->obtenerPorId($idrubro);
                        return view('sistema.rubro-nuevo', compact('titulo','codigo', 'mensaje', 'rubro'));
                  }
            }else{
                  return redirect('admin/login');
            }
      }
      public function eliminar(Request $request){
            if(Usuario::autenticado() == true){
                  if(!Patente::autorizarOperacion("RUBROELIMINAR")){
                        $codigo = "RUBROELIMINAR";
                        $mensaje = "No tiene permisos para la operación";
                        return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
                  }else{            
                        $idrubro = $request->input("idrubro");
                        $rubro = new Rubro();
                        $rubro->idrubro = $request->input("idrubro");
                        $rubro->eliminar();
                        $resultado["err"] = EXIT_SUCCESS;
                        $resultado["mensaje"] = "Registro eliminado exitosamente";
                  }
            }else{
                  $resultado["err"] = EXIT_SUCCESS;
                  $resultado["mensaje"] = "Registro eliminado exitosamente";
            }
            return json_encode($resultado);
      }

}


?>