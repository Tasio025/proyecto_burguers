<?php

namespace App\Http\Controllers;
use App\Entidades\Cliente;
use Illuminate\Http\Request;
class ControladorWebCambiarClave extends Controller{
      public function index(){
            return view("web.cambiar-clave");
      }
      public function guardar(Request $request){
            try{
                  $claveActual = $request->input('txtClaveActual');
                  $claveNueva = $request->input('txtClaveNueva');
                  $claveConfirmacion = $request->input('txtClaveConfirmar');
                  $idcliente = 1;   //Buscamos al cliente con el id
                  $entidad = new Cliente();
                  $entidad->obtenerPorId($idcliente);
                  //Ahora tenemos que hacer una validacion para saber si la clave es correcta
                  //Esta validación es para saber si la clave es correcta
                  if($claveActual != $entidad->clave){
                        return redirect('/cambiar-clave')->with('msg', [
                              'ESTADO' => 'danger',
                              'MSG' => 'La contraseña actual es incorrecta'
                        ]);
                  }
                  //Esta validación es para asegurarnos de que la contraseña nueva se ingrese bien y no sea distinta a la de confirmacion
                  if($claveNueva != $claveConfirmacion){
                        return redirect('/cambiar-clave')->with('msg', [
                              'ESTADO' => 'danger',
                              'MSG' => 'Las nuevas contraceñas no coinciden'
                        ]);
                  }
                  //Ahora si todo está bien actualizamos
                  $entidad->clave = $claveNueva;
                  $entidad->guardar();

                  return redirect('/mi-cuenta')->with('msg', [
                        'ESTADO' => 'success',
                        'MSG' => 'Clave actualizada correctamente' 
                  ]);
            }catch(\Exception $e){
                  return redirect('/cambiar-clave')->with('msg', [
                        'ESTADO' => 'danger',
                        'MSG' => 'Error al cambiar la clave: ' . $e->getMessage()
                  ]);
            }
      }
}

?>