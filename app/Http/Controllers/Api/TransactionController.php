<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;

class TransactionController extends Controller
{
    public function getProducts()
    {
        $user_business_unit_id = userBusinessUnitId();
        $products = Product::inBusinessUnit($user_business_unit_id)->orderBy('created_at', 'DESC')->with('category')->get();

        return response()->json([
            'products' => $products
        ]);
    }
}
