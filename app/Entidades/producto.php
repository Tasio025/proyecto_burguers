<?php

namespace App\Entidades;

use DB;
use Illuminate\Database\Eloquent\Model;

      class Producto extends Model{

      protected $table = 'productos';
      public $timestamps = false;
      protected $fillable = ['idproducto', 'nombre', 'descripcion', 'precio', 'imagen', 'fk_idcategoria'];
      protected $hidden = [];

      public function cargarDesdeRequest($request){
            $this->idproducto = $request->input('idproducto') != "0" ? $request->input('idproducto') : $this->idproducto;
            $this->nombre = $request->input('txtNombre');
            $this->descripcion = $request->input('txtDescripcion');
            $this->precio = $request->input('txtPrecio');
            $this->fk_idcategoria = $request->input('lstCategoria');
      }

      public function obtenerTodos(){
            $sql = "SELECT 
                  idproducto,
                  nombre,
                  descripcion,
                  precio,
                  imagen,
                  fk_idcategoria
                  FROM productos ORDER BY nombre ASC";
                  $lstRetorno = DB::select($sql);
                  return $lstRetorno;
      }
      public function obtenerPorId($idproducto){
            $sql = "SELECT
            idproducto,
            nombre,
            descripcion,
            precio,
            imagen,
            fk_idcategoria
            FROM productos WHERE idproducto = ?";
            $lstRetorno = DB::select($sql, [$idproducto]);
            if(count($lstRetorno)> 0){
                  $this->idproducto = $lstRetorno[0]->idproducto;
                  $this->nombre = $lstRetorno[0]->nombre;
                  $this->descripcion = $lstRetorno[0]->descripcion;
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
            descripcion,
            precio,
            imagen,
            fk_idcategoria
            FROM productos WHERE fk_idcategoria = ?";
            $lstRetorno = DB::select($sql, [$idTipoProducto]);
            return $lstRetorno;

      }
      public function guardar(){
            $sql = "UPDATE productos SET
            nombre = '$this->nombre',
            descripcion = '$this->descripcion',
            precio = $this->precio,
            imagen = '$this->imagen',
            fk_idcategoria = $this->fk_idcategoria
            WHERE idproducto =?";
            $affected = DB::update($sql, [$this->idproducto]);
      }
      public function eliminar(){
            $sql = "DELETE FROM productos WHERE idproducto = ?";
            $affected = DB::delete($sql, [$this->idproducto]);
            //Puedo probar cambiando affected por return
      }
      public function insertar(){
            $sql = "INSERT INTO productos(
            nombre,
            descripcion,
            precio,
            imagen,
            fk_idcategoria
            ) VALUES (?, ?, ?, ?, ?)";
            $result = DB::insert($sql, [
                  $this->nombre,
                  $this->descripcion,
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
                  2 => 'A.descripcion',
                  3 => 'A.precio',
                  4 => 'A.imagen',
                  5 => 'A.fk_idcategoria'
            );
            $sql = "SELECT
            A.idproducto,
            A.nombre,
            A.descripcion,
            A.precio,
            A.imagen,
            A.fk_idcategoria,
            B.nombre AS nombre_categoria
            FROM productos A 
            INNER JOIN categoria B ON A.fk_idcategria = B.idcategoria
            WHERE 1=1";
            //Acá se hace el filtrado
            if(!empty($request['search']['value'])){
                  $sql .= " AND (A.nombre LIKE '%" . $request['search']['value'] . "%'";
                  $sql .= " OR A.descripcion LIKE '%" . $request['search']['value'] . "%'";
                  $sql .= " OR A.precio LIKE '%" . $request['search']['value'] . "%'";
                  $sql .= " OR A.imagen LIKE '%" . $request['search']['value'] . "%'";
                  $sql .= " OR B.nombre LIKE '%" . $request['search']['value'] . "%')";
            }
            $lstRetorno = DB::select($sql);
            return $lstRetorno;
      }
      public function existePedidoPorCategoria($idcategoria){
            $sql = "SELECT
            idproducto,
            nombre,
            descripcion,
            precio,
            imagen,
            fk_idcategoria
            FROM productos WHERE fk_idcategoria = ?";
            $lstRetorno = DB::select($sql, [$idcategoria]);
            if(count($lstRetorno)>0){
                  return true;
            }
            return false;
      }
}

?>