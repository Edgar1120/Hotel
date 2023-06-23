<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
    public function __construct()
    {
       
    }

    public function __invoke(){
    }
    



    public function index() {
        $data = DB::select('CALL getAll()');
        $response = array(
            'status' => 200,
            'message' => 'Consulta completada satisfactoriamente',
            'data' => $data
        );
        return response()->json($data, 200);
    }



    public function getId($id){
        $reservation = Reservation::find($id);
        if(is_null($reservation)){
            return response()->json(["message"=>"Id de la reservacion no encontrado"], 404);
        }else{
            return response()->json($reservation::find($id), 200);
        }
    }

    public function store(Request $request){
        $reservation = Reservation::create($request->all());
        if(is_null($reservation)){
            return response()->json(["messge"=>"Hubo un error al registrar"],404);
        }
        return response()->json("Se ingreso correctamente",200);
    }

    public function update(Request $request,$id){

        $reservation = Reservation::find($id);
        if(is_null($reservation)){
            return response()->json(["messge"=>"Hubo un error al registrar"],404);
        }
        $reservation->update($request->all());
        return response()->json("Se ha actualizado correctamente", 200);


    }

    public function delete($id){
        $reservation = Reservation::find($id);
        if(is_null($reservation)){
            return response()->json(["messge"=>"Hubo un error al registrar"],404);
        }
        $reservation->delete();
        return response()->json("Se ha Eliminado correctamente", 200);
    }

}
