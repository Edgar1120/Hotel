<?php

namespace App\Http\Controllers;

use App\Models\HotelPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;

use Illuminate\Support\Facades\File;


class HotelPhotoController extends Controller
{
    public function __construct(){
    }


    public function __invoke(){
    }

    public function index(){
        return response()->json(HotelPhoto::all(), 200);
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
            
            \Storage::disk('hotelPhoto')->put($image_name,\File::get($image));
            $response=array(
                'status'    =>200,
                'image' =>$image_name,
                'message'   =>'Imagen cargada satisfactoriamente'
            );
        }
        return response()->json($response,$response['status']);
    }   

    public function update(Request $request){
    }

    public function delete($id){
    }

    public function getImage($filename){

        $exist=\Storage::disk('hotelPhoto')->exists($filename);
        if($exist){
            $file=\Storage::disk('hotelPhoto')->get($filename);
            return new Response($file,200);
        }else{
            $response=array(
                'status'=>404,
                'message'=>'Imagen no existe'
            );
            return response()->json($response,$response['status']);
        }
    }

    public function getId($id){
        $hotelPhoto = HotelPhoto::find($id);
        if(is_null($hotelPhoto)){
            return response()->json(["message"=>"Id de la reservacion no encontrado"], 404);
        }else{
            return response()->json($hotelPhoto::find($id), 200);
        }
    }

}