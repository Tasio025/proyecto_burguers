<?php

namespace App\Http\Controllers;

use App\Entidades\Cliente;  //AGREGADO X COP
use Illuminate\Http\Request;  //AGREGADO X COP

class ControladorCliente extends Controller{

      public function nuevo(){
            $titulo = "Nuevo clientes";
            return view('Sistema.cliente-nuevo', compact("titulo")); //Envía la variable título
      }
      //A PARTIR DE ACÁ AGREGADO X COP
      public function guardar(Request $request){
            $cliente = new Cliente();
            $cliente->nombre = $request->input('txtNombre');
            $cliente->apellido = $request->input('txtApellido', '');
            $cliente->correo = $request->input('txtCorreo', '');
            $cliente->dni = $request->input('txtDni', 0);
            $cliente->celular = $request->input('txtCelular', '');
            
            $id = $request->input('id');
            
            if($id > 0){
                  // Actualizar cliente existente
                  $cliente->idcliente = $id;
                  $resultado = $cliente->guardar();
                  $msg = "Cliente actualizado correctamente";
            } else {
                  // Insertar nuevo cliente
                  $resultado = $cliente->insertar();
                  $msg = "Cliente guardado correctamente";
            }
            
            return redirect('/admin/cliente/nuevo')->with('msg', ['MSG' => $msg, 'ESTADO' => 'success']);
      }
}

?>