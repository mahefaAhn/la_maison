<?php

use Illuminate\Support\Facades\Route;

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

// Page d'accueil
Route::get('home', 'FrontController@index')->name('home');

// Récupérer la liste par catégorie
Route::get('category/{id}', 'FrontController@showProductByCategory')->name('show_productByCategory');

// Récupérer tous les articles soldés
Route::get('soldes/', 'FrontController@show_productSoldes')->name('show_productSoldes');


// routes sécurisées 
// Ajouter les routes de connexion, déconnexion : automatique
Auth::routes();
