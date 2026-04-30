<?php

namespace App\Http\Controllers;

use App\Entidades\Categoria;
use Illuminate\Http\Request;
require app_path() . '/start/constants.php';


      class ControladorCategoria extends Controller{
            public function nuevo(){
                  $titulo = "Nueva categoria";
                  $categoria = new Categoria();
                  return view('Sistema.categoria-nuevo', compact("titulo", "categoria")); //Envía la variable título
            }
             public function index(){      //El index va a ser basicamente el listado
            $titulo = "Listado de categorias";
            $categoria = new Categoria();
            return view('sistema.categoria-listado', compact("titulo", "categoria"));
      }
            public function guardar(Request $request){
                  try{
                        $titulo = "Modificar categoria";
                        $entidad = new Categoria();
                        $entidad->cargarDesdeRequest($request);

                        //Validaciones
                        if($entidad->nombre == ""){
                              $msg["ESTADO"] = MSG_ERROR;
                              $msg["MSG"] = "Complete todos los datos";
                              $categoria = new Categoria();
                              return view('sistema.categoria-nuevo', compact('titulo', 'msg', 'categoria'));
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
                              $_POST["id"] = $entidad->idcategoria;
                              return redirect('/admin/categorias')->with('msg', $msg);
                        }
                  } catch (\Exception $e) {
                        $msg["ESTADO"] = MSG_ERROR;
                        $msg["MSG"] = $e->getMessage();
                        $titulo = "Modificar categoria";
                        $categoria = new Categoria();
                        return view('sistema.categoria-nuevo', compact('titulo', 'msg', 'categoria'));
                  }
            }
            public function cargarGrilla(Request $request){
                  $request = $_REQUEST;
                  $eentidad = new Categoria();
                  $aCategorias = $eentidad->obtenerFiltrado(); 
                  $data = array();
                  $cont  = 0;
                  $inicio = $request['start'];
                  $registros_por_pagina = $request['length'];
                  for ($i = $inicio; $i < count($aCategorias) && $cont < $registros_por_pagina; $i++) {
                        $row = array();
                        $row[] = '<a href="/admin/categorias/' . $aCategorias[$i]->idcategoria . '">' . $aCategorias[$i]->nombre . '</a>';
                        $cont++;
                        $data[] = $row;
                  }
                  $json_data = array(
                        "draw" => intval($request['draw']),
                        "recordsTotal" => count($aCategorias),
                        "recordsFiltered" => count($aCategorias),
                        "data" => $data
                  );
                  return json_encode($json_data);
            }
            public function editar($idcategoria){
                  $titulo = "Editar categoria";
                  $categoria = new Categoria();
                  $categoria = $categoria->obtenerPorId($idcategoria);
                  return view('sistema.categoria-nuevo', compact('titulo', 'categoria'));
            }
      }

?>