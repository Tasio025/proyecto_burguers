<?php

namespace App\Http\Controllers;

use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\Usuario;
use Session;

class ControladorWebHome extends Controller
{
    public function index()
    {
            return view("web.index");   //Esto nos devolvera el index.blade.php(el incex de la plantilla) pero hay que armarlo xq aparece todo roto
    }
}
?>