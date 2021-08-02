<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Validator;
use App\User;
use App\Product;
use App\Role;

class UserController extends Controller
{
    public $successStatus = 200;

    public function login()
    {
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();
            if ($user->hasRole('Master') || $user->can('Access Mobile Apps')) {
                $success['token'] =  $user->createToken('ArahPOS')->accessToken;
                return response()->json(['success' => $success], $this->successStatus);
            } else {
                return response()->json(['error' => 'You do not have any of the necessary access rights'], 401);
            }
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('ArahPOS')->accessToken;
        $success['name'] =  $user->name;

        return response()->json(['success' => $success], $this->successStatus);
    }

    public function logout(Request $request)
    {
        $logout = $request->user()->token()->revoke();
        if ($logout) {
            return response()->json([
                'message' => 'Successfully logged out'
            ]);
        }
    }

    public function details()
    {
        $user = Auth::user();
        return response()->json(['success' => $user], $this->successStatus);
    }

    public function getProducts()
    {
        $user_business_unit_id = userBusinessUnitId();
        $products = Product::inBusinessUnit($user_business_unit_id)->orderBy('created_at', 'DESC')->get();

        return response()->json(
            $products,
            200
        );
    }
}
