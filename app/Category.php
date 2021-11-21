<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = "categories";

    public function news() {
        return $this->hasMany('App\News', 'category_id');
    }
}
