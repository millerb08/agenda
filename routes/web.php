<?php

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

Route::get('/', function () {
    return view('welcome');
});

/**vista de creacion de contactos */
Route::get('/contactos/graficas', "ContactosController@graficas");

Route::get('/contactos/json', "ContactosController@json");


//Crea todas las rutas con las funciones del controlador
Route::resource('contactos', 'ContactosController');



Route::get('/home', 'HomeController@index')->name('home');

//Route::get('chartjs', 'HomeController@chartjs');

Auth::routes();



