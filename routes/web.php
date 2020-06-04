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

// Page d'accueil
Route::get('/', 'FrontController@index');
Route::get('home', 'FrontController@index')->name('home');

// Récupérer la liste par catégorie
Route::get('category/{id}', 'FrontController@show_productByCategory')->name('show_productByCategory');

// Récupérer tous les articles soldés
Route::get('soldes/', 'FrontController@show_productSoldes')->name('show_productSoldes');

// Récupérer les informations d'un produit
Route::get('product/{id}', 'FrontController@show_product')->name('show_product');

// routes sécurisées 
// Ajouter les routes de connexion, déconnexion : automatique
Auth::routes();

// BACK OFFICE
// Tableau de bord
Route::get('admin', 'BackController@dashboard')->name('dashboard')->middleware('auth');
// Ajouter un produit
Route::get('add_product', 'BackController@add_product')->name('add_product')->middleware('auth');
// Modifier les informations d'un produit
Route::get('update_product/{id}', 'BackController@update_product')->name('update_product')->middleware('auth');