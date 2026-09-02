<?php

namespace App\Http\Controllers;
use App\Entidades\Carrito;
use App\Entidades\Producto;
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
            return view("web.carrito", compact('aCarritos', 'aSucursales'));   //Esto nos devolvera el carrito.blade.php(el carrito de la plantilla) pero hay que armarlo xq aparece todo roto
      }                                        //Acá tenía también en este compact 'sucursal' y 'carrito'
     //Hace falta la función guardar?
      //Dudas acá en esta función
      public function eliminar($idcarritos){
            $carrito = new Carrito();
            $carrito->idcarritos = $idcarritos;
            $carrito->eliminar();
            $msg["ESTADO"] = EXIT_SUCCESS;
            $msg["MSG"] = "Producto eliminado correctamente";
            $idcliente = Session::get("idcliente");
            $carritos = new Carrito();
            $aCarritos = $carritos->obtenerPorCliente($idcliente);
            $sucursal = new Sucursal();
            $aSucursales = $sucursal->obtenerTodos();

            return view('web.carrito', compact('msg', 'aCarritos', 'aSucursales'));
            /*$idcarritos = $request->input("txtCarrito");
            $carrito = new Carrito();
            $carrito->idcarritos = $idcarritos;
            $carrito->eliminar();
            $resultado["err"] = EXIT_SUCCESS;
            $resultado["mensaje"] = "Producto eliminado exixtosamente";
            return view('web.carrito', compact('resultado', 'aCarritos', 'aSucursales'));*/
      }
      public function actualizar(Request $request){   //REVISAR ESTO, así debería estar bien el actualizar. Por que me marca error en $idcarrito y $producto
            $carritos = new Carrito();
            $idcarritos = $request->input("txtCarrito");
            $cantidad = $request->input("txtCantidad");
            $idproducto = $request->input("txtProducto");
            $idcliente = Session::get("idcliente");
            $carritos = $carritos->obtenerPorId($idcarritos);
            $carritos->cantidad = $cantidad;
            $carritos->fk_idcliente = $idcliente;
            $carritos->fk_idproductos = $idproducto;
            $carritos->guardar();
            $msg["ESTADO"] = EXIT_SUCCESS;
            $msg["MSG"] = "Producto actualizado exitosamente";
            //$carritos = new Carrito();
            $aCarritos = $carritos->obtenerPorCliente($idcliente);
            $sucursal = new Sucursal();
            $aSucursales = $sucursal->obtenerTodos();
            return view('web.carrito', compact('msg', 'aCarritos', 'aSucursales'));
      }
      public function procesar(Request $request){
           if(isset($_POST["btnBorrar"])){
            $idcarritos = $request->input("txtCarrito");
                  return $this->eliminar($idcarritos);
           }else if(isset($_POST["btnActualizar"])){
                  return $this->actualizar($request);
           }else if(isset($_POST["btnFinalizar"])){
                  return $this->insertarPedido($request);
           } 
      }
      public function insertarPedido(Request $request){
            
      }
}

?>