<?php
namespace App\Entidades;

use DB;
use Illuminate\Database\Eloquent\Model;

      class Sucursal extends Model{

      protected $table = 'sucursales';
      public $timestamps = false;
      protected $fillable = ['idsucursales', 'telefono', 'direccion', 'linkmapa', 'nombre', 'horario'];
      protected $hidden = [];

      public function cargarDesdeRequest($request){
            $this->idsucursales = $request->input('id') != "0" ? $request->input('id') : $this->idsucursales;
            $this->telefono = $request->input('txtTelefono');
            $this->direccion = $request->input('txtDireccion');
            $this->linkmapa = $request->input('txtLink');
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
            FROM sucursales WHERE idsucursales = ?";
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
            linkmapa,
            nombre,
            horario
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
      public function obtenerFiltrado(){
            $request = $_REQUEST;
            $columns = array(
                  0 => 'idsucursales',
                  1 => 'telefono',
                  2 => 'direccion',
                  3 => 'linkmapa',
                  4 => 'nombre',
                  5 => 'horario'
            );
            $sql = "SELECT
            idsucursales,
            telefono,
            direccion,
            linkmapa,
            nombre,
            horario
            FROM sucursales WHERE 1= 1";
            //Ahora realizamos el filtrado
            if(!empty($request['search']['value'])){
                  $sql .= " AND (
                        idsucursales LIKE '%".$request['search']['value']."%' OR
                        telefono LIKE '%".$request['search']['value']."%' OR
                        direccion LIKE '%".$request['search']['value']."%' OR
                        linkmapa LIKE '%".$request['search']['value']."%' OR
                        nombre LIKE '%".$request['search']['value']."%' OR
                        horario LIKE '%".$request['search']['value']."%'
                  )";
            }
            $sql .= " ORDER BY ".$columns[$request['order'][0]['column']]." ".$request['order'][0]['dir'];
            $lstRetorno = DB::select($sql);
            return $lstRetorno;
      }
}

?>