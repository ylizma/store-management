<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Categorie extends Model
{
	use SoftDeletes;
    public function produits()
    {
        return $this->hasMany("App\Produit","categorie_id","id");
    }
}