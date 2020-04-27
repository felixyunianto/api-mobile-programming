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
        $results = [];

        $results[] = [
            'message' => 'success',
            'status' => true,
            'data' => $shops
        ];

        return response()->json([$results], 200);
    }

    public function store(Request $request){
        $rule =[
            'name' => 'required|min:3',
            'address' => 'required|min:5|max:191',
            'longitude' => 'required',
            'latitude' => 'required'
        ];

        $message = [
            'required' => 'Bidang :attribute harus diisi',
            'min' => 'Bidang :attribute minimal :min',
            'max' => 'Bidang :attribute maximal :max'
        ];

        $this->validate($request, $rule, $message);

        $shops = Store::create([
            'name' => $request->name,
            'address' => $request->address,
            'longitude' => $request->longitude,
            'latitude' => $request->latitude,
        ]);

        return response()->json([
            'message' => 'Berhasil ditambahkan.',
            'status' => true
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
            'address' => 'required|min:5|max:191',
            'longitude' => 'required',
            'latitude' => 'required'
        ];

        $message = [
            'required' => 'Bidang :attribute harus diisi',
            'min' => 'Bidang :attribute minimal :min',
            'max' => 'Bidang :attribute maximal :max'
        ];

        $this->validate($request, $rule, $message);

        if(Store::where('id', $id)->exists()){
            $shops = Store::find($id);
            $shops->name = is_null($request->name) ? $shops->name : $request->name;
            $shops->address = is_null($request->address) ? $shops->address : $request->address;
            $shops->longitude = is_null($request->longitude) ? $shops->longitude : $request->longitude;
            $shops->latitude = is_null($request->latitude) ? $shops->latitude : $request->latitude;
            $shops->save();

            return response()->json([
                'message' => 'Berhasil diubah.',
                'status' => true
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
