<?php

namespace App\Entidades\Sistema;
use DB;   
use Illuminate\Database\Eloquent\Model;

      class Cliente extends Model{
      protected $table = 'clientes';
      public $timestamps = false;
      protected $fillable = ['idcliente', 'nombre', 'apellido', 'correo', 'dni', 'celular'];
      protected $hidden = [];

      public function obtenerTodos(){
            $sql = "SELECT
                  idcliente,
                  nombre,
                  apellido,
                  correo,
                  dni,
                  celular
                  FROM clientes ORDER BY idcliente ASC";
                  $lstRetorno = DB::select($sql);
                  return $lstRetorno;
      }
      public function obtenerPorId($idcliente){
            $sql = "SELECT
            idcliente,
            nombre,
            apellido,
            correo,
            dni,
            celular
            FROM clientes WHERE idcliente = $idcliente";
            $lstRetorno = DB::select($sql, [$idcliente]);
            return $lstRetorno;

            if(count($lstRetorno)> 0){
                  $this->idcliente = $lstRetorno[0]->idcliente;
                  $this->nombre = $lstRetorno[0]->nombre;
                  $this->apellido = $lstRetorno[0]->apellido;
                  $this->correo = $lstRetorno[0]->correo;
                  $this->dni = $lstRetorno[0]->dni;
                  $this->celular = $lstRetorno[0]->celular;
                  return $this;
            }
            return null;
      }
      public function guardar(){
            $sql = "UPDATE clientes SET
            nombre = '$this->nombre',
            apellido = '$this->apellido',
            correo = '$this->correo',
            dni = $this->dni,
            celular = $this->celular
            WHERE idcliente = ?";
            $affected = DB::update($sql, [$this->idcliente]);
            return $affected;
      }
      public function eliminar(){
            $sql = "DELETE FROM clientes WHERE idcliente =?";
            $affected = DB::delete($sql, [$this->idcliente]);
      }
      public function insertar(){
            $sql = "INSERT INTO clientes ( 
                  nombre,
                  apellido,
                  correo,
                  dni,
                  celular
            ) VALUES (?,?,?,?,?)";
            $result = DB::insert($sql, [
                  $this->nombre,
                  $this->apellido,
                  $this->correo,
                  $this->dni,
                  $this->celular
            ]);
            return $this->idcliente = DB::getPdo()->lastInsertId();
      }
      }     


?>