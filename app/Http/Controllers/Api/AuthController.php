<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Society;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator as Val;

class AuthController extends Controller
{
    public function login(Request $request){
        
        // $validator = Val::make([
        //     'Id_card'
        // ]);

        $credentials = $request->only(['id_card_number','password']);

        $society = Society::where($credentials)->with('regional')->first();

        if($society){
            $society->update(['login_tokens'=>md5($request->id_card_number)]);
            return response()->json(['message'=>'login success','body'=>[
                    'name'=>$society->name,
                    'bron_date'=>$society->born_date,
                    'gender'=>$society->gender,
                    'token'=>$society->login_tokens,
                    'regional'=>$society->regional,
                ]],200);

        }

        return response()->json(['message'=>'ID Card Number or Password incorrect'],401);
        
    }


    public function logout(Request $request){
            
        $society = Society::where('login_tokens',$request->token)->first();

        // if($society || $request->token){
        //     $society->update(['login_tokens'=>NULL]);
        //     $society->update(['login_tokens'=>NULL]);
        //     $society->save();
        //     return response()->json(['message'=>'logout success',$society], 200);
            
        // }else{
           
        //     return response()->json(['message'=>'invalid token'], 401);

        // }

        if(!$society || $request->token == NUll) return response()->json(['message'=>'invalid token'], 401);

        $society->update(['login_tokens' => NULL]);

        return response()->json(['message' => 'Logout success'], 200);
    }
}
