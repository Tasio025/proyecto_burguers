<?php

namespace App\Entidades\Sistema;

use Illuminate\Database\Eloquent\Model;
use DB;

class Usuario_ip extends Model{
      protected $table = 'usuario_ip';

      public $timestamps = false;
      protected $fillable = [
            'ip',
            'fk_idusuario'
      ];

      public function insertar(){
            $sql = "INSERT INTO usuario_ip (fk_idusuario, ip) VALUES (?, ?)";
            DB::insert($sql, [$this->fk_idusuario, $this->ip]);
      }

      public function eliminarPorUsuario($idusuario){
            $sql = "DELETE FROM usuario_ip WHERE fk_idusuario = ?";
            return DB::delete($sql, [$idusuario]);
      }

      public function obtenerIpsDelUsuario($idusuario){
            $sql = "SELECT ip  FROM usuario_ip WHERE fk_idusuario = ? ORDER BY idusuario_ip";
            return DB::select($sql, [$idusuario]);
      }

      public function comprobarIpUsuario($idusuario){
            $sql = "SELECT idusuario_ip FROM usuario_ip WHERE fk_idusuario = ? AND ip = ?";
            $lst = DB::select($sql, [$idusuario, $ip]);
            return count($lst);
      }
}



?>