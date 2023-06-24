<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BillController extends Controller
{
    //
    public function __construct()
    {
       
    }

    

    public function index() {
        $data = DB::select('CALL getBill()');
        $response = array(
            'status' => 200,
            'message' => 'Consulta completada satisfactoriamente',
            'data' => $data
        );
        return response()->json($data, 200);
    }



    public function getId($id){
        $bill = Bill::find($id);
        if(is_null($bill)){
            return response()->json(["message"=>"Id de la reservacion no encontrado"], 404);
        }else{
            return response()->json($bill::find($id), 200);
        }
    }
    public function store(Request $request){
        $bill = Bill::create($request->all());
        if(is_null($bill)){
            return response()->json(["messge"=>"Hubo un error al registrar"],404);
        }
        return response()->json("Se ingreso correctamente",200);
    }

    public function update(Request $request,$id){

        $bill = Bill::find($id);
        if(is_null($bill)){
            return response()->json(["messge"=>"Hubo un error al registrar"],404);
        }
        $bill->update($request->all());
        return response()->json("Se ha actualizado correctamente", 200);


    }
    public function delete($id){
        $bill = Bill::find($id);
        if(is_null($bill)){
            return response()->json(["messge"=>"Hubo un error al registrar"],404);
        }
        $bill->delete();
        return response()->json("Se ha Eliminado correctamente", 200);
    }
}
