<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;
use Faker\Factory as Factory;

$factory->define(Product::class, function (Faker $faker) {
    // alias pour configurer en français
    $faker =  Factory::create('fr_FR');

    return [
        'title'         => $faker->sentence(3),
        'description'   => $faker->paragraph(),
        'price'         => $faker->randomFloat(2,0,250),
        'size'          => $faker->randomElement(['46','48','50','52']),
        'url_image'     => 'https://picsum.photos/id/'.rand(1, 100).'/200/300',
        'status'        => $faker->randomElement(['published','unpublished']),
        'code'          => $faker->randomElement(['solde','new']),
        'code'          => $faker->randomElement(['solde','new']),
        'reference'     => $faker->ean13()
    ];
});
