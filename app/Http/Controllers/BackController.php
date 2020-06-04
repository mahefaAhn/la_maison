<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// L'import du namespace
use App\Product;
use App\Category;
use Cache;

class BackController extends Controller
{
    private $paginate = 6;

    public function __construct()
    {
        // On remet ici les catégories pour le menu dans le master.blade.php (layout)
        view()->composer('partials.menu', function ($view) {
            $categories = Category::pluck('title', 'id');
            $view->with('categories', $categories);
        });
    }

    // Page d'accueil : tableau de bord
    public function dashboard(){
        $key = 'home' . ( request()->page ?? '1' );
        $minutes = 5 * 60;

        // pour nettoyer le cache on a la commande
        // php artisan cache:clear
        $products = Cache::remember( $key , $minutes, function(){
            return Product::with('category')->paginate($this->paginate);
        });

        return view('back.index', [
            'products'      => $products,
            'titlePage'     => 'Liste de tous les produits',
        ]);
    }

    // Page pour ajouter un produit
    public function add_product(){
        $key = 'home' . ( request()->page ?? '1' );
        $minutes = 5 * 60;

        // pour nettoyer le cache on a la commande
        // php artisan cache:clear
        $products = Cache::remember( $key , $minutes, function(){
            return Product::with('category')->paginate($this->paginate);
        });

        return view('back.index', [
            'products'      => $products,
            'titlePage'     => 'Liste de tous les produits',
        ]);
    }
    
    // Page pour modifier un produit
    public function update_product(){
        $key = 'home' . ( request()->page ?? '1' );
        $minutes = 5 * 60;

        // pour nettoyer le cache on a la commande
        // php artisan cache:clear
        $products = Cache::remember( $key , $minutes, function(){
            return Product::with('category')->paginate($this->paginate);
        });

        return view('back.index', [
            'products'      => $products,
            'titlePage'     => 'Liste de tous les produits',
        ]);
    }
}
