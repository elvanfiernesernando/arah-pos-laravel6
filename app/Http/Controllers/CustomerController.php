<?php

namespace App\Http\Controllers;

use App\Customer;

use Illuminate\Http\Request;

class CustomerController extends Controller
{

    // public function search(Request $request)
    // {
    //     $this->validate($request, [
    //         'customer_phone' => 'required|email'
    //     ]);
    // ​
    //     $customer = Customer::where('customer_phone', $request->customer_phone)->first();
    //     if ($customer) {
    //         return response()->json([
    //             'status' => 'success',
    //             'data' => $customer
    //         ], 200);
    //     }
    //     return response()->json([
    //         'status' => 'failed',
    //         'data' => []
    //     ]);
    // }
}
