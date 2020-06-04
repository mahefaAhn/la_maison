<?php

use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insérer les catégories 'Soldes', 'Homme' et 'Femme'
        App\Category::insert([
            [
                'title'         => 'Homme',
                'description'   => 'Ce que nous vous proposons aux hommes',
            ],
            [
                'title'         => 'Femme',
                'description'   => 'Ce que nous vous proposons aux femmes',
            ]
        ]);

        // Supprimer toutes les images si elles existent dans le dossier images
        // Storage::disk('local')->delete( Storage::allFiles() );

        // Création de produit
        factory(App\Product::class,30)->create()->each(function($product){
            // Liaison avec la catégorie
                $category_name  = ["Homme","Femme"];
                // Récupérer l'id de la catégorie
                $category          = App\Category::where('title', $category_name[rand(0,1)])->first();
                // Association
                $product->category()->associate($category);
                    // Repertoire initial des test
                    $file_fake_image   = '/fake';
                if($product->category->title==="Homme")        $file_fake_image   .= '/hommes';
                else if($product->category->title==="Femme")   $file_fake_image   .= '/femmes';
                    // Récupération d'un fichier au hasard
                    $file_image = array_slice(Storage::files($file_fake_image),1); // On n'inclut pas thumbs.db
                    // Nom de l'image
                    $image_name = Str::random(40).'.jpeg';
                    // Copie une image choisie au hasard dans le dossier
                    Storage::copy($file_image[rand(0, count($file_image)-1)],$image_name);
                    // Attribuer l'image au produit
                    $product->url_image = $image_name;
                    $product->save();
        });
    }
}
