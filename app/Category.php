<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];

    public function business_unit()
    {
        return $this->belongsTo('App\Business_unit');
    }

    public function products()
    {
        return $this->hasMany('App\Product');
    }
}
