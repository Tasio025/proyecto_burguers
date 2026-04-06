<?php

namespace App\Entidades;

use DB;
use Illuminate\Database\Eloquent\Model;

      class Postulaciones extends Model{

      protected $table = 'postulaciones';
      public $timestamps = false;
      protected $fillable = ['idpostulacion', 'nombre', 'apellido', 'celular', 'dni', 'correo', 'clave'];
      protected $hidden = [];

      public function cargarDesdeRequest($request){
            $this->idpostulacion = $request->input('id') != "0" ? $request->input('id') : $this->idpostulacion;
            $this->nombre = $request->input('txtNombre');
            $this->apellido = $request->input('txtApellido');
            $this->celular = $request->input('txtTelefono');
            $this->dni = $request->input('txtDni');
            $this->correo = $request->input('txtCorreo');
            $this->clave = $request->input('txtClave');
      }
      public function obtenerTodos(){
            $sql = "SELECT
                  idpostulacion,
                  nombre,
                  apellido,
                  celular,
                  dni,
                  correo,
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
                  celular,
                  dni,
                  correo,
                  clave
                  FROM postulaciones WHERE idpostulacion = $idpostulacion";
                  $lstRetorno = DB::select($sql, [$idpostulacion]);
                  return $lstRetorno;
                  if(count($lstRetorno)> 0){
                        $this->idpostulacion = $lstRetorno[0]->idpostulacion;
                        $this->nombre = $lstRetorno[0]->nombre;
                        $this->apellido = $lstRetorno[0]->apellido;
                        $this->celular = $lstRetorno[0]->celular;
                        $this->dni = $lstRetorno[0]->dni;
                        $this->correo = $lstRetorno[0]->correo;
                        $this->clave = $lstRetorno[0]->clave;
                        return $this;
                  }
                  return null;
            }
            public function guardar(){
                  $sql = "UPDATE postulaciones SET
                  nombre = '$this->nombre',
                  apellido = '$this->apellido',
                  celular = '$this->celular',
                  dni = '$this->dni',
                  correo = '$this->correo',
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
                        celular,
                        dni,
                        correo,
                        clave
                  ) VALUES (?, ? ,?, ?, ?, ?, ?)";
                  $result = DB::insert($sql, [
                        $this->nombre,
                        $this->apellido,
                        $this->celular,
                        $this->dni,
                        $this->correo,
                        $this->clave
                  ]);
                  return $this->idpostulacion = DB::getPdo()->lastInsertId();
            }
      }  

?>