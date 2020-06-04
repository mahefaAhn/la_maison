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

        return view('back.product.index', [
            'products'      => $products,
            'titlePage'     => 'Liste de tous les produits',
        ]);
    }

    public function store_product (Request $request) {
        dump($request->all()); die;

        // pour les validations vous avez les rules
        $request->validate([
            'title'            => 'required',
            'description'      => 'required',
            'price'            => 'float',
            'category'         => 'integer',
            'size'             => 'in:46,48,50,52',
            'picture'          => 'image|max:3000',
            'status'           => 'in:published,unpublished',
            'code'             => 'in:new,soldes',
            'reference'        => 'integer',
        ]);


        // insérer les données en base il faut préciser cela dans les fillables
        $product = Product::create($request->all());
        // une fois le produit créé en base de données Laravel crée un objet produit
        // la méthode category()->attach permet d'associer dans la relation many to many des auteurs pour ce livre
        $product->category()->attach($request->category);

        if ($request->file('picture')) {
            // enregistre dans le store l'image et en même temps on récupère le
            // nom de l'image créé par Laravel, nom sécurisé
            // 1. Pas d'écrasement d'image avec le même nom.
            // 2. Pas d'injection de script dans le nom de l'image.
            $link = $request->file('picture')->store('');

            // créer une resource dans la table pictures
            $product->picture = $link;
        }

        Cache::flush();

        // with permet de créer un flash message enregistrer dans la classe Session clé/valeur :
        /*
        return redirect()->route('book.index')->with('message', [
            'type' => 'alert-success',
            'content' => 'success create book'
        ]);
        */
    }
