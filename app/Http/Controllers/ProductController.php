<?php

namespace App\Http\Controllers;

use App\Product;
use App\Category;
use Cache;
use Storage;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $paginate = 10;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // pour nettoyer le cache on a la commande
        // php artisan cache:clear
        $products = Product::with('category')->paginate($this->paginate);

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
        // pour les validations vous avez les rules
        $request->validate([
            'title'            => 'required',
            'description'      => 'required',
            'price'            => 'required',
            'category_id'      => 'required|integer',
            'size'             => 'required',
            'picture'          => 'required|image|max:3000',
            'status'           => 'required|in:published,unpublished',
            'code'             => 'required|in:new,solde',
            'reference'        => 'required|integer',
        ]);

        // Formater les tailles 
        $newSizeValue           = '['.implode(',',$request->size).']';

        // Modifier la valeur de la taille dans request
        $requestData            = $request->all();
        $requestData['size']    = $newSizeValue;

        // insérer les données en base il faut préciser cela dans les fillables
        $product = Product::create($requestData);

        if ($request->file('picture')) {
            $link               = $request->file('picture')->store('');
            $product->url_image = $link;
            $product->save();
        }

        Cache::flush();

        // with permet de créer un flash message enregistrer dans la classe Session clé/valeur :
        return redirect()->route('product.index');
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

        // pour les validations vous avez les rules
        $request->validate([
            'title'            => 'required',
            'description'      => 'required',
            'price'            => 'required',
            'category_id'      => 'required|integer',
            'size'             => 'required',
            'picture'          => 'image|max:3000',
            'status'           => 'required|in:published,unpublished',
            'code'             => 'required|in:new,solde',
            'reference'        => 'required|integer',
        ]);

        // Formater les tailles 
        $newSizeValue           = '['.implode(',',$request->size).']';

        // Modifier la valeur de la taille dans request
        $requestData            = $request->all();
        $requestData['size']    = $newSizeValue;

        // insérer les données en base il faut préciser cela dans les fillables
        $product->update($requestData);

        if ($request->delete_picture) {
            $this->deletePicture($product);
        }
        if ($request->picture) {
            $link               = $request->file('picture')->store('');
            $product->url_image = $link;
            $product->save();
        }

        Cache::flush();
        
        return redirect()->route('product.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        if ($product->url_image) {
            // on supprime physiquement l'image
            Storage::disk('local')->delete($product->url_image);
        }

        $product->delete();

        Cache::flush();

        return redirect()->route('product.index');
    }

    /**
     * Remove picture
     * 
     * @param  Product $product
     * @return void
     */
    private function deletePicture($product):void
    {
        if ($product->url_image) {
            Storage::disk('local')->delete($product->url_image);
        }
    }

    /**
     * upload image 
     * 
     * @param  Product $product
     * @param  Request $request
     * @return void
     */
    private function uploadPicture($product, $request):void{

            $this->deletePicture($product);
            // enregistre dans le store l'image et en même temps on récupère le
            // nom de l'image créé par Laravel, nom sécurisé
            // 1. Pas d'écrasement d'image avec le même nom.
            // 2. Pas d'injection de script dans le nom de l'image.
            $link               = $request->file('picture')->store('');
            $product->url_image = $link;
            $product->save();
    }
}
