<?php

namespace App\Http\Controllers;

use App\Entidades\Sucursal;
use App\Entidades\Pedido;
use Illuminate\Http\Request;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Patente;
require app_path() . '/start/constants.php';
      class ControladorSucursal extends Controller{
            public function nuevo(){
                  $titulo = "Nueva sucursal";
                  if(Usuario::autenticado() == true){
                        if(!Patente::autorizarOperacion("SUCURSALALTA")){
                              $codigo = "SUCURSALALTA";
                              $mensaje = "No tiene pemisos para la operaci&oacute;n";
                              return view('sistema.pagina-error', compact('codigo', 'mensaje'));
                        }else{
                              $sucursal = new Sucursal();
                              return view('sistema.sucursal-nuevo', compact("titulo", "sucursal"));
                        }
                  }else{
                        return redirect('admin/login');
                  }
            }
            public function index(){      //El index va a ser basicamente el listado
            $titulo = "Listado de sucursales";
            if(Usuario::autenticado() == true){
                  if(!Patente::autorizarOperacion("SUCURSALCONSULTA")){
                        $codigo = "SUCURSALCONSULTA";
                        $mensaje = "No tiene pemisos para la operaci&oacute;n";
                        return view('sistema.pagina-error', compact('codigo', 'mensaje'));
                  }else{
                        $sucursal = new Sucursal();
                        return view('sistema.sucursal-listado', compact("titulo", "sucursal"));
                  }
            }else{
                  return redirect('admni/login');
            }
      }
            public function guardar(Request $request){
                  try{
                        $titulo = "Modificar sucursal";
                        $entidad = new Sucursal();
                        $entidad->cargarDesdeRequest($request);

                        //Validaciones
                        if($entidad->telefono == "" || $entidad->direccion == "" || $entidad->linkmapa == "" || $entidad->nombre == "" || $entidad->horario == ""){
                              $msg["ESTADO"] = MSG_ERROR;
                              $msg["MSG"] = "Complete todos los datos";
                              $sucursal = new Sucursal();
                              return view('sistema.sucursal-nuevo', compact('titulo', 'msg', 'sucursal'));
                        } else {
                              if($_POST["idsucursales"] > 0){   //id o idsucursal????
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
                              $_POST["idsucursales"] = $entidad->idsucursales;
                              return redirect('/admin/sucursales')->with('msg', $msg);
                        }
                  } catch (\Exception $e) {
                        $msg["ESTADO"] = MSG_ERROR;
                        $msg["MSG"] = $e->getMessage();
                        $titulo = "Modificar sucursal";
                        $sucursal = new Sucursal();
                        return view('sistema.sucursal-nuevo', compact('titulo', 'msg', 'sucursal'));
                  }
            }
            public function cargarGrilla(Request $request){
                  $request = $_REQUEST;
                  $entidad = new Sucursal();
                  $aSucursales = $entidad->obtenerFiltrado();
                  $data = array();
                  $cont = 0;
                  $inicio = $request['start'];
                  $registros_por_pagina = $request['length'];

                  for($i = $inicio; $i<count($aSucursales) && $cont < $registros_por_pagina; $i++){
                        $row = array();
                        $row[] = '<a href="/admin/sucursal/' . $aSucursales[$i]->idsucursales . '">' . $aSucursales[$i]->nombre . '</a>';
                        $row[] = $aSucursales[$i]->telefono;
                        $row[] = $aSucursales[$i]->direccion;
                        $row[] = $aSucursales[$i]->linkmapa;
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
            public function editar($idsucursal){
                  $titulo = "Editar sucursal";
                  if(Usuario::autenticado() == true){
                        if(!Patente::autorizarOperacion("SUCURSALMODIFICACION")){
                              $codigo = "SUCURSALMODIFICACION";
                              $mensaje = "No tiene pemisos para la operación";
                              return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
                        }else{
                        $sucursal = new Sucursal();
                        $sucursal = $sucursal->obtenerPorId($idsucursal);
                        return view('sistema.sucursal-nuevo', compact('titulo', 'codigo', 'mensaje','sucursal'));
                        }
                  }else{
                        return redirect('admin/login');
                  }
            }             
            public function eliminar(Request $request){
                  if(Usuario::autenticado() == true){
                        if(!Patente::autorizarOperacion("SUCURSALELIMINAR")){
                              $codigo = "SUCURSALELIMINAR";
                              $mensaje = "No tiene pemisos para la operación";
                              return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
                        }else{
                              
                              $idsucursales = $request->input("idsucursal");
                              $sucursal = new Sucursal();
                              $pedido = new Pedido();
                              if($pedido->existePedidoPorSucursal($idsucursales)){
                                    $resultado["err"] = EXIT_FAILURE;
                                    $resultado["mensaje"] = "No se puede eliminar la sucursal porque tiene pedidos asociados";
                              }else{
                                    $sucursal->idsucursales  = $idsucursales;
                                    $sucursal->eliminar();
                                    $resultado["err"] = EXIT_SUCCESS;
                                    $resultado["mensaje"] = "Registro eliminado exitosamente";
                              }
                        }
                  }else{
                        $resultado["err"] = EXIT_SUCCESS;
                        $resultado["mensaje"] = "Rregistro eliminado exitosamente";
                  }
                  return json_encode($resultado);
            }
      }


?>