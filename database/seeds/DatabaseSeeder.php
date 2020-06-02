<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Creation de 5 utilisateur à partir de la factory
        factory(App\User::class,3)->create();

        // Insérer les catégories 'Soldes', 'Homme' et 'Femme'
        App\Category::insert([
            [
                'title'         => 'Soldes',
                'description'   => 'Les soldes du moment',
            ],
            [
                'title'         => 'Homme',
                'description'   => 'Ce que nous vous proposons aux hommes',
            ],
            [
                'title'         => 'Femme',
                'description'   => 'Ce que nous vous proposons aux femmes',
            ]
        ]);
        
        // Création de produit
        factory(App\Product::class,30)->create();

    }
}
