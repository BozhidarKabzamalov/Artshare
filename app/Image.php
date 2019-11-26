<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    public function user(){
        return $this->belongsTo('App\User');
    }

    public function category(){
        return $this->belongsTo('App\Category');
    }

    public function likes(){
        return $this->hasMany('App\Like');
    }

    public function tags(){
        return $this->morphToMany('App\Tag', 'taggable');
    }

    public function comments(){
        return $this->hasMany('App\Comment');
    }
}
