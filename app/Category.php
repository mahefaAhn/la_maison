<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // Une catégorie peut avoir un ou plusieurs produits
    public function products(){
        return $this->hasMany(Product::class);
    }
}
