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
                        return redirect('/cambiar-clave')->with('msg', [
                              'ESTADO' => 'danger',
                              'MSG' => 'La contraseña actual es incorrecta'
                        ], 'aSucursales');
                  }
                  //Esta validación es para asegurarnos de que la contraseña nueva se ingrese bien y no sea distinta a la de confirmacion
                  if($claveNueva != $claveConfirmacion){
                        return redirect('/cambiar-clave')->with('msg', [
                              'ESTADO' => 'danger',
                              'MSG' => 'Las nuevas contraceñas no coinciden'
                        ], 'aSucursales');
                  }
                  //Ahora si todo está bien actualizamos
                  $entidad->clave = password_hash($claveNueva, PASSWORD_DEFAULT);
                  $entidad->guardar();

                  return redirect('/mi-cuenta')->with('msg', [
                        'ESTADO' => 'success',
                        'MSG' => 'Clave actualizada correctamente' 
                  ], 'aSucursales');
            }catch(\Exception $e){
                  return redirect('/cambiar-clave')->with('msg', [
                        'ESTADO' => 'danger',
                        'MSG' => 'Error al cambiar la clave: ' . $e->getMessage()
                  ], 'aSucursales');
            }
      }
}

?>