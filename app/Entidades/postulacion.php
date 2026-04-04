<?php

namespace App\Entidades;

use DB;
use Illuminate\Database\Eloquent\Model;

      class Postulaciones extends Model{

      protected $table = 'postulaciones';
      public $timestamps = false;
      protected $fillable = ['idpostulacion', 'nombre', 'apellido', 'correo', 'dni', 'celular', 'clave'];
      protected $hidden = [];

      public function obtenerTodos(){
            $sql = "SELECT
                  idpostulacion,
                  nombre,
                  apellido,
                  correo,
                  dni,
                  celular,
                  clave
                  FROM postulaciones ORDER BY idpostulacion ASC";
                  $lstRetorno = DB::select($sql);
                  return $lstRetorno;
            }

            public function obtenerPorId($idpostulacion){
                  $sql = "SELECT
                  idpostulacion,
                  nombre,
                  apellido,
                  correo,
                  dni,
                  celular,
                  clave
                  FROM postulaciones WHERE idpostulacion = $idpostulacion";
                  $lstRetorno = DB::select($sql, [$idpostulacion]);
                  return $lstRetorno;
                  if(count($lstRetorno)> 0){
                        $this->idpostulacion = $lstRetorno[0]->idpostulacion;
                        $this->nombre = $lstRetorno[0]->nombre;
                        $this->apellido = $lstRetorno[0]->apellido;
                        $this->correo = $lstRetorno[0]->correo;
                        $this->dni = $lstRetorno[0]->dni;
                        $this->celular = $lstRetorno[0]->celular;
                        $this->clave = $lstRetorno[0]->clave;
                        return $this;
                  }
                  return null;
            }
            public function guardar(){
                  $sql = "UPDATE postulaciones SET
                  nombre = '$this->nombre',
                  apellido = '$this->apellido',
                  correo = '$this->correo',
                  dni = '$this->dni',
                  celular = '$this->celular',
                  clave = '$this->clave'
                  WHERE idpostulacion = ?";
                  $affected = DB::update($sql, [$this->idpostulacion]);
            }
            public function eliminar(){
                  $sql = "DELETE FROM postulaciones WHERE idpostulacion = ?";
                  $affected = DB::delete($sql, [$this->idpostulacion]);
            }
            public function insertar(){
                  $sql = "INSERT INTO postulaciones (
                        nombre,
                        apellido,
                        correo,
                        dni,
                        celular,
                        clave
                  ) VALUES (?, ? ,?, ?, ?, ?, ?)";
                  $result = DB::insert($sql, [
                        $this->nombre,
                        $this->apellido,
                        $this->correo,
                        $this->dni,
                        $this->celular,
                        $this->clave
                  ]);
                  return result;
            }
      }  

?>