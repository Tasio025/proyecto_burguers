<?php

      namespace App\Entidades\Sistema;

      use DB;
      use Illuminate\Database\Eloquent\Model;

      class Carritos extends Model{

      protected $table = 'carritos';
      public $timestamps = false;
      
      protected $fillable = [ 'idcarrito', 'fk_idcliente', 'fk_idproductos'];

      protected $hidden = [];

      public function obtenerTodos(){
            $sql = "SELECT
                  idcarrito,
                  fk_idcliente,
                  fk_idproductos
                  FROM carritos ORDER BY idcarrito ASC";
                  $lstRetorno = DB::select($sql);
                  return $lstRetorno;
      }
      public function obtenrePorId($idcarrito){
            $sql = "SELECT
            idcarrito,
            fk_idcliente,
            fk_idproductos
            FROM carritos WHERE idcarrito = $idcarrito";
            $lstRetorno = DB::select($sql, [$idcarrito]);
            return $lstRetorno;

            if(count($lstRetorno)> 0){
                  $this->idcarrito = $lstRetorno[0]->idcarrito;
                  $this->fk_idcliente = $lstRetorno[0]->fk_idcliente;
                  $this->fk_idproductos = $lstRetorno[0]->fk_idproductos;
                  return $this;
            }
            return null;
      }
      public function guardar(){
            $sql = "UPDATE carritos SET
            fk_idclientes = $this->fk_idclientes,
            fk_idproductos = $this->fk_idproductos
            WHERE idcarrito = $this->idcarrito";
      $affected = DB::update($sql);
      }
      public function eliminar(){
            $sql = "DELETE FROM carritos WHERE idcarrito = $this->idcarrito";
            $affected = DB::delete($sql);
      }
      public function insertar(){
            $sql = "INSERT INTO carritos(
            fk_idclientes,
            fk_idcproductos
            ) VALUES (?, ?";
            $result = DB::insert($sql, [
                  $this->fk_idclientes,
                  $this->fk_idproductos
            ]);
            return $result;
      }
}

?>