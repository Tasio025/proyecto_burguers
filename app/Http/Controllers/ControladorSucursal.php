<?php

namespace App\Http\Controllers;

use App\Entidades\Sucursales;
use App\Entidades\Pedido;
use Illuminate\Http\Request;
require app_path() . '/start/constants.php';
      class ControladorSucursal extends Controller{
            public function nuevo(){
                  $titulo = "Nueva sucursal";
                  $sucursal = new Sucursales();
                  return view('sistema.sucursal-nuevo', compact("titulo", "sucursal"));
            }
            public function index(){      //El index va a ser basicamente el listado
            $titulo = "Listado de sucursales";
            $sucursal = new Sucursales();
            return view('sistema.sucursal-listado', compact("titulo", "sucursal"));
      }
            public function guardar(Request $request){
                  try{
                        $titulo = "Modificar sucursal";
                        $entidad = new Sucursales();
                        $entidad->cargarDesdeRequest($request);

                        //Validaciones
                        if($entidad->telefono == "" || $entidad->direccion == "" || $entidad->linkmapa == "" || $entidad->nombre == "" || $entidad->horario == ""){
                              $msg["ESTADO"] = MSG_ERROR;
                              $msg["MSG"] = "Complete todos los datos";
                              $sucursal = new Sucursales();
                              return view('sistema.sucursal-nuevo', compact('titulo', 'msg', 'sucursal'));
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
                              $_POST["id"] = $entidad->idsucursales;
                              return redirect('/admin/sucursales')->with('msg', $msg);
                        }
                  } catch (\Exception $e) {
                        $msg["ESTADO"] = MSG_ERROR;
                        $msg["MSG"] = $e->getMessage();
                        $titulo = "Modificar sucursal";
                        $sucursal = new Sucursales();
                        return view('sistema.sucursal-nuevo', compact('titulo', 'msg', 'sucursal'));
                  }
            }
            public function cargarGrilla(Request $request){
                  $request = $_REQUEST;
                  $entidad = new Sucursales();
                  $aSucursales = $entidad->obtenerFiltrado();
                  $data = array();
                  $cont = 0;
                  $inicio = $request['start'];
                  $registros_por_pagina = $request['length'];

                  for($i = $inicio; $i<count($aSucursales) && cont < $registros_por_pagina; $i++){
                        $row = array();
                        $row[] = '<a href="/admin/sistema/sucursales/' . $aSucursales[$i]->idsucursales . '">' . $aSucursales[$i]->idsucursales . '</a>';
                        $row[] = $aSucursales[$i]->telefono;
                        $row[] = $aSucursales[$i]->direccion;
                        $row[] = $aSucursales[$i]->linkmapa;
                        $row[] = $aSucursales[$i]->nombre;
                        $row[] = $aSucursales[$i]->horario;
                        $cont++;
                        $data[] = $row;
                  }
                  $json_data = array(
                        "draw" => intval($request['draw']),
                        "recordsTotal" => count($aSucursales),
                        "recordsFiltered" => count($aSucursales),
                        "data" => $data,
                  );
                  return json_encode($json_data);
            }
            public function editar($idsucursales){
                  $titulo = "Editar sucursal";
                  $sucursal = new Sucursales();
                  $sucursal = $sucursal->obtenerPorId($idsucursales);
                  return view('sistema.sucursal-editar', compact('titulo', 'sucursal'));
            }
            public function eliminar(Request $request){
                  $idsucursales = $request->input("idsucursal");
                  $sucursal = new Sucursales();
                  $pedido = new Pedido();
                  if($pedido->existePedidoPorSucursal($idsucursales)){
                        $resultado["err"] = EXIT_FAILURE;
                        $resultado["mensaje"] = "No se puede eliminar la sucursal porque tiene pedidos asociados";
                  }else{
                        $sucursal->idsucursal = $request->input("idsucursal");
                        $sucursal->eliminar();
                        $resultado["err"] = EXIT_SUCCESS;
                        $resultado["mensaje"] = "Registro eliminado exitosamente";
                  }
                  return json_encode($resultado);
            }

      }


?>