<?php

namespace App\Http\Controllers;

use App\Helpers\JwtAuth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    public function __construct(){
        //$this->middleware('api.auth',['except'=>['login']]);

    }


    public function __invoke(){
    }

    public function index(){
        $data = User::all();
        $response = array(
            "status"=>200,
            "message"=>"Consulta generada exitosamente",
            "data"=>$data
        );
        return response()->json($data,200);
    }

    public function store(Request $request){
        
        $dataImput = $request->input('data',null);
        $data = json_decode($dataImput,true);
        $data = array_map('trim',$data);
        $rules = [
            'id'=>'required',
            'name'=>'required|alpha',
            'last_name'=>'required',
            'email'=>'required|email|unique:user',
            'phone'=>'required',
            'password'=>'required',
            'type'=>'required'
        ];

        $valid=\validator($data,$rules);
        if(!$valid->fails()){
            
            $user=new User();
            $user->id=$data['id'];
            $user->name=$data['name'];
            $user->last_name=$data['last_name'];
            $user->email=$data['email'];
            $user->phone=$data['phone'];
            $user->password=hash('sha256',$data['password']);
            $user->type=$data['type'];
            $user->save();
            $response = array(
                'status'=>200,
                'message'=>'Datos guardados',
            );
        }else{
            $response = array(
                'status'=>406,
                'message'=>'Error en la validacion de datos',
                'errors'=>$valid->errors(),
            );
        }
        return response()->json($response,$response['status']);
    }

    public function update(Request $request,$id){

        $user = User::find($id);
        if(is_null($user)){
            return response()->json(["messge"=>"Hubo un error al registrar"],404);
        }
        $user->update($request->all());
        return response()->json("se ha actualizado correctamente", 200);


    }

    public function delete($id){
        $user = User::find($id);
        if(is_null($user)){
            return response()->json(["messge"=>"Hubo un error al registrar"],404);
        }
        $user->delete();
        return response()->json("se ha Eliminado correctamente", 200);

    }


    public function login(Request $request){
        $jwtAuth=new JwtAuth();
        $dataInput=$request->input('data',null);
        $data=json_decode($dataInput,true);
        $data=array_map('trim',$data);
        $rules=['email'=>'required','password'=>'required'];
        $valid=\validator($data,$rules);
        if(!$valid->fails()){
            $response=$jwtAuth->getToken($data['email'],$data['password']);
            return response()->json($response);

        }else{
            $response=array(
                'status'=>406,
                'message'=>'Error en la validacion de datos',
                'errors'=>$valid->errors(),
            );
            return response()->json($response,406);
        }

    }
    
    public function getIdentity(Request $request){
       
        $jwtAuth=new JwtAuth();
        $token=$request->header('beartoken');
        if(isset($token)){
            $response=$jwtAuth->checkToken($token,true);
        }else{
            $response=array(
                'status'=>404,
                'message'=> 'Token (beartoken) no encontrado'
            );
        }
        return response()->json($response);
    }
    public function getId($id){
        $user = User::find($id);
        if(is_null($user)){
            return response()->json(["message"=>"Id del usuario no encontrado"], 404);
        }else{
            return response()->json($user::find($id), 200);
        }
    }

}