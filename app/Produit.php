<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produit extends Model
{
	use SoftDeletes;
    public function cmds()
    {
        return $this->belongsToMany("App\Cmdpro");
    }

    public function categorie()
    {
        return $this->belongsTo("App\Categorie");
    }

    public function stock()
    {
        return $this->hasOne("App\Stock");
    }
    
}
