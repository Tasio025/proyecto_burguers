<?php

namespace App\Http\Controllers;
use App\Entidades\Carrito;
use App\Entidades\Sucursal;
use Illuminate\Http\Request;
use Session;
require app_path() . '/start/constants.php';

class ControladorWebCarrito extends Controller{
      public function index(){
            $idcliente = Session::get("idcliente"); // Este debería ser el ID del cliente logueado
            $carritos = new Carrito();
            //Acá el profe llama a la función obtenerPorCliente y le pasa el idcliente, porque hay que traer los carritos del cliente logueado
            $aCarritos = $carritos->obtenerPorCliente($idcliente);
            $sucursal = new Sucursal();
            $aSucursales = $sucursal->obtenerTodos();
            return view("web.carrito", compact('carritos', 'aCarritos', 'aSucursales', 'sucursal'));   //Esto nos devolvera el carrito.blade.php(el carrito de la plantilla) pero hay que armarlo xq aparece todo roto
      }                                        //Por que el profe sacó carritos y sucursal de acá?
     //Hace falta la función guardar?
      //Dudas acá en esta función
      public function eliminar(Request $request){
            $idcarritos = $request->input("txtCarrito");
            $carrito = new Carrito();
            $carrito->idcarritos = $idcarritos;
            $carrito->eliminar();
            $resultado["err"] = EXIT_SUCCESS;
            $resultado["mensaje"] = "Producto eliminado exixtosamente";
            return view('web.carrito', compact('resultado'));
            //return redirect('/carrito');
      }
      public function actualizar(Request $request){
            $cantidad = $request->input("txtCantidad");
            $carrito = new Carrito();
            $carrito->cantidad = $cantidad;
            $carrito->guardar();
            $resultado["err"] = EXIT_SUCCESS;
            $resultado["mensaje"] = "Producto actualizado exitosamente";
            return view('web.carrito', compact('resultado'));
           /* $idcarritos = $request->input("txtCarritos");
            $cantidad = $request->input("txtCantidad");
            $carrito = new Carrito();
            $carrito->actualizarCantidad($idcarritos, $cantidad);
            return redirect('/carrito');*/
      }
      public function procesar(Request $request){
           if(isset($_POST["btnBorrar"])){
                  $this->eliminar($request);
           }else if(isset($_POST["btnActualizar"])){
                  $this->actualizar($request);
           }else if(isset($_POST["btnFinalizar"])){
                  $this->insertarPedido($request);
           } 
      }
      public function insertarPedido(Request $request){
            
      }
}

?>