<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Facades\log;
use Illuminate\Http\Request;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\UsuarioArea;
use App\Entidades\Sistema\Usuario_familia;
use App\Entidades\Sistema\Area;
use App\Entidades\Legajo\Personal;
use App\Entidades\Sistema\Usuario_ip;
require app_path().'/start/constants.php';
use Session;


class ControladorUsuario extends Controller
{
    public function index(){
        $titulo = "Listado de usuarios";
        if(Usuario::autenticado() == true){
            if (!Patente::autorizarOperacion("USUARIOCONSULTA")) {
                $codigo = "USUARIOCONSULTA";
                $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                $titulo = "Listado de usuarios";
                return view('sistema.listar', compact('titulo'));
            }
        } else {
           return redirect('admin/login');
        }
    }

    public function nuevo(){
        $titulo = "Nuevo usuario";
        if(Usuario::autenticado() == true){
            if (!Patente::autorizarOperacion("USUARIOALTA")) {
                $codigo = "USUARIOALTA";
                $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                $usuario = new Usuario();

                /* CAMBIOS PARA EL DESPLEGABLE */
                $area = new Area();
                $array_area =  $area->obtenerTodos();

                $grupo = new Area();
                $array_grupo = $grupo->obtenerTodos();

                return view('sistema.nuevo-usuario', compact('usuario', 'array_area', 'array_grupo'));
            }
        } else {
           return redirect('admin/login');
        }        
    }

    public function editar($us){
        $titulo = "Modificar usuario";
        if(Usuario::autenticado() == true){
            if (!Patente::autorizarOperacion("USUARIOMODIFICAR")) {
                $codigo = "USUARIOMODIFICAR";
                $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                $usuario = new Usuario();
                $usuario->obtenerPorUsuario($us);

                $usuarioIp = new Usuario_ip();
                $lstIps = $usuarioIp->obtenerIpsDelUsuario($usuario->idusuario);
                $ips = implode("\n", array_column($lstIps, 'ip'));
                
                $area = new Area();
                $array_area = $area->obtenerTodos();
                
                $grupo = new Area();
                $array_grupo = $grupo->obtenerTodos();

                return view('sistema.nuevo-usuario', compact('usuario', 'array_area', 'array_grupo', 'ips'));
            }
        } else {
           return redirect('admin/login');
        }
    }

    public function cargarGrilla(){
        $request = $_REQUEST;

        $entidadUsuario = new Usuario();
        $usuarios = $entidadUsuario->obtenerFiltrado();

        $data = array();

        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];

        if (count($usuarios) > 0)
            $cont=0;
            for ($i=$inicio; $i < count($usuarios) && $cont < $registros_por_pagina; $i++) {
                $row = array();
                $row[] = '<a href="/admin/usuarios/' . $usuarios[$i]->usuario . '">' . $usuarios[$i]->usuario . '</a>';
                $row[] = $usuarios[$i]->nombre;
                $row[] = $usuarios[$i]->apellido;
                $row[] = $usuarios[$i]->created_at != ""? date_format(date_create($usuarios[$i]->created_at), 'd-m-Y H:i') : "";
                $row[] = $usuarios[$i]->ultimo_ingreso != "" ?date_format(date_create($usuarios[$i]->ultimo_ingreso), 'd-m-Y H:i') : "";
                $row[] = $usuarios[$i]->activo == 1 ? "Si" : "No";
                $cont++;
                $data[] = $row;
            }

        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($usuarios), //cantidad total de registros sin paginar
            "recordsFiltered" => count($usuarios),//cantidad total de registros en la paginacion
            "data" => $data
        );
        return json_encode($json_data);
    }

    /*public function guardar(Request $request){
        try {


            //Define la entidad servicio
            $titulo = "Usuario";
            $entidadUsuario = new Usuario();
            $entidadUsuario->cargarDesdeRequest($request);

            $ipsTexto = $request->input('txtIps');  //texto del textarea
            $aIps = array();  //Ips ya validadas, listas para guardar
            $lineaValida = null;    //Num de la primer linea invalida (si es null, significa que todas estan bien)

            //Esto se procesa solo si el formulario trajo el campo
            if($ipsTexto != NULL){
                //Separa el texto en lineas
                $lineas = preg_split('/\r\n|\r|\n/', $ipsTexto);
                foreach($lineas as $i => $linea){
                    $ip = trim($linea); //saca espacios al principio y al final
                    if($ip == ""){ //ignora las lineas vacias
                        continue;
                    }
                    //filter var devuelve false si es una ipv4 o ipv6 valida
                    if(filter_var($ip, FILTER_VALIDATE_IP) === false){
                        $lineaInvalida = $i + 1;
                        break;
                    }
                    $aIps[] = $ip;
                }
                $aIps = array_unique($aIps);
            }

            //validaciones
            if ($entidadUsuario->usuario == "" || $entidadUsuario->mail == "" || $entidadUsuario->nombre == "") {
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = USUARIOFALTACAMPOS;
            } else {
                if ($_POST["id"] > 0) {
                    //Es actualizacion
                    $entidadUsuario->guardar();

                    //Actualiza en datos personales
                    //$legajo = new Personal();
                    //$legajo->guardarDesdeUsuario($entidadUsuario);

                } else {
                    //Inserta en datos personales
                    //$legajo = new Personal();
                    //$legajo->insertarDesdeUsuario($entidadUsuario);

                    //Es nuevo
                    //$entidadUsuario->fk_idlegajo = $legajo->idlegajo;
                    $entidadUsuario->insertar();
                    $_POST["id"] = $entidadUsuario->idusuario;
                }

                if (Patente::autorizarOperacion("USUARIOAGREGARPERMISO")) {

                    //Guarda las patentes de la familia
                    $familiaUsuario = new Usuario_familia();

                    //Elimina todos las familias del usuario
                    $aFamiliaAsignados = $familiaUsuario->eliminarPorUsuario($entidadUsuario->idusuario);

                    //Obtiene las familias a asignar al usuario
                    $aFamiliaSinAsignar = array();
                    foreach ($_POST as $nombre => $valor) {
                        if (substr($nombre,0,12) == "chk_Familia_") {
                        	$idCompuesto = explode("_", substr($nombre,12,strlen($nombre)));
                            $idFamilia = $idCompuesto[0];
                            $idArea = $idCompuesto[1];
                            $familiaUsuario->fk_idfamilia = $idFamilia;
                            $familiaUsuario->fk_idarea = $idArea;
                            $familiaUsuario->fk_idusuario = $entidadUsuario->idusuario;
                        	$familiaUsuario->insertar();
                        }
                    }
                }

                //Guarda las Ips solo si el formulario trajo el campo, así si por alguna razón el campo no se envía, no se borran las Ips guardadas
                if($ipsTexto != NULL){
                    $usuarioIp = new Usuario_ip();
                    $usuarioIp->eliminarPorUsuario($entidadUsuario->idusuario);
                    foreach($aIps as $ip){
                        $usuarioIp->fk_idusuario = $entidadUsuario->idusuario;
                        $usaurioIp->ip = $ip;
                        $usuarioIp->insertar();
                    }
                }


                $msg["ESTADO"] = MSG_SUCCESS;
                $msg["MSG"] = OKINSERT;
                return view('sistema.listar', compact('titulo', 'msg'));
            }
            $usuario = new Usuario();
            $usuario->obtenerPorUsuario($request->input('txtUsuario'));
            //return view('sistema.nuevo-usuario', compact('msg', 'usuario')) . '?id' . $request->input('txtUsuario');

            $area = new Area();
            $array_area =  $area->obtenerTodos();

            $grupo = new Area();
            $array_grupo = $grupo->obtenerTodos();

            $ips = $ipsTexto;

            return view('sistema.nuevo-usuario', compact('array_area','msg','usuario', 'array_grupo'));
        } catch (Exception $e) {
            Log::error('Error al guardar usuario: ' . $e->getMessage());

            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;

            $usuario = new Usuario();
            $usuario->obtenerPorUsuario($request->input('txtUsuario'));

            $area = new Area();
            $array_area = $area->obtenerTodos();

            $grupo = new Area();
            $array_grupo = $grupo->obtenerTodos();

            $ips = $request->input('txtIps');

            return view('sistema.nuevo-usuario', compact('array_area', 'msg', 'usuario', 'array_grupo'));
        }                
    }*/
         public function guardar(Request $request){
        try {

            //Define la entidad servicio
            $titulo = "Usuario";
            $entidadUsuario = new Usuario();
            $entidadUsuario->cargarDesdeRequest($request);

            // has() dice si el campo vino en el formulario, aunque esté vacío
            $vinoCampoIps = $request->has('txtIps');
            // (string) convierte el null de un campo vacío en ""
            $ipsTexto = (string) $request->input('txtIps', '');
            $aIps = array();            //Ips ya validadas, listas para guardar
            // se llama $lineaInvalida, igual que más abajo
            $lineaInvalida = null;      //Nº de la primera línea inválida (null = todas están bien)

            //Esto se procesa solo si el formulario trajo el campo
            if ($vinoCampoIps) {
                //Separa el texto en líneas
                // el patrón correcto (\r\n o \r o \n)
                $lineas = preg_split('/\r\n|\r|\n/', $ipsTexto);
                foreach ($lineas as $i => $linea) {
                    $ip = trim($linea); //saca espacios al principio y al final
                    if ($ip == "") {    //ignora las líneas vacías
                        continue;
                    }
                    // filter_var devuelve false si NO es una IPv4 o IPv6 válida
                    if (filter_var($ip, FILTER_VALIDATE_IP) === false) {
                        $lineaInvalida = $i + 1;
                        break;
                    }
                    $aIps[] = $ip;
                }
                $aIps = array_unique($aIps);
            }

            //validaciones
            if ($entidadUsuario->usuario == "" || $entidadUsuario->mail == "" || $entidadUsuario->nombre == "") {
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = USUARIOFALTACAMPOS;
            } elseif ($lineaInvalida !== null) {
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = "La línea " . $lineaInvalida . " de IPs permitidas no es una IP válida.";
            } else {
                if ($_POST["id"] > 0) {
                    //Es actualizacion
                    $entidadUsuario->guardar();

                    //Actualiza en datos personales
                    //$legajo = new Personal();
                    //$legajo->guardarDesdeUsuario($entidadUsuario);

                } else {
                    //Inserta en datos personales
                    //$legajo = new Personal();
                    //$legajo->insertarDesdeUsuario($entidadUsuario);

                    //Es nuevo
                    //$entidadUsuario->fk_idlegajo = $legajo->idlegajo;
                    $entidadUsuario->insertar();
                    $_POST["id"] = $entidadUsuario->idusuario;
                }

                if (Patente::autorizarOperacion("USUARIOAGREGARPERMISO")) {

                    //Guarda las patentes de la familia
                    $familiaUsuario = new Usuario_familia();

                    //Elimina todos las familias del usuario
                    $aFamiliaAsignados = $familiaUsuario->eliminarPorUsuario($entidadUsuario->idusuario);

                    //Obtiene las familias a asignar al usuario
                    $aFamiliaSinAsignar = array();
                    foreach ($_POST as $nombre => $valor) {
                        if (substr($nombre,0,12) == "chk_Familia_") {
                            $idCompuesto = explode("_", substr($nombre,12,strlen($nombre)));
                            $idFamilia = $idCompuesto[0];
                            $idArea = $idCompuesto[1];
                            $familiaUsuario->fk_idfamilia = $idFamilia;
                            $familiaUsuario->fk_idarea = $idArea;
                            $familiaUsuario->fk_idusuario = $entidadUsuario->idusuario;
                            $familiaUsuario->insertar();
                        }
                    }
                }

                //Guarda las Ips solo si el formulario trajo el campo, así si por alguna razón no se envía, no se borran las Ips guardadas
                if ($vinoCampoIps) {
                    $usuarioIp = new Usuario_ip();
                    //Borra las Ips anteriores del usuario (se reemplazan todas)
                    $usuarioIp->eliminarPorUsuario($entidadUsuario->idusuario);
                    foreach ($aIps as $ip) {
                        $usuarioIp->fk_idusuario = $entidadUsuario->idusuario;
                        $usuarioIp->ip = $ip;
                        $usuarioIp->insertar();
                    }
                }

                $msg["ESTADO"] = MSG_SUCCESS;
                $msg["MSG"] = OKINSERT;
                return view('sistema.listar', compact('titulo', 'msg'));
            }
            $usuario = new Usuario();
            $usuario->obtenerPorUsuario($request->input('txtUsuario'));

            $area = new Area();
            $array_area =  $area->obtenerTodos();

            $grupo = new Area();
            $array_grupo = $grupo->obtenerTodos();

            $ips = $ipsTexto;

            return view('sistema.nuevo-usuario', compact('array_area','msg','usuario', 'array_grupo', 'ips'));
        } catch (Exception $e) {
            Log::error('Error al guardar usuario: ' . $e->getMessage());

            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;

            $usuario = new Usuario();
            $usuario->obtenerPorUsuario($request->input('txtUsuario'));

            $area = new Area();
            $array_area = $area->obtenerTodos();

            $grupo = new Area();
            $array_grupo = $grupo->obtenerTodos();

            $ips = $request->input('txtIps');

            return view('sistema.nuevo-usuario', compact('array_area', 'msg', 'usuario', 'array_grupo', 'ips'));
        }
    }

    public function buscarUsuario(Request $request){
        $nombre_usuario = $request->input('usuario');
        $usuario = new Usuario();
        $usuario->obtenerPorUsuario($nombre_usuario);
        if($usuario->id != ""){
            $msg["ESTADO"] = MSG_SUCCESS;
            $msg["nombre"] = $usuario->nombre;
            $msg["apellido"] = $usuario->apellido;
            $msg["email"] = $usuario->email;
        } else {
            $msg["ESTADO"] = MSG_ERROR;
        }
        echo json_encode($msg);
    }
    
}
