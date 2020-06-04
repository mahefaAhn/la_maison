<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // Un produit possède une catégorie ou plus
    public function category(){
        return $this->belongsTo(Category::class);
    }
}
