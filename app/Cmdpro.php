<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cmdpro extends Model
{
    public function products()
    {
    	
        return $this->hasOne("App\Produit","id");
    }

   
    public function lignecmd()
    {
        return $this->belongsTo("App\Lignecmd");
    }
}
