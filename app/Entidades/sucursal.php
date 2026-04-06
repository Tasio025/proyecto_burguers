<?php
namespace App\Entidades;

use DB;
use Illuminate\Database\Eloquent\Model;

      class Sucursales extends Model{

      protected $table = 'sucursales';
      public $timestamps = false;
      protected $fillable = ['idsucursales', 'telefono', 'direccion', 'linkmapa', 'nombre', 'horario'];
      protected $hidden = [];

      public function cargarDesdeRequest($request){
            $this->idcliente = $request->input('id') != "0" ? $request->input('id') : $this->idcliente;
            $this->telefono = $request->input('txtTelefono');
            $this->direccion = $request->input('txtDireccion');
            $this->linkmapa = $request->input('txtLinkMapa');
            $this->nombre = $request->input('txtNombre');
            $this->horario = $request->input('txtHorario');
      } 

      public function obtenerTodos(){
            $sql = "SELECT
                  idsucursales,
                  telefono,
                  direccion,
                  linkmapa,
                  nombre,
                  horario
                  FROM sucursales ORDER BY nombre ASC";
                  $lstRetorno = DB::select($sql);
                  return $lstRetorno;
      }
      public function obtenerPorId($idsucursales){
            $sql = "SELECT
            idsucursales,
            telefono,
            direccion,
            linkmapa,
            nombre,
            horario
            FROM sucursales WHERE idsucursales = $idsucursales";
            $lstRetorno = DB::select($sql, [$idsucursales]);
            

            if(count($lstRetorno)> 0){
                  $this->idsucursales = $lstRetorno[0]->idsucursales;
                  $this->telefono = $lstRetorno[0]->telefono;
                  $this->direccion = $lstRetorno[0]->direccion;
                  $this->linkmapa = $lstRetorno[0]->linkmapa;
                  $this->nombre = $lstRetorno[0]->nombre;
                  $this->horario = $lstRetorno[0]->horario;
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
            WHERE idsucursales = ?";
            $affected = DB::update($sql, [$this->idsucursales]);
      }
      public function eliminar(){
            $sql = "DELETE FROM sucursales WHERE idsucursales = ?";
            $affected = DB::delete($sql, [$this->idsucursales]);
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
            return $this->idsucursales = DB::getPdo()->lastInsertId();
      }
}

?>