<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    public function images(){
        return $this->belongsTo('App\Image');
    }
}
