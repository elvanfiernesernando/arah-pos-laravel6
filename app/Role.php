<?php

namespace App;

use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    public function company()
    {
        return $this->belongsTo('App\Company');
    }
}
