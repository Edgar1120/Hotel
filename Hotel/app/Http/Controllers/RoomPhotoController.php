<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RoomPhoto;

class RoomPhotoController extends Controller
{
    public function index(){
        $data = RoomPhoto::all();
        $response = array(
            "status"=>200,
            "message"=>"Consulta generada exitosamente",
            "data"=>$data
        );
        return response()->json($data,200);
    }

    public function store( Request $request){
        $roomPhoto = RoomPhoto::create($request->all());

        if(is_null($roomPhoto)){
            return response()->json(["messge"=>"Hubo un error al registrar"],404);
        }

        return response()->json("Se ha ingresado correctamente",200);
    }

    public function update(Request $request, $id){

        $roomPhoto = RoomPhoto::find($id);
        if(is_null($roomPhoto)){
            return response()->json(["messge"=>"Hubo un error al registrar"],404);
        } 

        $roomPhoto->update($request->all());
        return response()->json("Se ha actualizo correctamente",200);
   
    }

    public function delete($id){
        $roomPhoto = RoomPhoto::find($id);
        if(is_null($roomPhoto)){
            return response()->json(["messge"=>"Hubo un error al registrar"],404);
        }
        $roomPhoto->delete();
        return response()->json("Se ha Eliminado correctamente", 200);
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
            
            \Storage::disk('roomPhoto')->put($image_name,\File::get($image));
            $response=array(
                'status'    =>200,
                'image' =>$image_name,
                'message'   =>'Imagen cargada satisfactoriamente'
            );
        }
        return response()->json($response,$response['status']);
    }   

    public function getImage($filename){

        $exist=\Storage::disk('roomPhoto')->exists($filename);
        if($exist){
            $file=\Storage::disk('roomPhoto')->get($filename);
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
        $roomPhoto = RoomPhoto::find($id);
        if(is_null($roomPhoto)){
            return response()->json(["message"=>"Id de la reservacion no encontrado"], 404);
        }else{
            return response()->json($roomPhoto::find($id), 200);
        }
    }





}
