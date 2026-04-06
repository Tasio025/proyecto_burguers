<?php


namespace App\Entidades;
use DB;
use Illuminate\Database\Eloquent\Model;

      class Proveedor extends Model{
      protected $table = 'proveedores';
      public $timestamps = false;
      protected $fillable = ['idproveedor', 'nombre', 'direccion', 'telefono', 'correo'];
      protected $hidden = [];

      public function cargarDesdeRequest($request){
            $this->idproveedor = $request->input('id') != "0" ? $request->input('id') : $this->idproveedor;
            $this->nombre = $request->input('txtNombre');
            $this->direccion = $request->input('txtDireccion');
            $this->telefono = $request->input('txtTelefono');
            $this->correo = $request->input('txtCorreo');
      } 

      public function obtenerTodos(){
            $sql = "SELECT
                  idproveedor,
                  nombre,
                  direccion,
                  telefono,
                  correo
                  FROM proveedores ORDER BY idproveedor ASC";
                  $lstRetorno = DB::select($sql);
                  return $lstRetorno;
      }
      public function obtenerPorId($idproveedor){
            $sql = "SELECT
            idproveedor,
            nombre,
            direccion,
            telefono,
            correo
            FROM proveedores WHERE idproveedor = $idproveedor";
            $lstRetorno = DB::select($sql, [$idproveedor]);
            
           if(count($lstRetorno)> 0){
                  $this->idproveedor = $lstRetorno[0]->idproveedor;
                  $this->nombre = $lstRetorno[0]->nombre;
                  $this->direccion = $lstRetorno[0]->direccion;
                  $this->telefono = $lstRetorno[0]->telefono;
                  $this->correo = $lstRetorno[0]->correo;
                  return $this;
            }
            return null;
      }
      public function guardar(){
            $sql = "UPDATE proveedores SET
            nombre = '$this->nombre',
            direccion = '$this->direccion',
            telefono = '$this->telefono',
            correo = '$this->correo'
            WHERE idproveedor = ?";
            $affected = DB::update($sql, [$this->idproveedor]);
            //return $affected;
      }
      public function eliminar(){
            $sql = "DELETE FROM proveedores WHERE idproveedor =?";
            $affected = DB::delete($sql, [$this->idproveedor]);
      }
      public function insertar(){
            $sql = "INSERT INTO proveedores(
            nombre,
            direccion,
            telefono,
            correo
            ) VALUES (?, ?, ?, ?)";
            $result = DB::insert($sql, [
                  $this->nombre,
                  $this->direccion,
                  $this->telefono,
                  $this->correo
            ]);
            return $this->idproveedor = DB::getPdo()->lastInsertId();   
      }
}     


?>