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
            return Product::where('status','=','published')->with('category')->paginate($this->paginate);
        });
        
        $nbProduct_homme = Product::where('category_id','=','1')->where('status','=','published')->count();
        $nbProduct_femme = Product::where('category_id','=','2')->where('status','=','published')->count();

        return view('front.index', [
            'products'          => $products,
            'titlePage'         => 'Liste de tous les produits',
            'nbProduct_homme'   => $nbProduct_homme,
            'nbProduct_femme'   => $nbProduct_femme,
        ]);
    }

    // Fonction pour afficher tous les produits soldés
    public function show_productSoldes(){
        $products = Product::where('code','=','solde')->where('status','=','published')->paginate($this->paginate);
        
        $nbProduct_homme = Product::where('category_id','=','1')->where('status','=','published')->where('code','=','solde')->count();
        $nbProduct_femme = Product::where('category_id','=','2')->where('status','=','published')->where('code','=','solde')->count();

        return view('front.index', [
            'products'      => $products,
            'titlePage'     => 'Liste de tous les produits soldés',
            'nbProduct_homme'   => $nbProduct_homme,
            'nbProduct_femme'   => $nbProduct_femme,
        ]);
    }

    // Fonction pour afficher les nouveaux articles
    public function show_productNew(){
        $products = Product::where('code','=','new')->where('status','=','published')->paginate($this->paginate);

        $nbProduct_homme = Product::where('category_id','=','1')->where('status','=','published')->where('code','=','new')->count();
        $nbProduct_femme = Product::where('category_id','=','2')->where('status','=','published')->where('code','=','new')->count();

        return view('front.index', [
            'products'      => $products,
            'titlePage'     => 'Liste de tous les nouveaux produits',
            'nbProduct_homme'   => $nbProduct_homme,
            'nbProduct_femme'   => $nbProduct_femme,
        ]);
    }

    // Fonction pour afficher les produits par catégories
    public function show_productByCategory(int $id){
        $category   = Category::find($id);
        $products   = $category->products()->where('status','=','published')->paginate($this->paginate);
        
        $nbProduct_homme = Product::where('category_id','=','1')->where('status','=','published')->with('category')->where('category_id','=',$id)->count();
        $nbProduct_femme = Product::where('category_id','=','2')->where('status','=','published')->with('category')->where('category_id','=',$id)->count();

        return view('front.index', [
            'products'      => $products,
            'titlePage'     => 'Liste de tous les produits pour '.$category->title.'s',
            'nbProduct_homme'   => $nbProduct_homme,
            'nbProduct_femme'   => $nbProduct_femme,
        ]);
    }

    // Fonction pour afficher les informations d'un produit
    public function show_product(int $id){
        $product = Product::with('category')->where('status','=','published')->find($id);

        return view('front.product', [
            'product'       => $product,
            'titlePage'     => $product->title,
        ]);
    }
}
