<?php

namespace App\Http\Controllers;

use App\Entidades\Producto;
use Illuminate\Http\Request;

class ControladorProducto extends Controller{

      public function nuevo(){
            $titulo = 'Nuevo Producto';
            return view('Sistema.producto-nuevo', compact("titulo"));
      }
      public function guardar(Request $request){
            $producto = new Producto();

            //Datos del formulario
            $producto->nombre = $request->input('txtNombre');
            $producto->cantidad = $request->input('txtCantidad');
            $producto->precio = $request->input('txtPrecio');

            //Manejo de imagen
            if($request->hasFile('txtImagen')){
                  $archivo = $request->file('txtImagen');
                  $nombreImagen = time() . '_' . $archivo->getClientOriginalName();

                  //Guardar en carpeta public/img
                  $archivo->move(public_path('img'), $nombreImagen);

                  $producto->imagen = $nombreImagen;
            }
            //Guardar en BD
            $proudcto_>insertar();

            //Mensaje
            $msg = "Producto guardado!";

            return redirect('/admin/sistema/productos/nuevo')->with('msg', ['MSG' => $msg, 'ESTADO' => 'success']);
      }
}

?>