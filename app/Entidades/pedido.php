<?php

namespace App\Entidades;

use DB;
use Illuminate\Database\Eloquent\Model;

      class Pedido extends Model{

      protected $table = 'pedidos';
      public $timestamps = false;

      protected $fillable = ['idpedido', 'fecha', 'descripcion', 'total', 'fk_idsucursal', 'fk_idcliente', 'fk_idestado'];
      protected $hidden = [];

      public function cargarDesdeRequest($request){
            $this->idpedido = $request->input('idpedido') != "0" ? $request->input('idpedido') : $this->idpedido;
            $this->fecha = $request->input('txtFecha');
            $this->descripcion = $request->input('txtDescripcion');
            $this->total = $request->input('txtTotal');
            $this->fk_idsucursal = $request->input('lstSucursal');
            $this->fk_idcliente = $request->input('lstCliente');
            $this->fk_idestado = $request->input('lstEstado');
      }
      public function obtenerTodos(){
            $sql = "SELECT
                  idpedido,
                  fecha,
                  descripcion,
                  total,
                  fk_idsucursal,
                  fk_idcliente,
                  fk_idestado
                  FROM pedidos ORDER BY fecha DESC";
                  $lstRetorno = DB::select($sql);
                  return $lstRetorno;
      }
      public function obtenerPorId($idpedido){
            $sql = "SELECT
            idpedido,
            fecha,
            descripcion,
            total,
            fk_idsucursal,
            fk_idcliente,
            fk_idestado
            FROM pedidos WHERE idpedido = ?";
            $lstRetorno = DB::select($sql, [$idpedido]);
            return $lstRetorno;

            if(count($lstRetorno)> 0){
                  $this->idpedido = $lstRetorno[0]->idpedido;
                  $this->fecha = $lstRetorno[0]->fecha;
                  $this->descripcion = $lstRetorno[0]->descripcion;
                  $this->total = $lstRetorno[0]->total;
                  $this->fk_idsucursal = $lstRetorno[0]->fk_idsucursal;
                  $this->fk_idcliente = $lstRetorno[0]->fk_idcliente;
                  $this->fk_idestado = $lstRetorno[0]->fk_idestado;
                  return $this;
            }
            return null;
      }
      public function guardar(){
            $sql = "UPDATE pedidos SET
            fecha = '$this->fecha',
            descripcion = '$this->descripcion',
            total = $this->total,
            fk_idsucursal = $this->fk_idsucursal,
            fk_idcliente = $this->fk_idcliente,
            fk_idestado = $this->fk_idestado
            WHERE idpedido = ?";

      $affected = DB::update($sql, [$this->idpedido]);
      }
      public function eliminar(){
            $sql = "DELETE FROM pedidos WHERE idpedido = ?";
            $affected = DB::delete($sql, [$this->idpedido]);
      }
      public function insertar(){
            $sql = "INSERT INTO pedidos(
            fecha,
            descripcion,
            total,
            fk_idsucursal,
            fk_idcliente,
            fk_idestado
            ) VALUES (?, ?, ?, ?, ?, ?)";
            $result = DB::insert($sql, [
                  $this->fecha,
                  $this->descripcion,
                  $this->total,
                  $this->fk_idsucursal,
                  $this->fk_idcliente,
                  $this->fk_idestado
            ]);
            return $this->idpedido = DB::getPdo()->lastInsertId();
      }
      public function existePedidoPorCliente($idcliente){
            //Primero armamos la query
            $sql = "SELECT
            idpedido,
            fecha,
            descripcion,
            total,
            fk_idsucursal,
            fk_idcliente,
            fk_idestado
            FROM pedidos WHERE fk_idcliente = $idcliente";

            /*$sql = "SELECT  Esta query debería ir en alguna parte de pedido_producto
            idpedido,
            fk_idproducto,
            fk_idpedido
            FROM pedido_productos WHERE fk_idproducto = $idproducto";*/
            //Ejecutamos la query
            $lstRetorno = DB::select($sql);
            //Si el cliente tiene pedidos asociados, no se puede eliminar
            if(count($lstRetorno) > 0){
                  return true;
            }
            return false;
      }
      public function existePedidosPorProducto($idproducto){
            $sql = "SELECT
            idpedidoproducto,
            fk_idproducto,
            fk_idpedido
            FROM pedido_productos WHERE fk_idproducto = $idproducto";
            $lstRetorno = DB::select($sql);
            
            return (count($lstRetorno) > 0);
      }
      public function existePedidoPorSucursal($idsucursales){
            $sql = "SELECT
            idpedido,
            fecha,
            descripcion,
            total,
            fk_idsucursal,
            fk_idcliente,
            fk_idestado
            FROM pedidos WHERE fk_idsucursal = $idsucursales";
            $lstRetorno = DB::select($sql);
            if(count($lstRetorno) > 0){
                  return true;
            }
            return false;
      }
      public function obtenerFiltrado(){
            $request = $_REQUEST;
            $columns = array(
                  0 => "idpedido",
                  1 => "fecha",
                  2 => "descripcion",
                  3 => "total",
                  4 => "fk_idsucursal",
                  5 => "fk_idcliente",
                  6 => "fk_idestado"
            );
            $sql = "SELECT
            idpedido,
            fecha,
            descripcion,
            total,
            fk_idsucursal,
            fk_idcliente,
            fk_idestado
            FROM pedidos WHERE 1 = 1";
            //Acá se hace el filtrado
            if(!empty($request['search']{'value'})){
                  $sql .= " AND (fecha like '%" . $request['search']['value'] . "%'";
                  $sql .= " OR descripcion like '%" . $request['search']['value'] . "%'";
                  $sql .= " OR total like '%" . $request['search']['value'] . "%'";
                  $sql .= " OR fk_idsucursal like '%" . $request['search']['value'] . "%'";
                  $sql .= " OR fk_idcliente like '%" . $request['search']['value'] . "%'";
                  $sql .= " OR fk_idestado like '%" . $request['search']['value'] . "%')";
            }
            $lstRetorno = DB::select($sql);
            return $lstRetorno;
      }
}
?>