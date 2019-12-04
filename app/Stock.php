<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Stock extends Model
{
   use SoftDeletes;

   public function product()
    {
        return $this->belongsTo('App\Produit');
    }
    
}
