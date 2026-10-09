<?php

namespace App\Entidades\Sistema;
use Illuminate\Database\Eloquent\Model;
use DB;

class Usuario_codigo extends Model{
      protected $table = 'usuario_codigo';
      protected $primaryKey = 'idusuario_codigo';

      public $timestamps = false;
      protected $fillable = [
      'idusuario_codigo', 'codigo', 'fecha_creacion', 'fecha_vencimiento', 'usado', 'fk_idusuario'
      ];

      public function guardarCodigo($idusuario, $codigo, $minutos){
            //Anula los codigos pendientes
             $sqlAnular = "UPDATE usuario_codigo SET usado = 1 WHERE fk_idusuario = ? AND usado = 0";
            DB::update($sqlAnular, [$idusuario]);
            
            //Guardar el hash, nunca el codigo en texto plano
            $hash = password_hash($codigo, PASSWORD_DEFAULT);

            //El vencimiento lo calcula la base con NOW(), el mismo reloj que se usa para comparar después
            $sql = "INSERT INTO usuario_codigo (fk_idusuario, codigo, fecha_creacion, fecha_vencimiento, usado) VALUES (?, ?, NOW(), DATE_ADD(NOW(), INTERVAL ? MINUTE), 0)";
            DB::insert($sql, [$idusuario, $hash, (int) $minutos]);
      }

      //Devuelve true si el codigo es correcto, está vigente y no fué usado
      public function validarCodigo($idusuario, $codigo){
            //Toma solo el ultimo valor del usuario que siga disponible y sin vencer
            $sql = "SELECT idusuario_codigo, codigo FROM usuario_codigo WHERE fk_idusuario = ? AND usado = 0 AND fecha_vencimiento > NOW() ORDER BY idusuario_codigo DESC LIMIT 1";
            $lst = DB::select($sql, [$idusuario]);

            //Si no hay ninguno vigente no es valido
            if(count($lst) == 0){
                  return false;
            }

            //Compara lo que escribió el usuario con el hash guardado
            if(!password_verify($codigo, $lst[0]->codigo)){
                  return false;
            }

            //Lo marca como usado, la condición usado = 0 evita que sirva dos vees
            $sqlUsar = "UPDATE usuario_codigo SET usado = 1 WHERE idusuario_codigo = ? AND usado = 0";
            $filas = DB::update($sqlUsar , [$lst[0]->idusuario_codigo]);

            //Solo es válido si efectivamente lo consumió esta llamada
            return $filas > 0;
      }
      public function eliminarAntiguos(){
            $sql = "DELETE FROM usuario_codigo WHERE fecha_vencimiento < DATE_SUB(NOW(), INTERVAL 1 DAY)";
            return DB::delete($sql);
      }
}




?>