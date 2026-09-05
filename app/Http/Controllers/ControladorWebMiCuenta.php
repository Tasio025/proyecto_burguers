<?php

namespace App\Http\Controllers;
use App\Entidades\Cliente;
use App\Entidades\Sucursal;
use App\Entidades\Pedido;
use Illuminate\Support\Facades\Redis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ControladorWebMiCuenta extends Controller{
      public function index(){
            if(!Session::has('idcliente')){
                  $mensaje ='Debe iniciar sesión para ver su cuenta';
                   $sucursal = new Sucursal();
                  $aSucursales = $sucursal->obtenerTodos();
                  $titulo = "Iniciar sesión";
                  return view('web.login', compact('mensaje', 'aSucursales'));
            }
            $idcliente = Session::get('idcliente');
            $cliente = new Cliente();
            $cliente = $cliente->obtenerPorId($idcliente);

            $pedido = new Pedido();
            $aPedidos = $pedido->obtenerPorCliente($idcliente);

            $sucursal = new Sucursal();
            $aSucursales = $sucursal->obtenerTodos();
            return view("web.mi-cuenta", compact('cliente', 'aPedidos', 'aSucursales'));
      }
      public function guardar(Request $request){      //Request para recibir los valores del formulario
            //dd($request->all());
            if(!Session::has('idcliente')){
                  $mensaje = 'Debe iniciar sesión para ver su cuenta';
                  $sucursal = new Sucursal();
                  $aSucursales = $sucursal->obtenerTodos();
                  return view('web.login', compact('mensaje', 'aSucursales'));
            }
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
                  
                  $msg['ESTADO'] = EXIT_SUCCESS;
                  $msg['MSG'] = 'Datos actualizados correctamente';

                  return view("web.mi-cuenta", compact('msg', 'aSucursales'));
            }catch (\Exception $e){
                 //dd($e->getMessage());
                 $msg['ESTADO'] = 'danger';
                 $msg['MSG'] = "Error al guardar los datos: " . $e->getMessage();

                 return view("web.mi-cuenta", compact('msg', 'aSucursales'));
            }
      }
}
?>