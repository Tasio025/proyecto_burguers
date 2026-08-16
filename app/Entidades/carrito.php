<?php

      namespace App\Entidades;

      use DB;
      use Illuminate\Database\Eloquent\Model;

      class Carrito extends Model{

      protected $table = 'carritos';
      public $timestamps = false;
      
      protected $fillable = [ 'idcarritos', 'cantidad', 'fk_idcliente', 'fk_idproductos'];

      protected $hidden = [];

      private $producto;
      private $precio;
      private $cantidad;

      public function obtenerTodos(){
            $sql = "SELECT
                  idcarritos,
                  cantidad,
                  fk_idcliente,
                  fk_idproductos
                  FROM carritos ORDER BY idcarritos ASC";
                  $lstRetorno = DB::select($sql);
                  return $lstRetorno;
      }
      public function obtenerPorId($idcarritos){
            $sql = "SELECT
            idcarritos,
            cantidad,
            fk_idcliente,
            fk_idproductos
            FROM carritos WHERE idcarritos = ?";
            $lstRetorno = DB::select($sql, [$idcarritos]);

            if(count($lstRetorno)> 0){
                  $this->idcarritos = $lstRetorno[0]->idcarritos;
                  $this->cantidad = $lstRetorno[0]->cantidad;
                  $this->fk_idcliente = $lstRetorno[0]->fk_idcliente;
                  $this->fk_idproductos = $lstRetorno[0]->fk_idproductos;
                  return $this;
            }
            return null;
      }
      public function obtenerPorCliente($idcliente){
            $sql = "SELECT
            A.idcarritos,
            A.cantidad,
            A.fk_idcliente,
            A.fk_idproductos,
            B.nombre AS producto,
            B.precio AS precio,
            B.imagen AS imagen
            FROM carritos A
            INNER JOIN productos B ON A.fk_idproductos = B.idproducto
            WHERE fk_idcliente = ?";
            $lstRetorno = DB::select($sql, [$idcliente]);
            return $lstRetorno;
      }
      public function cargarDesdeRequest($request){
            $this->idcarritos = $request->input('idcarritos');
            $this->cantidad = $request->input('cantidad');
            $this->fk_idcliente = $request->input('fk_idcliente');
            $this->fk_idproductos = $request->input('fk_idproductos');
      }
      public function guardar(){
            $sql = "UPDATE carritos SET
            cantidad = ?,
            fk_idcliente = ?,
            fk_idproductos = ?
            WHERE idcarritos = ?";
            $affected = DB::update($sql, [
                  $this->cantidad,
                  $this->fk_idcliente,
                  $this->fk_idproductos,
                  $this->idcarritos
            ]);
      }
      public function eliminar(){
            $sql = "DELETE FROM carritos WHERE idcarritos = $this->idcarritos";
            $affected = DB::delete($sql);
      }
      public function insertar(){
            $sql = "INSERT INTO carritos(
            cantidad,
            fk_idcliente,
            fk_idproductos
            ) VALUES (?, ?, ?)";
            $result = DB::insert($sql, [
                  $this->cantidad,
                  $this->fk_idcliente,
                  $this->fk_idproductos
            ]);
            return $this->idcarritos = DB::getPdo()->lastInsertId();
      }
      //REVISAR ESTA FUNCIÓN
      public function agregarProducto($idproducto, $idcliente, $cantidad){
            $sql = "SELECT idcarritos, cantidad FROM carritos WHERE fk_idcliente = ? AND fk_idproductos = ?";
            $existente = DB::select($sql, [$idcliente, $idproducto]);
            if(count($existente) > 0){
                  //Ya tiene ese producto en el carrito, suma una cantidad nueva
                  $nuevaCantidad = $existente[0]->cantidad + $cantidad;
                  DB::update("UPDATE carritos SET cantidad = ? WHERE idcarritos = ?", [$nuevaCantidad, $existente[0]->idcarritos]);
            }else{
                  //Primera vez que se agrega este producto => insertamos nueva fila
                  DB::insert("INSERT INTO carritos(cantidad, fk_idcliente, fk_idproductos) VALUES (?,?,?)",
                  [$cantidad, $idcliente, $idproducto]);
            }
      }
}

?>