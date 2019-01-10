<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function images(){
        return $this->belongsTo('App\Image');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }
}
