<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\User; 
use Illuminate\Support\Facades\Auth; 
use Validator;

use App\Product;

class ApiController extends Controller
{
    public $successStatus = 200;

    /** 
     * login api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function login(){ 
        if(Auth::attempt([
            'email' => request('email'),
            'password' => request('password'),
            'status' => 1,
        ])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('ArahPOS')-> accessToken; 
            return response()->json(['success' => $success], $this-> successStatus); 
        } 
        else{ 
            return response()->json(['error'=>'Password Invalid / Inactive Users'], 401); 
        } 
    }

    public function getProducts()
    {
        $user_business_unit_id = userBusinessUnitId();
        $products = Product::inBusinessUnit($user_business_unit_id)->orderBy('created_at', 'DESC')->get();

        return response()->json([
            'products' => $products
        ], 200);
    }

    


}
