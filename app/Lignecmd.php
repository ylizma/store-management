<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lignecmd extends Model
{
	use SoftDeletes;
    public function produits()
    {
        return $this->belongsToMany("App\Produit")->withPivot('quantity')->withTimestamps();
    }

    public function client()
    {
        return $this->belongsTo("App\Client");
    }

}
