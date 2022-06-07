<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    function register(Request $request)
    {
      $data=  $this->validate($request, [
            'user_name' => 'required|unique:users',
            'password' => 'required'
        ]);

      $data['password']=Hash::make( $data['password']);
       $user= User::create($data);

        return response()->json([

            'status' => 'success',
            'token'=>$user->createToken('API token')->plainTextToken

        ]);
    }
    function login(Request $request)
    {
//        $data= $this->validate($request, [
//            'user_name' => 'required|unique:users',
//            'password' => 'required'
//        ]);


        if (!Auth::attempt($request->all())) {
        return response()->json([

            'status' => 'fail',
            'message'=>'not match'

        ], 401);

        }
        return response()->json([

            'status' => 'you are login',
            'token'=>Auth::user()->createToken('API token')->plainTextToken

        ]);

    }

}
