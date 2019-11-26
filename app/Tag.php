<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public function images(){
        return $this->morphedByMany('App\Image', 'taggable');
    }
}
