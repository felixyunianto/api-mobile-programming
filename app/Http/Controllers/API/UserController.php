<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use Carbon\Carbon;

class UserController extends Controller
{

    public function index(){
        $users = User::all();

        $results = [];
        $results[] = [
            'message' => 'success',
            'status' => true,
            'data' => $users
        ];

        return response()->json([$results], 200);
    }

    public function register(Request $request){

        $rule = [
            'name' => 'required|min:2',
            'email' => 'required|email|max:255|unique:users',
            'password'=> 'required|min:6',
            'c_password' => 'required|same:password'
        ];

        $message = [
            'required' => 'Bidang ini harus diisi',
            'email' => 'Isikan email dengan benar.',
            'unique' => 'Sudah ada :attribute yang terdaftar.',
            'same' => 'Konfirmasi password tidak sama',
            'min' => 'Bidang :attribute minimal :min'
        ];

        $validation = $this->validate($request, $rule, $message);

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

        return response()->json([$results], 200);
    }

    public function login(Request $request){
        $rule = [
            'email' => 'required',
            'password' => 'required'
        ];

        $message = [
            'required' => 'Bidang ini harus diisi!'
        ];

        $this->validate($request, $rule, $message);

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
        
        
        

        return response()->json([
            'message' => 'Login successful',
            'status' => "1",
            'data' => $user
        ], 200);
    }
}
