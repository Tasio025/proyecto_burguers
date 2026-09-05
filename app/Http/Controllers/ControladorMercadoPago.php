<?php

namespace App\Http\Controllers;

use App\Entidades\Pedido;
use Illuminate\Http\Request;

require app_path() . '/start/constants.php';

class ControladorMercadoPago extends Controller{
      public function aprobar($idpedido){
            $pedido = new Pedido;
            $pedido->obtenerPorId($idpedido);
            $pedido->fk_estado = 1;
            $pedido->guardar();
            return redirect("/mi-cuenta");
      }
      public function pendiente($idpedido){
            $pedido = new Pedido;
            $pedido->obtenerPorId($idpedido);
            $pedido->fk_idestado = 5;
            $pedido->guardar();
            return redirect("/mi-cuenta");
      }
      public function error($idpedido){
            $pedido = new Pedido();
            $pedido->obtenerPorId($idpedido);
            $pedido->fk_idestado = 4;
            $pedido->guardar();
            return redirect("/mi-cuenta");
      }
}



?>