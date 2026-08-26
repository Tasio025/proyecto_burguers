<?php

namespace App\Http\Controllers;
use App\Entidades\Cliente;
use Illuminate\Support\Facades\Redis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ControladorWebMiCuenta extends Controller{
      public function index(){
            $idcliente = Session::get('idcliente');
            $cliente = new Cliente();
            $cliente = $cliente->obtenerPorId($idcliente);
            return view("web.mi-cuenta", compact('cliente'));
      }
      public function guardar(Request $request){      //Request para recibir los valores del formulario
            //dd($request->all());
            try{ 
                  $idcliente = Session::get('idcliente');
                 // dd($idcliente);
                  $cliente = New Cliente();
                  $cliente = $cliente->obtenerPorId($idcliente);
                  //$cliente->cargarDesdeRequest($request);   //Cargamos lo que el usuario escribió
                 //dd($cliente);
                 $cliente->nombre = $request->input('txtNombre');
                 $cliente->apellido = $request->input('txtApellido');
                 $cliente->celular = $request->input('txtTelefono');
                 $cliente->whatsapp = $request->input('txtWhatsapp');
                 $cliente->correo = $request->input('txtCorreo');
                  $cliente->guardar();    //Ejecutamos el método guardar que ya arreglamos antes en la clase cliente          
                  return redirect('/mi-cuenta')->with('msg', ['ESTADO' => 'success', 'MSG' => 'Datos actualizados correctamente']);      
            }catch (\Exception $e){
                 //dd($e->getMessage());
                  return redirect('/mi-cuenta')->with('msg', ['ESTADO' => 'danger', 'MSG' => 'Error al guardar: ' . $e->getMessage()]);
            }
      }
}
?>