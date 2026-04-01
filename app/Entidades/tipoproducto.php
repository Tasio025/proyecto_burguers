<?php

namespace App\Entidades\Sistema;

use DB;
use Illuminate\Database\Eloquent\Model;

      class Tipoproducto extends Model{
      protected $table = 'tipoproducto';
      public $timestamps = false;
      protected $fillable = ['idtipoproducto', 'nombre'];
      protected $hidden = [];

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
            return $lstRetorno;

            if(count($lstRetorno)> 0){
                  $this->idtipoproducto = $lstRetorno[0]->idtipoproducto;
                  $this->nombre = $lstRetorno[0]->nombre;
                  return $this;
            }
            return null;
      }
      }

?>