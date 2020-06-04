<?php

namespace App\Http\Controllers;

use App\Product;
use App\Category;
use Cache;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $paginate = 6;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::pluck('title', 'id');
        return view('back.product.add', [
            'titlePage'     => 'Ajouter un produit',
            'categories'    => $categories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dump($request->all()); die;

        // pour les validations vous avez les rules
        $request->validate([
            'title'            => 'required',
            'description'      => 'required',
            'price'            => 'required',
            'category'         => 'required|integer',
            'size'             => 'required|in:46,48,50,52',
            'picture'          => 'required',
            'picture'          => 'required|image|max:3000',
            'status'           => 'required|in:published,unpublished',
            'code'             => 'required|in:new,soldes',
            'reference'        => 'required|integer',
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories = Category::pluck('title', 'id');
        return view('back.product.edit', [
            'titlePage'     => 'Editer un produit',
            'categories'    => $categories,
            'product'       => $product,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
