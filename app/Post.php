<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';
    
    
    public function user()
    {
        return $this->belongsTo('App\User', 'userId');
    }

    public function post()
    {
        return $this->belongsTo('App\Post', 'published');
    }

    public function document()
    {
        return $this->belongsTo('App\Documents', 'file');
    }
}
