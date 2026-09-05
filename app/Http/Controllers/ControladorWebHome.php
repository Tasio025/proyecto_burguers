<?php

namespace App\Http\Controllers;

use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sucursal;
use Session;

class ControladorWebHome extends Controller
{
    public function index()
    {
        $sucursal = new Sucursal();
        $aSucursales = $sucursal->obtenerTodos();
        return view("web.index", compact('aSucursales'));
        //Esto nos devolvera el index.blade.php(el incex de la plantilla) pero hay que armarlo xq aparece todo roto
    }
}
?>