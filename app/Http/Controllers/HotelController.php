<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


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


    public function uploadImage(Request $request){
        $image=$request->file('file0');
        $validate=\Validator::make($request->all(),[
            'file0'=>'required|image|mimes:jpg,jpeg,png'
        ]);
        if(!$image || $validate->fails()){
            $response=array(
                'status'    =>406,
                'message'   =>'Error al subir la imagen'
            );
        }
        else{
            $image_name=\Str::uuid().".".$image->getClientOriginalExtension();
            
            \Storage::disk('hotel')->put($image_name,\File::get($image));
            $response=array(
                'status'    =>200,
                'image' =>$image_name,
                'message'   =>'Imagen cargada satisfactoriamente'
            );
        }
        return response()->json($response,$response['status']);
    }   

    public function getImage($filename){

        $exist=\Storage::disk('hotel')->exists($filename);
        if($exist){
            $file=\Storage::disk('hotel')->get($filename);
            return new Response($file,200);
        }else{
            $response=array(
                'status'=>404,
                'message'=>'Imagen no existe'
            );
            return response()->json($response,$response['status']);
        }
    }



}


