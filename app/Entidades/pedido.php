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
            $this->idpedido = $request->input('id') != "0" ? $request->input('id') : $this->idpedido;
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
            //Ejecutamos la query
            $lstRetorno = DB::select($sql);
            //Si el cliente tiene pedidos asociados, no se puede eliminar
            if(count($lstRetorno) > 0){
                  return true;
            }
            return false;
      }
      public function existePedidoPorSucursal($idsucursales){
            $sql = "SELECT,
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
}
?>