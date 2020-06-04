<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// L'import du namespace
use App\Product;
use App\Category;
use Cache;

class FrontController extends Controller
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

    // Page d'accueil : avec la liste de tous les produits
    public function index(){
        $key = 'home' . ( request()->page ?? '1' );
        $minutes = 5 * 60;

        // pour nettoyer le cache on a la commande
        // php artisan cache:clear
        $products = Cache::remember( $key , $minutes, function(){
            return Product::with('category')->paginate($this->paginate);
        });

        return view('front.index', [
            'products'      => $products,
            'titlePage'     => 'Liste de tous les produits',
        ]);
    }

    // Fonction pour afficher tous les produits soldés
    public function show_productSoldes(){
        $products = Product::where('code','=','solde')->paginate($this->paginate);

        return view('front.index', [
            'products'      => $products,
            'titlePage'     => 'Liste de tous les produits soldés',
        ]);
    }

    // Fonction pour afficher les produits par catégories
    public function show_productByCategory(int $id){
        $category   = Category::find($id);
        $products   = $category->products()->paginate($this->paginate);

        return view('front.index', [
            'products'      => $products,
            'titlePage'     => 'Liste de tous les produits pour '.$category->title.'s',
        ]);
    }

    // Fonction pour afficher les informations d'un produit
    public function show_product(int $id){
        $product = Product::with('category')->find($id);

        return view('front.product', [
            'product'       => $product,
            'titlePage'     => $product->title,
        ]);
    }
}
