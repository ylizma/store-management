<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
	use SoftDeletes;
    public function lignecmds()
    {
        return $this->hasMany('App\Ligncmd');
    }

    public function ville()
    {
        return $this->belongsTo("App\Ville");
    }
}
