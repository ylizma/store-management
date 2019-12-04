<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
  public function login(Request $req){
  	$http=new \GuzzleHttp\Client;
  	try {
  		$res=$http->post(config('services.passport.login_endpoint'),[
  			'form_params'=>[
  				'grant_type'=>'password',
  				'client_id'=>config('services.passport.client_id'),
  				'client_secret'=>config('services.passport.client_secret'),
  				'username'=>$req->username,
  				'password'=>$req->password,
  			]
  		]);
  		return $res->getBody();
  	} catch (\GuzzleHttp\Exception\BadResponseException $e) {
      if ($e->getCode()== 400) {
        return response()->json('invalid request',$e->getCode());
      }
      else if($e->getCode()== 401){
        return response()->json('incorrect infos',$e->getCode());
      }
  		return response()->json('error',$e->getCode());
  	}
  }  

  public function logout(){
  	auth()->user()->tokens->each(function($token,$key){
  		$token->delete();
  	});
  	return response()->json('logged out !!',200);
  }
}
