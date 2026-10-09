<?php

namespace App\Http\Controllers;

// use Adldap\Laravel\Facades\Adldap;
use App\Entidades\Sistema\Usuario_familia;
use App\Entidades\Sistema\Usuario_ip;
use App\Entidades\Sistema\Usuario_codigo;
use App\Mail\CodigoVerificacionMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Entidades\Sistema\Area;
use App\Entidades\Sistema\Menu;
use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sucursal;
use Illuminate\Http\Request;
use Session;

require app_path() . '/start/constants.php';
require app_path() . '/start/funciones_generales.php';

class ControladorLogin extends Controller
{
    public function index(Request $request)
    {
        $titulo = 'Acceso';
        return view('sistema.login', compact('titulo'));
    }

    public function login(Request $request)
    {
        return view('sistema.home');
    }

    public function logout(Request $request)
    {
        Session::flush();
        return redirect('admin/login');
    }

    public function entrar(Request $request){
        //Log::info('IP que ve el servidor: ' . $request->ip());
        $usuarioIngresado = fescape_string($request->input('txtUsuario'));
        $claveIngresada = fescape_string($request->input('txtClave'));

        $usuario = new Usuario();
        $lstUsuario = $usuario->validarUsuario($usuarioIngresado);

        if (count($lstUsuario) > 0) {
            if ($usuario->validarClave($claveIngresada, $lstUsuario[0]->clave)) {
                //CONTROL DE IP
                $idusuarioLogin =  $lstUsuario[0]->idusuario;
                $usuariosExentos = [1, 9];  //Los unicos usuarios que estan excentos de restricciones son 
                //el administrador total y el admin, los cuales poseen los permisos 1 y 9
                $bloquearSinIp = true; //devuelve true si un usuario sin ninguna IP cargada no entra
                $esExento = false; //Averigua si el usuario tiene alguno de los permisos exentos
                $familiaUsuario = new Usuario_familia();
                foreach($usuariosExentos as $idExento){
                    //Consulta si todavía no se encontró un permiso exento
                    if(!$esExento && $familiaUsuario->comprobarFamiliaDelUsuario($idusuarioLogin, $idExento) > 0){
                        $esExento = true;
                    }
                }
                //En caso de no ser administrador total o admin, se controla la IP
                if(!$esExento){   
                    $usuarioIp = new Usuario_ip();
                    $ipActual = $request->ip();//Ip del equipo que está entrando
                    $ipPermitida = $usuarioIp->comprobarIpUsuario($idusuarioLogin, $ipActual) > 0; //La ip actual está en la lista del usuario?
                    $tieneIps = count($usuarioIp->obtenerIpsDelUsuario($idusuarioLogin)) > 0; //El usuario tiene al menos una ip cargada?

                    //Se bloquea si la IP no está permitida  
                    if(!$ipPermitida && ($tieneIps || $bloquearSinIp)){
                        Log::warning('Login bloqueado por IP. Usuario: ' . $usuarioIngresado . ' - IP: ' . $ipActual);
                        $titulo = 'Acceso denegado';
                        $msg["ESTADO"] = MSG_ERROR;
                        $msg["MSG"] = "Su IP no está autorizada para ingresar al sistema";
                        return view('sistema.login', compact('titulo', 'msg'));
                    }
                }

                //2Fa. Clave y la Ip ya son correctas, pero todavía no se inicia la sesión
                $codigo = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
                $minutos = 10; //Validez del codigo

                //Guarda el codigo con su vencimiento
                $codigoVerificacion = new Usuario_codigo();
                $codigoVerificacion->guardarCodigo($idusuarioLogin, $codigo, $minutos);
                try{
                    Mail::to($lstUsuario[0]->mail)->send(new CodigoVerificacionMail($codigo, $minutos));
                } catch(\Exception $e){
                    //Se registra el error pero nunca el codigo
                    Log::error('No se pudo enviar el codigo de verifiación. Usuario: ' . $usuarioIngresado . ' - ' . $e->getMessage());
                    $titulo = 'ERROR';
                    $msg["ESTADO"] = MSG_ERROR;
                    $msg["MSG"] = "No se pudo enviar el código de verificación. Intente nuevamente más tarde.";
                    return view('sistema.login', compact('titulo', 'msg'));
                }

                //Solo queda "Pendiente" en sesión; todavía no está logueado
                $request->session()->put('2fa_usuario', $usuarioIngresado);
                $request->session()->put('2fa_intentos', 0);

                $titulo = 'Verificacion';
                return view('sistema.verificar_codigo', compact('titulo'));
            }else{
                $titulo = 'Acceso denegado';
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = "Credenciales incorrectas";
                return view('sistema.login', compact('titulo'));
            }
        }else{
            $titulo = 'Acceso denegado';
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = "Credenciales incorrectas";
            return view('sistema.login', compact('titulo', 'msg'));
        }

    }
    //Esta funcion es para cuando recibe el codigo que escribió ek usuario en los cuadraditos
    public function verificarCodigo(Request $request){
        //Si no hay login pendienverificarCodifote, vuelve al inicio
        $usuarioPendiente = $request->session()->get('2fa_usuario');
        if(!$usuarioPendiente){
            return redirect('admin/login');
        }
        //Cuenta intentos y corta a los 5
        $intentos = $request->session()->get('2fa_intentos', 0) + 1;
        $request->session()->put('2fa_intentos', $intentos);
        if($intentos > 5){
            $request->session()->forget(['2fa_usuario', '2fa_intentos']);
            $titulo = 'Acceso denegado';
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = "Demasiados intentos. INicie sesión nuevamente";
            return view('sistema.login', compact('msg', 'titulo'));
        }

        $codigoIngresado = fescape_string($request->input('txtCodigo'));

        //Busca al usuario
        $usuario = new Usuario();
        $lstUsuario = $usuario->validarUsuario($usuarioPendiente);
        //valida: coincide, no venció y no fue usado
        $codigoVerif = new Usuario_codigo();
        if(count($lstUsuario) > 0 && $codigoVerif->validarCodigo($lstUsuario[0]->idusuario, $codigoIngresado)){
            $request->session()->forget(['2fa_usuario', '2fa_intentos']);
            //Inicia sesión
            return $this->iniciarSesion($request, $lstUsuario);
        }else{
            $titulo = 'Verificacion';
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = "Código incorrecto";
            return view('sistema.verificar_codigo', compact('titulo', 'msg'));
        }
    }

    private function iniciarSesion(Request $request, $lstUsuario){
        //Genera un id de sesión nuevo al autenticar
        $request->session()->regenerate();
        $titulo = 'Inicio';
        $request->session()->put('usuario_id', $lstUsuario[0]->idusuario);
        $request->session()->put('usuario', $lstUsuario[0]->usuario);
        $request->session()->put('usuario_nombre', $lstUsuario[0]->nombre . " " . $lstUsuario[0]->apellido);

        $usuario = new Usuario();
        $usuario->idusuario = $lstUsuario[0]->idusuario;
        $usuario->actualizarFechaIngreso();
        //Carga los grupos de cuentas de usuario
        $grupo = new Area();
        $aGrupo = $grupo->obtenerAreasDelUsuario($lstUsuario[0]->idusuario);
        $request->session()->put('array_grupos', $aGrupo);

        //Grupo predeterminado
        if(isset($lstUsuario[0]->areapredeterminada) && $lstUsuario[0]->areapredeterminada != ""){
            $request->session()->put('grupo_id', $lstUsuario[0]->areapredeterminada);
        }else{
            $request->session()->put('grupo_id', $aGrupo[0]->idarea);
        }

        //Carga los permisos del usuario
        $familia = new Patente();
        $aPermisos = $familia->obtenerPatentesDelUsuario();
        if(count($aPermisos) > 0){
            $request->session()->put('array_permisos', $aPermisos);
        }
        //Carga el menu
        $menu = new Menu();
        $aMenu = $menu->obtenerMenuDelGrupo(Session::get('grupo_id'));
        if(count($aMenu)> 0){
            $request->session()->put('array_menu', $aMenu);
        }
        return view('sistema.index', compact('titulo'));
    }
}
