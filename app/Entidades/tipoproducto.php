<?php

namespace App\Entidades;

use DB;
use Illuminate\Database\Eloquent\Model;

      class Tipoproducto extends Model{
      protected $table = 'tipoproducto';
      public $timestamps = false;
      protected $fillable = ['idtipoproducto', 'nombre'];
      protected $hidden = [];

      public function cargarDesdeRequest($request){
            $this->idtipoproducto = $request->input('id') != "0" ? $request->input('id') : $this->idtipoproducto;
            $this->nombre = $request->input('txtNombre');
      }
      public function obtenerTodos(){
            $sql = "SELECT
                  idtipoproducto,
                  nombre
                  FROM tipoproducto ORDER BY nombre ASC";
                  $lstRetorno = DB::select($sql);
                  return $lstRetorno;
      }
      public function obtenerPorId($idtipoproducto){
            $sql = "SELECT
            idtipoproducto,
            nombre
            FROM tipoproducto WHERE idtipoproducto = $idtipoproducto";
            $lstRetorno = DB::select($sql, [$idtipoproducto]);

            if(count($lstRetorno)> 0){
                  $this->idtipoproducto = $lstRetorno[0]->idtipoproducto;
                  $this->nombre = $lstRetorno[0]->nombre;
                  return $this;
            }
            return null;
      }
      public function guardar(){
            $sql = "UPDATE tipoproducto SET
                  nombre='$this->nombre'
                  WHERE idtipoproducto=?";
            $affected = DB::update($sql, [$this->idtipoproducto]);
      }
      public function eliminar(){
            $sql = "DELETE FROM tipoproducto WHERE idtipoproducto=?";
            $affected = DB::delete($sql, [$this->idtipoproducto]);
      }
      public function insertar(){
            $sql = "INSERT INTO tipoproducto (
                  nombre
            ) VALUES (?)";
            $result = DB::insert($sql, [
                  $this->nombre
            ]);
            return $this->idtipoproducto = DB::getPdo()->lastInsertId();
      }
}

?>