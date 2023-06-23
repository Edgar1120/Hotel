<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoomController extends Controller
{
    public function __construct()
    {
       
    }

    public function index() {
        $data = DB::select('CALL getRoom()');
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
}
