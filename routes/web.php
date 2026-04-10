<?php
 //use Carbon\Carbon; 
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

/*Route::get('/time' , function(){$date =new Carbon;echo $date ; } );*/

use Illuminate\Support\Facades\Route;

Route::group(array('domain' => '127.0.0.1'), function () {

    Route::get('/', 'ControladorWebHome@index');
 

    Route::get('/admin', 'ControladorHome@index');
    Route::post('/admin/patente/nuevo', 'ControladorPatente@guardar');

/* --------------------------------------------- */
/* CONTROLADOR LOGIN                           */
/* --------------------------------------------- */
    Route::get('/admin/login', 'ControladorLogin@index');
    Route::get('/admin/logout', 'ControladorLogin@logout');
    Route::post('/admin/logout', 'ControladorLogin@entrar');
    Route::post('/admin/login', 'ControladorLogin@entrar');

/* --------------------------------------------- */
/* CONTROLADOR RECUPERO CLAVE                    */
/* --------------------------------------------- */
    Route::get('/admin/recupero-clave', 'ControladorRecuperoClave@index');
    Route::post('/admin/recupero-clave', 'ControladorRecuperoClave@recuperar');

/* --------------------------------------------- */
/* CONTROLADOR PERMISO                           */
/* --------------------------------------------- */
    Route::get('/admin/usuarios/cargarGrillaFamiliaDisponibles', 'ControladorPermiso@cargarGrillaFamiliaDisponibles')->name('usuarios.cargarGrillaFamiliaDisponibles');
    Route::get('/admin/usuarios/cargarGrillaFamiliasDelUsuario', 'ControladorPermiso@cargarGrillaFamiliasDelUsuario')->name('usuarios.cargarGrillaFamiliasDelUsuario');
    Route::get('/admin/permisos', 'ControladorPermiso@index');
    Route::get('/admin/permisos/cargarGrilla', 'ControladorPermiso@cargarGrilla')->name('permiso.cargarGrilla');
    Route::get('/admin/permiso/nuevo', 'ControladorPermiso@nuevo');
    Route::get('/admin/permiso/cargarGrillaPatentesPorFamilia', 'ControladorPermiso@cargarGrillaPatentesPorFamilia')->name('permiso.cargarGrillaPatentesPorFamilia');
    Route::get('/admin/permiso/cargarGrillaPatentesDisponibles', 'ControladorPermiso@cargarGrillaPatentesDisponibles')->name('permiso.cargarGrillaPatentesDisponibles');
    Route::get('/admin/permiso/{idpermiso}', 'ControladorPermiso@editar');
    Route::post('/admin/permiso/{idpermiso}', 'ControladorPermiso@guardar');

/* --------------------------------------------- */
/* CONTROLADOR GRUPO                             */
/* --------------------------------------------- */
    Route::get('/admin/grupos', 'ControladorGrupo@index');
    Route::get('/admin/usuarios/cargarGrillaGruposDelUsuario', 'ControladorGrupo@cargarGrillaGruposDelUsuario')->name('usuarios.cargarGrillaGruposDelUsuario'); //otra cosa
    Route::get('/admin/usuarios/cargarGrillaGruposDisponibles', 'ControladorGrupo@cargarGrillaGruposDisponibles')->name('usuarios.cargarGrillaGruposDisponibles'); //otra cosa
    Route::get('/admin/grupos/cargarGrilla', 'ControladorGrupo@cargarGrilla')->name('grupo.cargarGrilla');
    Route::get('/admin/grupo/nuevo', 'ControladorGrupo@nuevo');
    Route::get('/admin/grupo/setearGrupo', 'ControladorGrupo@setearGrupo');
    Route::post('/admin/grupo/nuevo', 'ControladorGrupo@guardar');
    Route::get('/admin/grupo/{idgrupo}', 'ControladorGrupo@editar');
    Route::post('/admin/grupo/{idgrupo}', 'ControladorGrupo@guardar');

/* --------------------------------------------- */
/* CONTROLADOR USUARIO                           */
/* --------------------------------------------- */
    Route::get('/admin/usuarios', 'ControladorUsuario@index');
    Route::get('/admin/usuarios/nuevo', 'ControladorUsuario@nuevo');
    Route::post('/admin/usuarios/nuevo', 'ControladorUsuario@guardar');
    Route::post('/admin/usuarios/{usuario}', 'ControladorUsuario@guardar');
    Route::get('/admin/usuarios/cargarGrilla', 'ControladorUsuario@cargarGrilla')->name('usuarios.cargarGrilla');
    Route::get('/admin/usuarios/buscarUsuario', 'ControladorUsuario@buscarUsuario');
    Route::get('/admin/usuarios/{usuario}', 'ControladorUsuario@editar');

/* --------------------------------------------- */
/* CONTROLADOR MENU                             */
/* --------------------------------------------- */
    Route::get('/admin/sistema/menu', 'ControladorMenu@index');
    Route::get('/admin/sistema/menu/nuevo', 'ControladorMenu@nuevo');
    Route::post('/admin/sistema/menu/nuevo', 'ControladorMenu@guardar');
    Route::get('/admin/sistema/menu/cargarGrilla', 'ControladorMenu@cargarGrilla')->name('menu.cargarGrilla');
    Route::get('/admin/sistema/menu/eliminar', 'ControladorMenu@eliminar');
    Route::get('/admin/sistema/menu/{id}', 'ControladorMenu@editar');
    Route::post('/admin/sistema/menu/{id}', 'ControladorMenu@guardar');

});

/* --------------------------------------------- */
/* CONTROLADOR PATENTES                          */
/* --------------------------------------------- */
Route::get('/admin/patentes', 'ControladorPatente@index');
Route::get('/admin/patente/nuevo', 'ControladorPatente@nuevo');
Route::post('/admin/patente/nuevo', 'ControladorPatente@guardar');
Route::get('/admin/patente/cargarGrilla', 'ControladorPatente@cargarGrilla')->name('patente.cargarGrilla');
Route::get('/admin/patente/eliminar', 'ControladorPatente@eliminar');
Route::get('/admin/patente/nuevo/{id}', 'ControladorPatente@editar');
Route::post('/admin/patente/nuevo/{id}', 'ControladorPatente@guardar');


/* --------------------------------------------- */
/* CONTROLADOR CLIENTE                           */
/* --------------------------------------------- */
//Rutas de formulario
Route::get('/admin/clientes/nuevo', 'ControladorCliente@nuevo');
Route::get('/admin/cliente/nuevo', 'ControladorCliente@nuevo');
Route::get('/admin/sistema/clientes/nuevo', 'ControladorCliente@nuevo');
Route::post('/admin/cliente/nuevo', 'ControladorCliente@guardar');
//Rutas del listado
Route::get('/admin/clientes', 'ControladorCliente@index');
Route::get('/admin/clientes/cargarGrilla', 'ControladorCliente@cargarGrilla')->name('cliente.cargarGrilla');


/* --------------------------------------------- */
/* CONTROLADOR PRODUCTOS                           */
/* --------------------------------------------- */
//Rutas de formulario
Route::get('/admin/productos/nuevo', 'ControladorProducto@nuevo');
Route::get('/admin/producto/nuevo', 'ControladorProducto@nuevo');
Route::get('/admin/sistema/productos/nuevo', 'ControladorProducto@nuevo');
Route::post('/admin/producto/nuevo', 'ControladorProducto@guardar');
//Rutas de listado
Route::get('/admin/productos', 'ControladorProducto@index');
Route::get('/admin/productos/cargarGrilla', 'ControladorProducto@cargarGrilla')->name('producto.cargarGrilla');

/* --------------------------------------------- */
/* CONTROLADOR PEDIDOS                           */
/* --------------------------------------------- */
//Rutas de formulario
Route::get('/admin/pedidos/nuevo', 'ControladorPedido@nuevo');
Route::get('/admin/pedido/nuevo', 'ControladorPedido@nuevo');
Route::get('/admin/sistema/pedidos/nuevo', 'ControladorPedido@nuevo');
Route::post('/admin/pedido/nuevo', 'ControladorPedido@guardar');
//Rutas del listado
Route::get('/admin/pedidos', 'ControladorPedido@index');
Route::get('/admin/pedidos/cargarGrilla', 'ControladorPedido@cargarGrilla')->name('pedido.cargarGrilla');


/* --------------------------------------------- */
/* CONTROLADOR POSTULAICONES                           */
/* --------------------------------------------- */
//Rutas de formulario
Route::get('/admin/postulaciones/nuevo', 'ControladorPostulacion@nuevo');
Route::get('/admin/postulacion/nuevo', 'ControladorPostulacion@nuevo');
Route::get('/admin/sistema/postulaciones/nuevo', 'ControladorPostulacion@nuevo');
Route::post('/admin/postulacion/nuevo', 'ControladorPostulacion@guardar');
//Rutas del listado
Route::get('/admin/postulaciones', 'ControladorPostulacion@index');
Route::get('/admin/postulaciones/cargarGrilla', 'ControladorPostulacion@cargarGrilla')->name('postulacion.cargarGrilla');

/* --------------------------------------------- */
/* CONTROLADOR CATEGORÍAS                           */
/* --------------------------------------------- */
//Rutas de forulario
Route::get('/admin/categorias/nuevo', 'ControladorCategoria@nuevo');
Route::get('/admin/categoria/nuevo', 'ControladorCategoria@nuevo');
Route::get('/admin/sistema/categorias/nuevo', 'ControladorCategoria@nuevo');
Route::post('/admin/categoria/nuevo', 'ControladorCategoria@guardar');
//Rutas del listado
Route::get('/admin/categorias', 'ControladorCategoria@index');
Route::get('/admin/categorias/cargarGrilla', 'ControladorCategoria@cargarGrilla')->name('categoria.cargarGrilla');


/* --------------------------------------------- */
/* CONTROLADOR SUCURSALES                           */
/* --------------------------------------------- */
//Rutas de formulario
Route::get('/admin/sucursales/nuevo', 'ControladorSucursal@nuevo');
Route::get('/admin/sucursal/nuevo', 'ControladorSucursal@nuevo');
Route::get('/admin/sistema/sucursales/nuevo', 'ControladorSucursal@nuevo');
Route::post('/admin/sucursal/nuevo', 'ControladorSucursal@guardar');
//Rutas del listado
Route::get('/admin/sucursales', 'ControladorSucursal@index');
Route::get('/admin/sucursales/cargarGrilla', 'ControladorSucursal@cargarGrilla')->name('sucursal.cargarGrilla');

/* --------------------------------------------- */
/* CONTROLADOR PROVEEDORES                           */
/* --------------------------------------------- */
//Rutas de formulario
Route::get('/admin/proveedores/nuevo', 'ControladorProveedor@nuevo');
Route::get('/admin/proveedor/nuevo', 'ControladorProveedor@nuevo');
Route::get('/admin/sistema/proveedores/nuevo', 'ControladorProveedor@nuevo');
Route::post('/admin/proveedor/nuevo', 'ControladorProveedor@guardar');
//Rutas del listado
Route::get('/admin/proveedores', 'ControladorProveedor@index');
Route::get('/admin/proveedores/cargarGrilla', 'ControladorProveedor@cargarGrilla')->name('proveedor.cargarGrilla');

/* --------------------------------------------- */
/* CONTROLADOR RUBROS                           */
/* --------------------------------------------- */
//Rutas de formulario
Route::get('/admin/rubros/nuevo', 'ControladorRubro@nuevo');
Route::get('/admin/rubro/nuevo', 'ControladorRubro@nuevo');
Route::get('/admin/sistema/rubros/nuevo', 'ControladorRubro@nuevo');
Route::post('/admin/rubro/nuevo', 'ControladorRubro@guardar');
//Rutas del listado
Route::get('/admin/rubros', 'ControladorRubro@index');
Route::get('/admin/rubros/cargarGrilla', 'ControladorRubro@cargarGrilla')->name('rubro.cargarGrilla');
 
?>