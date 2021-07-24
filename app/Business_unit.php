<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Business_unit extends Model
{
    protected $guarded = [];

    public function company()
    {
        return $this->belongsTo('App\Company');
    }

    public function branches()
    {
        return $this->hasMany('App\Branch');
    }

    public function categories()
    {
        return $this->hasMany('App\Category');
    }
}
