<?php

namespace App\Entidades;
use DB;   
use Illuminate\Database\Eloquent\Model;

      class Cliente extends Model{
      protected $table = 'clientes';
      public $timestamps = false;
      protected $fillable = ['idcliente', 'nombre', 'direccion', 'correo', 'dni', 'celular', 'clave'];
      protected $hidden = [];

      public function cargarDesdeRequest($request){
            $this->idcliente = $request->input('id') != "0" ? $request->input('id') : $this->idcliente;
            $this->nombre = $request->input('txtNombre');
            $this->direccion = $request->input('txtDireccion');
            $this->correo = $request->input('txtCorreo');
            $this->dni = $request->input('txtDni');
            $this->celular = $request->input('txtTelefono');
            $this->clave = $request->input('txtClave');
      } 

      public function obtenerTodos(){
            $sql = "SELECT
                  idcliente,
                  nombre,
                  direccion,
                  correo,
                  dni,,
                  clave
                  celular
                  FROM clientes ORDER BY idcliente ASC";
                  $lstRetorno = DB::select($sql);
                  return $lstRetorno;
      }
      public function obtenerPorId($idcliente){
            $sql = "SELECT
            idcliente,
            nombre,
            direccion,
            correo,
            dni,,
            clave
            FROM clientes WHERE idcliente = $idcliente";
            $lstRetorno = DB::select($sql, [$idcliente]);

            if(count($lstRetorno) > 0){
                  $this->idcliente = $lstRetorno[0]->idcliente;
                  $this->nombre = $lstRetorno[0]->nombre;
                  $this->direccion = $lstRetorno[0]->direccion;
                  $this->correo = $lstRetorno[0]->correo;
                  $this->dni = $lstRetorno[0]->dni;
                  $this->celular = $lstRetorno[0]->celular;
                  $this->clave = $lstRetorno[0]->clave;
                  return $this;
            }
            return null;
      }
      public function guardar(){
            $sql = "UPDATE clientes SET
            nombre = '$this->nombre',
            direccion = '$this->direccion',
            correo = '$this->correo',
            dni = $this->dni,
            celular = $this->celular,
            clave = '$this->clave'
            WHERE idcliente = ?";
            $affected = DB::update($sql, [$this->idcliente]);
           // return $affected;
      }
      public function eliminar(){
            $sql = "DELETE FROM clientes WHERE idcliente =?";
            $affected = DB::delete($sql, [$this->idcliente]);
      }
      public function insertar(){
            $sql = "INSERT INTO clientes ( 
                  nombre,
                  direccion,
                  correo,
                  dni,
                  celular,
                  clave
            ) VALUES (?,?,?,?,?,?)";
            $result = DB::insert($sql, [
                  $this->nombre,
                  $this->direccion,
                  $this->correo,
                  $this->dni,
                  $this->celular,
                  $this->clave
            ]);
            return $this->idcliente = DB::getPdo()->lastInsertId();
      }
      }     


?>