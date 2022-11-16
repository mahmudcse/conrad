<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    //

    public function index(){
        return Customer::paginate(5);
    }

    public function store(Request $request){
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:customers,email',
            'password' => 'required|string'
        ]);

        $customer = Customer::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password'])
        ]);

        $token = $customer->createToken('myapptoken')->plainTextToken;

        $response = [
            'customer' => $customer,
            'token' => $token
        ];

        return response($response, 201);

    }

    public function destroy($id){
        return Customer::destroy($id);
    }

    public function restore($id){
        Customer::withTrashed()->find($id)->restore();
        $customer = Customer::find($id);
        return $customer;
    }
}
