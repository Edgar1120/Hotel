<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;


class HotelController extends Controller
{

    public function __construct(){
    }

    public function index(){
        return response()->json(Hotel::all(), 200);
    }

    public function find($id){
        $hotel = Hotel::find($id);
        if(is_null($hotel)){
            return response()->json(["message"=>"Hotel no encontrado"], 404);
        }
        return response()->json($hotel,200);
    }

    public function store(Request $request){
        $hotel = Hotel::class::create($request->all());
        if(is_null($hotel)){
            return response()->json(["message"=>"Hotel no encontrado"], 404);
        }
        return response()->json("Hotel agregado",200);
    }

    public function update(Request $request, $id){
        $hotel = Hotel::find($id);
        if(is_null($hotel)){
            return response()->json(["message"=>"Hotel no encontrado"], 404);
        }
        $hotel->update($request->all());
        return response()->json("Hotel actualizado",200);
    }

    public function delete($id){
        $hotel = Hotel::find($id);
        if(is_null($hotel)){
            return response()->json(["message"=>"Hotel no encontrado"], 404);
        }
        $hotel->delete();
        return response()->json("Hotel eliminado",200);
    }

    public function getId($id){
        $hotel = Hotel::find($id);
        if(is_null($hotel)){
            return response()->json(["message"=>"Id del hotel no encontrado"], 404);
        }else{
            return response()->json($hotel::find($id), 200);
        }
    }

}


