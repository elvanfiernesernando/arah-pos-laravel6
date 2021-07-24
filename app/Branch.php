<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $guarded = [];

    public function business_unit()
    {
        return $this->belongsTo('App\Business_unit');
    }

    public function users()
    {
        return $this->belongsToMany('App\User');
    }
}
