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
Route::get('/', 'FrontController@index')->name('home');

// Récupérer la liste par catégorie
Route::get('category/{id}', 'FrontController@show_productByCategory')->name('show_productByCategory');

// Récupérer tous les articles soldés
Route::get('soldes/', 'FrontController@show_productSoldes')->name('show_productSoldes');

// Récupérer les informations d'un produit
Route::get('product_info/{id}', 'FrontController@show_product')->name('show_product');

// routes sécurisées 
// Ajouter les routes de connexion, déconnexion : automatique
Auth::routes();

// BACK OFFICE
// Tableau de bord
Route::get('admin', 'ProductController@index')->name('admin')->middleware('auth');

// On connecte l'ensemble des routes à nos actions du controller de resource ProductController
Route::resource('admin/product', 'ProductController')->middleware('auth');