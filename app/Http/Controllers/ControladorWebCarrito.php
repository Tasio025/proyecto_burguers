<?php

namespace App\Http\Controllers;
use App\Entidades\Carrito;
use App\Entidades\Producto;
use App\Entidades\Sucursal;
use App\Entidades\Cliente;
use App\Entidades\Pedido;
use App\Entidades\Pedido_producto;
use Illuminate\Http\Request;
//Librerías de MP
use MercadoPago\Item;
use MercadoPago\MerchantOrder;
use MercadoPago\Payer;
use Mercadopago\Preference;
use MercadoPago\SDK;
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
            $idsucursales = $request->input("lstSucursal");   //idsucursal?
            $pago = $request->input("lstPago");
            
            //Si se paga por mercado pago:
            if($pago == "MercadoPago"){
                  $this->procesarMercadoPago($request);
            }else{      //sino:

                  $carrito = new Carrito();
                  $aCarritos = $carrito->obtenerPorCliente($idcliente);
                  $sucursal = new Sucursal();
                  $aSucursales = $sucursal->obtenerTodos();

                  $total = 0;
                  foreach($aCarritos as $item){
                        ($total += $item->cantidad * $item->precio);
                  }

                  $fecha = date("Y-m-d");

                  $pedido = new Pedido();
                  $pedido->fk_idsucursal = $idsucursales;
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

                  //Vaciamos el carrito
                  $carrito ->eliminarPorCliente($idcliente);

                  $aCarritos = $carrito->obtenerPorCliente($idcliente);
                  

                  $msg["ESTADO"] = EXIT_SUCCESS;
                  $msg["MSG"] = "El pedido se ha confirmado correctamente";
                  return view("web.carrito", compact('msg', 'aSucursales', 'aCarritos'));
            }
      }
      public function procesarMercadoPago(Request $request){

            //Así se linkea con nuestra cuenta de MP
            $access_token = ""; //código secreto
            SDK::setClientId(config("payment-methods.mercadopago.client"));
            SDK::setClientSecret(config("payment-methods.mercadopago.secret"));
            SDK::setAccessToken($access_token); //Es el token de la cuenta de MP 
            
            $idcliente = Session::get("idcliente");
            $cliente = new Cliente();
            $cliente->obtenerPorId($idcliente);
            $sucursal = $request->input("lstSucursal"); //revisar nombre de sucursal
            $pago = $request->input("lstPago");

            $carrito = new Carrito();
            $aCarritos = $carrito->obtenerPorCliente($idcliente);

            $sucursal = new Sucursal();
            $aSucursales = $sucursal->obtenerTodos();

            //Armado del producto 'item'
            $item = new item();
            $item->id = "1234";
            $item->title = "Compra Web Gula Burguer SRL";
            $item->category_id = "products";
            $item->quantity = 1;
            $item->currency_id = "ARS";  

            $total = 0;
            foreach($aCarritos as $itemCarrito){
                  ($total += $itemCarrito->cantidad * $itemCarrito->precio);
                }
            $fecha = date("Y-m-d");

            $item->unit_price = $total;

            $preference = new Preference();
            $preference->items = array($item);

            //Armado de datos del comprador
            $payer = new Payer();
            $payer->name = $cliente->nombre;
            $payer->surname = "";
            $payer->email = $cliente->correo;
            $payer->date_created = date('Y-m-d H:m:s');
            $payer->identification = array(
                  "type" => "DNI",
                  "number" => $cliente->dni,
            );
            $preference->payer = $payer;
            
            //Armamos el pedido
                  $pedido = new Pedido();
                  $pedido->fk_idsucursal = $sucursal;
                  $pedido->fk_idcliente = $idcliente;
                  $pedido->fk_idestado = 5; // Estado pendiente 
                  $pedido->fecha = $fecha;
                  $pedido->pago = $pago;
                  $pedido->descripcion = "";
                  $pedido->total  = $total;

                  $pedido->insertar();

                  $pedidoProducto = new Pedido_producto();
                  foreach($aCarritos as $itemCarrito){
                        $pedidoProducto->fk_idproducto = $itemCarrito->fk_idproductos;
                        $pedidoProducto->fk_idpedido = $pedido->idpedido;
                        $pedidoProducto->cantidad = $itemCarrito->cantidad;
                        $pedidoProducto->precio_unitario = $itemCarrito->precio;
                        $pedidoProducto->total = $itemCarrito->cantidad * $itemCarrito->precio;
                        $pedidoProducto->insertar();
                  }

                  //Vaciamos el carrito
                  $carrito ->eliminarPorCliente($idcliente);

                  $aCarritos = $carrito->obtenerPorCliente($idcliente);

            //Ahora falta ejecutarlo
            //Si el pago es correcto, MP nos da la posibilidad de decidir a donde debe redirigirse ahora
            $preference->back_urls = [
                  "success" => "http://127.0.0.1:8000/mercado-pago/aprobado/" . $pedido->idpedido,    //Si el pago es exitoso
                  "pending" => "http://127.0.0.1:8000/mercado-pago/pendiente/" . $pedido->idpedido,    //Si el pago está pendiente
                  "failure" => "http://127.0.0.1:8000/mercado-pago/error/" . $pedido->idpedido,    //Si el pago falla
            ];

            $preference->payment_methdos = array("installments" => 6);
            $preference->auto_return = "all";
            $preference->notification_url = "";
            $preference->save();    //Ejecuta la transacción 



      }
}

?>