<?php

namespace App\Entidades;
use DB;
use Illuminate\Database\Eloquent\Model;

      class Pedido_producto extends Model{

      protected $table = 'pedido_producto';
      public $timestamps = false;

      protected $fillable = ['idpedidos_productos', 'cantidad', 'precio_unitario', 'total', 'fk_idpedido', 'fk_idproducto'];
      protected $hidden = [];

      public function obtenerTodos(){
            $sql = "SELECT
                  idpedidos_productos,
                  cantidad,
                  precio_unitario,
                  total,
                  fk_idpedido,
                  fk_idproducto
                  FROM pedidos_productos ORDER BY idpedidos_productos ASC";
                  $lstRetorno = DB::select($sql);
                  return $lstRetorno;

      }
      public function obtenerPorId($idpedidos_productos){
            $sql = "SELECT
            idpedidos_productos,
            cantidad,
            precio_unitario,
            total,
            fk_idpedido,
            fk_idproducto
            FROM pedidos_productos WHERE idpedidos_productos = $idpedidos_productos";
            $lstRetorno = DB::select($sql, [$idpedidos_productos]);
            return $lstRetorno;

            if(count($lstRetorno)> 0){
                  $this->idpedidos_productos = $lstRetorno[0]->idpedidos_productos;
                  $this->cantidad = $lstRetorno[0]->cantidad;
                  $this->precio_unitario = $lstRetorno[0]->precio_unitario;
                  $this->total = $lstRetorno[0]->total;
                  $this->fk_idpedido = $lstRetorno[0]->fk_idpedido;
                  $this->fk_idproducto = $lstRetorno[0]->fk_idproducto;
                  return $this;
            }
            return null;
      }
      public function guardar(){
            $sql = "UPDATE pedidos_productos SET
            cantidad = $this->cantidad,
            precio_unitario = $this->precio_unitario,
            total = $this->total,
            fk_idpedido = $this->fk_idpedido,
            fk_idproducto = $this->fk_idproducto
            WHERE idpedidos_productos = ?";
            $affected = DB::update($sql, [$this->idpedidos_productos]);
      }
      public function eliminar(){
            $sql = "DELETE FROM pedidos_productos WHERE idpedidos_productos = ?";
            $affected = DB::delete($sql, [$this->idpedidos_productos]);
      }
      public function insertar(){
            $sql = "INSERT INTO pedidos_productos (
                  cantidad,
                  precio_unitario,
                  total,
                  fk_idpedido,
                  fk_idproducto
            ) VALUES (?, ?, ?, ?, ?)";
            $result = DB::insert($sql, [
                  $this->cantidad,
                  $this->precio_unitario,
                  $this->total,
                  $this->fk_idpedido,
                  $this->fk_idproducto
            ]);
            return $this->idpedidos_productos = DB::getPdo()->lastInsertId();
      }

}


?>