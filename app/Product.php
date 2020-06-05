<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'title'         ,
        'description'   ,
        'price'         ,
        'size'          ,
        'status'        ,
        'code'          ,
        'reference'     ,
        'category_id'   ,
        'url_image'     ,
    ];

    
    // Un produit possède une catégorie ou plus
    public function category(){
        return $this->belongsTo(Category::class);
    }

    // Fonction pour transformer les données de la taille en tableau
    public function getSizeArray(){
        $sizeString = $this->size;
        $array    = explode(',',(explode(']',(explode('[',$sizeString)[1]))[0]));
        array_multisort($array);
        return $array;
    }
}
