<?php

namespace App\Http\Controllers;
use App\Entidades\Carrito;
use App\Entidades\Producto;
use App\Entidades\Sucursal;
use App\Entidades\Pedido;
use App\Entidades\Pedido_producto;
use Illuminate\Http\Request;
use Session;
require app_path() . '/start/constants.php';

class ControladorWebCarrito extends Controller{
      public function index(){
            $idcliente = Session::get("idcliente"); // Este debería ser el ID del cliente logueado
            $carritos = new Carrito();
            //Acá el profe llama a la función obtenerPorCliente  y le pasa el idcliente, porque hay que traer los carritos del cliente logueado
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
            $aCarritos = $carrito->obtenerPorCliente($idcliente);
            $sucursal = new Sucursal();
            $aSucursales = $sucursal->obtenerTodos();

            return view('web.carrito', compact('msg', 'aCarritos', 'aSucursales'));
      }
      public function actualizar(Request $request){   //REVISAR ESTO, así debería estar bien el actualizar. Por que me marca error en $idcarrito y $producto
            $cantidad = $request->input("txtCantidad");
            $idcarritos = $request->input("txtCarrito");
            $idproducto = $request->input("txtProducto");
            $idcliente =  Session::get("idcliente");
            
            $carrito = new Carrito();
            $carrito->idcarritos = $idcarritos;
            $carrito->cantidad = $cantidad;
            $carrito->fk_idcliente = $idcliente;
            $carrito->fk_idproductos = $idproducto;
            $carrito->guardar();
            
            $aCarritos = $carrito->obtenerPorCliente($idcliente);
            $sucursal = new Sucursal();
            $aSucursales = $sucursal->obtenerTodos();

            $msg["ESTADO"] = EXIT_SUCCESS;
            $msg["MSG"] = "Producto actualizado correctamente";

            return view('web.carrito', compact('msg', 'aSucursales', 'aCarritos'));
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
            //Falta terminar
            $idcliente = Session::get("idcliente");
            $carrito = new Carrito();
            $aCarritos = $carrito->obtenerPorCliente($idcliente);
            $sucursal = new Sucursal();
            $aSucursales = $sucursal->obtenerTodos();

            //REVISAR ESTE FOR
            $total = 0;
            foreach($aCarritos as $item){
                  ($total += $item->cantidad * $item->precio);
            }

            $sucursal = $request->input("lstSucursal");
            $pago = $request->input("lstPago");
            $fecha = date("Y-m-d");

            $pedido = new Pedido();
            $pedido->fk_idsucursal = $sucursal;
            $pedido->fk_idcliente = $idcliente;
            $pedido->fk_idestado = 1; // Estado pendiente
            $pedido->fecha = $fecha;
            $pedido->pago = $pago;
            $pedido->descripcion = "";
            $pedido->total  = $total;

            $pedido->insertar();

            $pedidoProducto = new Pedido_producto();
            foreach($aCarritos as $item){
                  $pedidoProducto->fk_idproducto = $item->fk_idproductos;
                  $pedidoProducto->fk_idpedido = $pedido->idpedido;
                  $pedidoProducto->cantidad = $item->cantidad;
                  $pedidoProducto->precio_unitario = $item->precio;
                  $pedidoProducto->total = $item->cantidad * $item->precio;
                  $pedidoProducto->insertar();
            }

            //Faltaría vaciar el carrito
            $carrito ->eliminarPorCliente($idcliente);

            $aCarritos = $carrito->obtenerPorCliente($idcliente);
            

            $msg["ESTADO"] = EXIT_SUCCESS;
            $msg["MSG"] = "El pedido se ha confirmado correctamente";
            return view("web.carrito", compact('msg', 'aSucursales', 'aCarritos'));
      }
}

?>