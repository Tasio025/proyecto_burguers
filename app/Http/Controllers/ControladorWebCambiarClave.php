<?php

namespace App\Http\Controllers;
use App\Entidades\Cliente;
use App\Entidades\Sucursal;   
use Illuminate\Http\Request;
use Session;
class ControladorWebCambiarClave extends Controller{
      public function index(){
            $sucursal = new Sucursal();
            $aSucursales = $sucursal->obtenerTodos();

            return view("web.cambiar-clave", compact('aSucursales'));
      }
      public function guardar(Request $request){
            try{
                  $claveActual = $request->input('txtClaveActual');
                  $claveNueva = $request->input('txtClaveNueva');
                  $claveConfirmacion = $request->input('txtClaveConfirmar');
                  $idcliente = Session::get('idcliente');
                  $sucursal = new Sucursal();
                  $aSucursales = $sucursal->obtenerTodos();
                  $entidad = new Cliente();
                  $entidad->obtenerPorId($idcliente);
                  //Ahora tenemos que hacer una validacion para saber si la clave es correcta
                  //Esta validación es para saber si la clave es correcta
                  if(!password_verify($claveActual, $entidad->clave)){
                        $msg['ESTADO'] = "danger";
                        $msg['MSG'] = "La contraseña actual es incorrecta";
                        
                        return view("web.cambiar-clave", compact('msg', 'aSucursales'));
                  }
                  //Esta validación es para asegurarnos de que la contraseña nueva se ingrese bien y no sea distinta a la de confirmacion
                  if($claveNueva != $claveConfirmacion){
                        $msg['ESTADO'] = "danger";
                        $msg['MSG'] = "La contraseña nueva y la confirmación no coinciden";

                        return view("web.cambiar-clave", compact('msg', 'aSucursales'));
                  }
                  //Ahora si todo está bien actualizamos
                  $entidad->clave = password_hash($claveNueva, PASSWORD_DEFAULT);
                  $entidad->guardar();

                  $msg['ESTADO'] = "success";
                  $msg['MSG'] = "Clave actualizada correctamente";

                  return view("web.cambiar-clave", compact('msg', 'aSucursales'));

                  /*    Por si el return view falla, dejo esto comentado
                   return redirect('/mi-cuenta')->with('msg', [
                  'ESTADO' => 'success',
                  'MSG' => 'Clave actualizada correctamente'
                  ]);*/ 
            }catch(\Exception $e){
                  $msg['ESTADO'] = 'danger';
                  $msg['MSG'] = "Error al actualizar la clave: " . $e->getMessage();

                  return view("web.cambiar-clave", compact('msg', 'aSucursales'));
            }
      }
}

?>