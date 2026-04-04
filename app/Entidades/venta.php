<?php

namespace App\Entidades;
use DB;
use Illuminate\Database\Eloquent\Model;

      class Ventas extends Model{

      protected $table = 'ventas';
      public $timestamps = false;
      protected $fillable = ['idventa', 'fecha', 'cantidad', 'preciounitario', 'total'];
      protected $hidden = [];

      public function obtenerTodos(){
            $sql = "SELECT
                  idventa,
                  fecha,
                  cantidad,
                  preciounitario,
                  total
                  FROM ventas ORDER BY idventa ASC";
                  $lstRetorno = DB::select($sql);
                  return $lstRetorno;

      }
      public function obtenerPorId($idventa){
            $sql = "SELECT
            idventa,
            fecha,
            cantidad,
            preciounitario,
            total
            FROM ventas WHERE idventa = $idventa";
            $lstRetorno = DB::select($sql, [$idventa]);
            return $lstRetorno;

            if(count($lstRetorno)> 0){
                  $this->idventa = $lstRetorno[0]->idventa;
                  $this->fecha = $lstRetorno[0]->fecha;
                  $this->cantidad = $lstRetorno[0]->cantidad;
                  $this->preciounitario = $lstRetorno[0]->preciounitario;
                  $this->total = $lstRetorno[0]->total;
                  return $this;
            }
            return null;
      }

      public function guardar(){
            $sql = "UPDATE ventas SET
            fecha = '$this->fecha',
            cantidad = $this->cantidad,
            preciounitario = $this->preciounitario,
            total = $this->total
            WHERE idventa = ?";
            $affected = DB::update($sql, [$this->idventa]);
      }
      public function eliminar(){
            $sql = "DELETE FROM ventas WHERE idventa =?";
            $affected = DB::delete($sql, [$this->idventa]);
      }
      public function insertar(){
            $sql = "INSERT INTO ventas (
            fecha,
            cantidad,
            preciounitario,
            total
             ) VALUES (?, ?, ?, ?)";
             $result = DB::insert($sql, [
                   $this->fecha,
                   $this->cantidad,
                   $this->preciounitario,
                   $this->total
             ]);
             return $this->idventa = DB getPdo()->lastInsertId();
      }
}
?>