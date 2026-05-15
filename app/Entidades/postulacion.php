<?php

namespace App\Entidades;

use DB;
use Illuminate\Database\Eloquent\Model;

      class Postulacion extends Model{

      protected $table = 'postulaciones';
      public $timestamps = false;
      protected $fillable = ['idpostulacion', 'nombre', 'apellido', 'celular', 'correo', 'CV'];
      protected $hidden = [];

      public function cargarDesdeRequest($request){
            $this->idpostulacion = $request->input('idpostulacion') != "0" ? $request->input('idpostulacion') : $this->idpostulacion;
            $this->nombre = $request->input('txtNombre');
            $this->apellido = $request->input('txtApellido');
            $this->celular = $request->input('txtCelular');
            $this->correo = $request->input('txtCorreo');
            $this->CV = $request->input('txtCV');
      }
      public function obtenerTodos(){
            $sql = "SELECT
                  idpostulacion,
                  nombre,
                  apellido,
                  celular,
                  correo,
                  CV
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
                  correo,
                  CV
                  FROM postulaciones WHERE idpostulacion = ?";
                  $lstRetorno = DB::select($sql, [$idpostulacion]);
                  if(count($lstRetorno)> 0){
                        $this->idpostulacion = $lstRetorno[0]->idpostulacion;
                        $this->nombre = $lstRetorno[0]->nombre;
                        $this->apellido = $lstRetorno[0]->apellido;
                        $this->celular = $lstRetorno[0]->celular;
                        $this->correo = $lstRetorno[0]->correo;
                        $this->CV = $lstRetorno[0]->CV;
                        return $this;
                  }
                  return null;
            }
            public function guardar(){
                  $sql = "UPDATE postulaciones SET
                  nombre = '$this->nombre',
                  apellido = '$this->apellido',
                  celular = '$this->celular',
                  correo = '$this->correo',
                  CV = '$this->CV'
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
                        correo,
                        CV
                  ) VALUES (?,?,?,?,?)";
                  $result = DB::insert($sql, [
                        $this->nombre,
                        $this->apellido,
                        $this->celular,
                        $this->correo,
                        $this->CV
                  ]);
                  return $this->idpostulacion = DB::getPdo()->lastInsertId();
            }
            public function obtenerFiltrado(){
                  $request = $_REQUEST;
                  $columns = array(
                        0 => 'idpostulacion',
                        1 => 'nombre',
                        2 => 'apellido',
                        3 => 'celular',
                        4 => 'correo',
                        5 => 'CV'
                  );
                  $sql ="SELECT
                  idpostulacion,
                  nombre,
                  apellido,
                  celular,
                  correo,
                  CV
                  FROM postulaciones WHERE 1=1";
                  //filtrado
                  if(!empty($request['search']['value'])){ 
                        $sql .= " AND (nombre like '%" . $request['search']['value'] . "%' ";
                        $sql .= " OR apellido like '%" . $request['search']['value'] . "%' ";
                        $sql .= " OR celular like '%" . $request['search']['value'] . "%' ";
                        $sql .= " OR correo like '%" . $request['search']['value'] . "%' ";
                        $sql .= " OR CV like '%" . $request['search']['value'] . "%' )";
                  }
                  $lstRetorno = DB::select($sql);
                  return $lstRetorno;
            }
      }  

?>