<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ville extends Model
{
    public function clients()
    {
        return $this->hasMany('App\Client');
    }
}
