<?php

namespace App\Entidades\Sistema;

use DB;
use Illuminate\Database\Eloquent\Model;

      class Estado_pedido extends Model{
      protected $table = 'estado_pedido';
      public $timestamps = false;
      protected $fillable = ['idestadopedido', 'nombre'];
      protected $hidden = [];

      public function obtenerTodos(){
            $sql = "SELECT
                  idestadopedido,
                  nombre
                  FROM estado_pedido ORDER BY nombre ASC";
                  $lstRetorno = DB::select($sql);
                  return $lstRetorno;
      }
      public function obtenerPorId($idestadopedido){
            $sql = "SELECT
            idestadopedido,
            nombre
            FROM estado_pedido WHERE idestadopedido = $idestadopedido";
            $lstRetorno = DB::select($sql, [$idestadopedido]);
            return $lstRetorno;

            if(count($lstRetorno)> 0){
                  $this->idestadopedido = $lstRetorno[0]->idestadopedido;
                  $this->nombre = $lstRetorno[0]->nombre;
                  return $this;
            }
            return null;
            }
      public function guardar(){
            $sql = "UPDATE estado_pedido SET
            nombre = '$this->nombre'    
            WHERE idestadopedido = ?";
            $affected = DB::update($sql, [$this->idestadopedido]);
      }
      public function eliminar(){
            $sql = "DELETE FROM estado_pedido WHERE idestadopedido = ?";
            $affected = DB::delete($sql, [$this->idestadopedido]);
      }
      public function insertar(){
            $sql = "INSERT INTO estado_pedido (
                  nombre
                  ) VALUES (?);";
            $result = DB::insert($sql, [
                   $this->nombre
             ]);
             return $this->idestadopedido = DB::getPdo()->lastInsertId();
      }
}


?>