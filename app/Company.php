<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $guarded = [];

    public function business_units()
    {
        return $this->hasMany('App\Business_unit');
    }

    public function roles()
    {
        return $this->hasMany('App\Role');
    }
}
