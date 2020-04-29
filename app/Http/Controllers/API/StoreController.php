<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Store;
use Auth;

class StoreController extends Controller
{
    public function __construct(){
        $this->middleware('auth:api');
    }

    public function index(){
        $shops = Store::all();
        
        return response()->json([
            'message' => 'success',
            'status' => true,
            'data' => $shops
        ], 200);
    }

    public function store(Request $request){
        $rule =[
            'name' => 'required|min:2',
            'address' => 'required',
            'description' => 'required'
        ];

        $message = [
            'required' => 'Bidang :attribute harus diisi',
            'min' => 'Bidang :attribute minimal :min'
        ];

        $this->validate($request, $rule, $message);

        $shops = Store::create([
            'name' => $request->name,
            'address' => $request->address,
            'description' => $request->description,
        ]);

        return response()->json([
            'message' => 'Berhasil ditambahkan.',
            'status' => true,
            'data' => $shops
        ], 200);
    }

    public function show($id){
        if (Store::where('id', $id)->exists()) {
            $shops = Store::where('id', $id)->get();
            return response()->json([
                'message' => 'succcess',
                'status' => true,
                'data' => $shops
            ], 200);
        } else {
            return response()->json([
                "message" => "Toko tidak ditemukan"
            ], 404);
        }
    }

    public function update(Request $request, $id){
        $rule =[
            'name' => 'required|min:3',
            'address' => 'required',
            'description' => 'required'
        ];

        $message = [
            'required' => 'Bidang :attribute harus diisi',
            'min' => 'Bidang :attribute minimal :min',
        ];

        $this->validate($request, $rule, $message);

        if(Store::where('id', $id)->exists()){
            $shops = Store::find($id);
            $shops->name = is_null($request->name) ? $shops->name : $request->name;
            $shops->address = is_null($request->address) ? $shops->address : $request->address;
            $shops->description = is_null($request->description) ? $shops->description : $request->description;
            $shops->save();

            return response()->json([
                'message' => 'Berhasil diubah.',
                'status' => true,
                'data' => $shops
            ], 200);
        }else{
            return response()->json([
                'message' => 'Gagal diubah.',
                'status' => false
            ], 404);
        }        
    }

    public function destroy($id){
        if(Store::where('id', $id)->exists()) {
            $shop = Store::find($id);
            $shop->delete();
    
            return response()->json([
              "message" => "Berhasil dihapus."
            ], 202);
        } else {
            return response()->json([
              "message" => "Toko tidak ditemukan"
            ], 404);
        }
    }
}
