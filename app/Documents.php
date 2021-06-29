<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Documents extends Model
{
    protected $fillable=['file'];

    // public function post()
    // {
    //     return $this->belongsTo('App\Post', 'file');
    // }
}
