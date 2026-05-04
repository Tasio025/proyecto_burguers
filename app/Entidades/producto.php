<?php

namespace App\Entidades;

use DB;
use Illuminate\Database\Eloquent\Model;

      class Producto extends Model{

      protected $table = 'productos';
      public $timestamps = false;
      protected $fillable = ['idproducto', 'nombre', 'cantidad', 'precio', 'imagen', 'fk_idcategoria', 'descripcion', 'titulo'];
      protected $hidden = [];

      public function cargarDesdeRequest($request){
            $this->idproducto = $request->input('id') != "0" ? $request->input('id') : $this->idproducto;
            $this->nombre = $request->input('txtNombre');
            $this->cantidad = $request->input('txtCantidad');
            $this->precio = $request->input('txtPrecio');
            $this->imagen = $request->input('txtImagen');
            $this->fk_idcategoria = $request->input('lstTipoproducto');
      }

      public function obtenerTodos(){
            $sql = "SELECT
                  idproducto,
                  nombre,
                  cantidad,
                  precio,
                  imagen,
                  fk_idcategoria
                  FROM productos ORDER BY titulo ASC";
                  $lstRetorno = DB::select($sql);
                  return $lstRetorno;
      }
      public function obtenerPorId($idproducto){
            $sql = "SELECT
            idproducto,
            nombre,
            cantidad,
            precio,
            imagen,
            fk_idcategoria
            FROM productos WHERE idproducto = ?";
            $lstRetorno = DB::select($sql, [$idproducto]);
            return $lstRetorno;

            if(count($lstRetorno)> 0){
                  $this->idproducto = $lstRetorno[0]->idproducto;
                  $this->nombre = $lstRetorno[0]->nombre;
                  $this->cantidad = $lstRetorno[0]->cantidad;
                  $this->precio = $lstRetorno[0]->precio;
                  $this->imagen = $lstRetorno[0]->imagen;
                  $this->fk_idcategoria = $lstRetorno[0]->fk_idcategoria;
                  return $this;
            }
            return null;
      }
      public function obtenerPorTipo($idTipoProducto){
            $sql = "SELECT 
            idproducto,
            nombre,
            cantidad,
            precio,
            imagen,
            fk_idcategoria
            FROM productos WHERE fk_idcategoria = $idTipoProducto";
            $lstRetorno = DB::select($sql, [$idTipoProducto]);

      }
      public function guardar(){
            $sql = "UPDATE productos SET
            nombre = '$this->nombre',
            cantidad = $this->cantidad,
            precio = $this->precio,
            imagen = '$this->imagen',
            fk_idcategoria = $this->fk_idcategoria
            WHERE idproducto =?";
            $affected = DB::update($sql[$this->idproducto]);
      }
      public function eliminar(){
            $sql = "DELETE FROM productos WHERE idproducto = ?";
            $affected = DB::delete($sql, [$this->idproducto]);
      }
      public function insertar(){
            $sql = "INSERT INTO productos(
            nombre,
            cantidad,
            precio,
            imagen,
            fk_idcategoria
            ) VALUES (?, ?, ?, ?, ?)";
            $result = DB::insert($sql, [
                  $this->nombre,
                  $this->cantidad,
                  $this->precio,
                  $this->imagen,
                  $this->fk_idcategoria
            ]);
            return $this->idproducto = DB::getPdo()-> lastInsertId();
      }
      public function obtenerFiltrado(){
            $request = $_REQUEST;
            $columns = array(
                  0 => 'A.idproducto',
                  1 => 'A.nombre',
                  2 => 'A.cantidad',
                  3 => 'A.precio',
                  4 => 'A.imagen',
                  5 => 'A.fk_idcategoria'
            );
            $sql = "SELECT
            idproducto,
            nombre,
            cantidad,
            precio,
            imagen,
            fk_idcategoria
            FROM productos A WHERE 1=1";
            //Acá se hace el filtrado
            if(!empty($request['search']['value'])){
                  $sql .= "AND (nombre like '%" . $request['search']['value'] . "%')";
                  $sql .= "OR cantidad like '%" . $request['search']['value'] . "%')";
                  $sql .= "OR precio like '%" . $request['search']['value'] . "%')";
                  $sql .= "OR imagen like '%" . $request['search']['value'] . "%')";
                  $sql .= "OR fk_idcategoria like '%" . $request['search']['value'] . "%')";
            }
            $lstRetorno = DB::select($sql);
            return $lstRetorno;
      }
      public function existePedidoPorCategoria(){
            $sql = "SELECT
            idproducto,
            nombre,
            cantidad,
            precio,
            imagen,
            fk_idcategoria
            FROM productos WHERE fk_idcategoria = $idcategoria";
            $lstRetorno = DB::select($sql);
            if(count($lstRetorno)>0){
                  return true;
            }
            return false;
      }
}

?>