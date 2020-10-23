<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    public function jumlah_comments()
    {
        return $this->hasMany('App\Comment');
    }
}
