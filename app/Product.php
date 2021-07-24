<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeInCompany($query, $companyId)
    {
        return $query->select('products.*')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->join('business_units', 'business_units.id', '=', 'categories.business_unit_id')
            ->join('companies', 'companies.id', '=', 'business_units.company_id')
            ->where('companies.id', $companyId);
    }

    public function scopeInBusinessUnit($query, $businessUnitId)
    {
        return $query->select('products.*')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->join('business_units', 'business_units.id', '=', 'categories.business_unit_id')
            ->where('business_units.id', $businessUnitId);
    }
}
