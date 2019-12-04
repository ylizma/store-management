<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->post('/logout','AuthController@logout');
Route::post('login','AuthController@login')->name('login');
Route::post('register','AuthController@register');


Route::get('produits','ProduitController@index');
Route::get('lproduits','ProduitController@getall');
Route::get('produit/{id}','ProduitController@show');
Route::post('produit','ProduitController@store');
Route::put('produit/{id}','ProduitController@edit');
Route::delete('produit/{id}','ProduitController@destroy');
Route::post('produit/search','ProduitController@search');
Route::post('produit/add','ProduitController@addquantity');


Route::get('categories','CategorieController@index');
Route::get('categorie/{id}','CategorieController@show');
Route::post('categorie','CategorieController@store');
Route::put('categorie/{id}','CategorieController@edit');
Route::delete('categorie/{id}','CategorieController@destroy');


Route::get('cmds','CmdproController@index');
Route::get('cmd/{id}','CmdProController@show');
Route::post('cmd','CmdProController@store');
Route::put('cmd','CmdProController@store');
Route::delete('cmd/{id}','CmdProController@destroy');


Route::get('clients','ClientController@index');
Route::get('lclients','ClientController@getall');
Route::get('client/{id}','ClientController@show');
Route::post('client','ClientController@store');
Route::put('client/{id}','ClientController@update');
Route::delete('client/{id}','ClientController@destroy');
Route::post('client/search','ClientController@search');

Route::get('villes','VilleController@index');

Route::get('lcmds','LignecmdController@index');
Route::get('lcmd/{id}','LignecmdController@show');
Route::post('lcmd','LignecmdController@store');
Route::put('lcmd','LignecmdController@store');
Route::delete('lcmd/{id}','LignecmdController@destroy');
Route::post('lcmd/search','LignecmdController@search');




Route::get('home','HomeController@index');
