<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request){
        $fields = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        $customer = Customer::where('email', $fields['email'])->first();

        if(!$customer || !Hash::check($fields['password'], $customer->password)){
            return response([
                'message' => 'Login Failed'
            ], 401);
        }

        $token = $customer->createToken('myappToken')->plainTextToken;

        $response = [
            'customer' => $customer,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function logout(){
        Auth::user()->tokens()->delete();
        return [
            'message' => 'logged out'
        ];
    }
}
