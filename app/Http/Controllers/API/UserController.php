<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\User; 
use Auth;

class UserController extends Controller
{
    public function register(Request $request){
        $this->validate($request, [
            'name' => 'required|min:5',
            'email' => 'required|email|max:255|unique:users',
            'password'=> 'required|min:6',
            'c_password' => 'required|same:password'
        ]);

        $users = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'api_token' => bcrypt($request->email)
        ]);

        $results = [];
        $results[] = [
            'message' => 'success',
            'status' => true,
            'data' => $users
        ];

        return response()->json([$results], 201);
    }

    public function login(Request $request){
        $credential = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if(!Auth::guard('web')->attempt($credential)){
            return response()->json([
                'message' => 'failed',
                'status' => false,
            ], 403);
        }

        $user = User::find(Auth::user()->id);
        
        $results = [];
        $results[] =[
            'message' => 'success',
            'status' => true,
            'data' => $user
        ];

        
        return response()->json([$results], 200);
    }
}
