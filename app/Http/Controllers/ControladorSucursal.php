<?php

namespace App\Http\Controllers;

use App\Entidades\Sucursales;
use Illuminate\Http\Request;
require app_path() . '/start/constants.php';
      class ControladorSucursal extends Controller{
            public function nuevo(){
                  $titulo = "Nueva sucursal";
                  return view('sistema.sucursal-nuevo', compact("titulo"));
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
      }


?>