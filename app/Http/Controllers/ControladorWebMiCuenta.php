<?php

namespace App\Http\Controllers;
use App\Entidades\Cliente;
use Illuminate\Support\Facades\Redis;
use Illuminate\Http\Request;

class ControladorWebMiCuenta extends Controller{
      public function index(){
            $idcliente = 1;   
            $cliente = new Cliente();     
            $cliente = $cliente->obtenerPorID($idcliente);
            return view("web.mi-cuenta", compact('cliente'));
      }
      public function guardar(Request $request){      //Request para recibir los valores del formulario
            try{ 
                  $idcliente = 1;
                  $cliente = New Cliente();
                  $cliente->cargarDesdeRequest($request);   //Cargamos lo que el usuario escribió
                  $cliente->idcliente = $idcliente;   //Forzamos el id para que el modelo sepa que es un UPDATE y no un INSERT
                  $cliente->guardar();    //Ejecutamos el método guardar que ya arreglamos antes en la clase cliente          
                  return redirect('/mi-cuenta')->with('msg', ['ESTADO' => 'success', 'MSG' => 'Datos actualizados correctamente']);      
            }catch (\Exception $e){
                  return redirect('/mi-cuenta')->with('msg', ['ESTADO' => 'danger', 'MSG' => 'Error al guardar: ' . $e->getMessage()]);
            }
      }
}
?>