<?php
namespace app\Helpers;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;
use App\Models\User;

class JWTAuth{
    private $key;
    function __construct(){

        $this->key="Esta es mi clave secreta abc123";

    }
    public function getToken($email, $password){
        $user= User::where(['email'=>$email, 'password'=>hash('sha256', $password)])->first();
        if(is_object($user)){
            $token=array(
                'iss'=>$user->id,
                'email'=>$user->email,
                'name'=>$user->name,
                'last_name'=>$user->last_name,
                'phone'=>$user->phone,
                'type'=>$user->type,
                'iat'=>time(),
                'epx'=>time()+(2000)
            );
            $data=JWT::encode($token,$this->key,'HS256');
        }else{
            $data=array(
                'status'=>401,
                'message'=>'Datos de autenticacion incorrectos'
            );

        }
        return $data;
    }
    public function checkToken($jwt,$getId=false){
        $auth=false;
        if(isset($jwt)){
            try{
                $decode=JWT::decode($jwt,new key($this->key,'HS256'));
            }catch(\DomainException $ex){
            $auth=false;
         }catch(\UnexpectedValueException $ex){
            $auth=false;
         }catch(ExpiredException $ex){
            $auth = false;
         }
         if(!empty($decode) && is_object($decode) && isset($decode->iss)){
            $auth=true;
         }
         if($getId && $auth){
            return $decode;
         }
     }
     return $auth;
  }

}
