<?php
namespace App\Entidades;

use DB;
use Illuminate\Database\Eloquent\Model;

      class Sucursales extends Model{

      protected $table = 'sucursales';
      public $timestamps = false;
      protected $fillable = ['idsucursal', 'telefono', 'direccion', 'linkmapa', 'nombre', 'horario'];
      protected $hidden = [];

      public function obtenerTodos(){
            $sql = "SELECT
                  idsucursal,
                  telefono,
                  direccion,
                  linkmapa,
                  nombre,
                  horario
                  FROM sucursales ORDER BY nombre ASC";
                  $lstRetorno = DB::select($sql);
                  return $lstRetorno;
      }
      public function obtenerPorId($idsucursal){
            $sql = "SELECT
            idsucursal,
            telefono,
            direccion,
            linkmapa,
            nombre,
            horario
            FROM sucursales WHERE idsucursal = $idsucursal";
            $lstRetorno = DB::select($sql, [$idsucursal]);
            return $lstRetorno;

            if(count($lstRetorno)> 0){
                  $this->idsucursal = $lstRetorno[0]->idsucursal;
                  $this->telefono = $lstRetorno[0]->telefono;
                  $this->direccion = $lstRetorno[0]->direccion;
                  $this->linkmapa = $lstRetorno[0]->linkmapa;
                  return $this;
            }
            return null;
      }
      public function guardar(){
            $sql = "UPDATE sucursales SET
            telefono = '$this->telefono',
            direccion = '$this->direccion',
            linkmapa = '$this->linkmapa',
            nombre = '$this->nombre',
            horario = '$this->horario'    
            WHERE idsucursal = ?";
            $affected = DB::update($sql, [$this->idsucursal]);
      }
      public function eliminar(){
            $sql = "DELETE FROM sucursales WHERE idsucursal = ?";
            $affected = DB::delete($sql, [$this->idsucursal]);
      }
      public function insertar(){
            $sql = "INSERT INTO sucursales (
            telefono,
            direccion,
            linkmapa
            ) VALUES (?, ?, ?, ?, ?)";
            $result = DB::insert($sql, [
                  $this->telefono,
                  $this->direccion,
                  $this->linkmapa,
                  $this->nombre,
                  $this->horario,
            ]);
            return $this->idsucursak = DB::getPdo()->lastInsertId();
      }
}

?>