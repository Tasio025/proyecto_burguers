<?php

namespace App\Entidades;

use DB;
use Illuminate\Database\Eloquent\Model;

      class Producto extends Model{

      protected $table = 'productos';
      public $timestamps = false;
      protected $fillable = ['idproducto', 'nombre', 'cantidad', 'precio', 'imagen', 'fk_idcategoria', 'descripcion', 'titulo'];
      protected $hidden = [];

      public function obtenerTodos(){
            $sql = "SELECT
                  idproducto,
                  nombre,
                  cantidad,
                  precio,
                  imagen,
                  fk_idcategoria,
                  descripcion,
                  titulo
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
            fk_idcategoria,
            descripcion,
            titulo
            FROM productos WHERE idproducto = $idproducto";
            $lstRetorno = DB::select($sql, [$idproducto]);
            return $lstRetorno;

            if(count($lstRetorno)> 0){
                  $this->idproducto = $lstRetorno[0]->idproducto;
                  $this->nombre = $lstRetorno[0]->nombre;
                  $this->cantidad = $lstRetorno[0]->cantidad;
                  $this->precio = $lstRetorno[0]->precio;
                  $this->imagen = $lstRetorno[0]->imagen;
                  $this->fk_idcategoria = $lstRetorno[0]->fk_idcategoria;
                  $this->descripcion = $lstRetorno[0]->descripcion;
                  $this->titulo = $lstRetorno[0]->titulo;
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
            fk_idcategoria,
            descripcion,
            titulo
            FROM productos WHERE fk_idcategoria = $idTipoProducto";
            $lstRetorno = DB::select($sql, [$idTipoProducto]);

      }
      public function guardar(){
            $sql = "UPDATE productos SET
            nombre = '$this->nombre',
            cantidad = $this->cantidad,
            precio = $this->precio,
            imagen = '$this->imagen',
            fk_idcategoria = $this->fk_idcategoria,
            descripcion = '$this->descripcion',
            titulo = '$this->titulo'
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
            fk_idcategoria,
            descripcion,
            titulo
            ) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $result = DB::insert($sql, [
                  $this->nombre,
                  $this->cantidad,
                  $this->precio,
                  $this->imagen,
                  $this->fk_idcategoria,
                  $this->descripcion,
                  $this->titulo
            ]);
            return $result;
      }
}

?>