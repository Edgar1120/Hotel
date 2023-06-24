<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;

class RoomController extends Controller
{
    public function __construct()
    {
       
    }

    public function index() {
        $data = DB::select('CALL getRooms()');
        $response = array(
            'status' => 200,
            'message' => 'Consulta completada satisfactoriamente',
            'data' => $data
        );
        return response()->json($data, 200);
    }

    public function find($id){
        $room = Room::find($id);
        if(is_null($room)){
            return response()->json(["message"=>"Habitacion no encontrado"], 404);
        }
        return response()->json($room,200);
    }

    public function store( Request $request){
        $room = Room::class::create($request->all());

        if(is_null($room)){
            return response()->json(["message"=>"Hubo un error al registrar"],404);
        }

        return response()->json("Se ha ingresado correctamente",200);
    }

    public function update(Request $request, $id){

        $room = Room::find($id);
        if(is_null($room)){
            return response()->json(["message"=>"Hubo un error al registrar"],404);
        } 

        $room->update($request->all());
        return response()->json("Se ha actualizo correctamente",200);
   
    }

    public function delete($id){
        $room = Room::find($id);
        if(is_null($room)){
            return response()->json(["message"=>"Hubo un error al registrar"],404);
        }
        $room->delete();
        return response()->json("Se ha Eliminado correctamente", 200);
    }

    public function getId($id){
        $room = Room::find($id);
        if(is_null($room)){
            return response()->json(["message"=>"Id de la reservacion no encontrado"], 404);
        }else{
            return response()->json($room::find($id), 200);
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
            
            \Storage::disk('room')->put($image_name,\File::get($image));
            $response=array(
                'status'    =>200,
                'image' =>$image_name,
                'message'   =>'Imagen cargada satisfactoriamente'
            );
        }
        return response()->json($response,$response['status']);
    }   

    public function getImage($filename){

        $exist=\Storage::disk('room')->exists($filename);
        if($exist){
            $file=\Storage::disk('room')->get($filename);
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
