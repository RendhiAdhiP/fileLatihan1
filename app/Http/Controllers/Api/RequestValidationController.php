<?php

namespace App\Http\Controllers\Api;

use App\Models\Society;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Validation as ModelVal;
use Illuminate\Support\Facades\Validator as val;

class RequestValidationController extends Controller
{
    public function postValidation(Request $request){

        $validator = val::make($request->all(),[
            'work_experience'=>'required',
            'job_category_id'=>'required',
            'job_position'=>'required',
            'reason_accepted'=>'required',
        ]);

        $society = Society::where('login_tokens',$request->token)->first();
        $id = $society->id;
        // dd($request);

        if($validator->fails()) return response()->json([$validator->errors()],422);

        if($society->validation()->count() > 0) return response()->json(['message'=>'validation only be once']);

        ModelVal::create([
            'work_experience'=>$request->work_experience,
            'job_category_id'=>$request->job_category_id,
            'job_position'=>$request->job_position,
            'reason_accepted'=>$request->reason_accepted,
            'society_id'=>$id,
        ]);
            
        return response()->json(['message'=>'Request data validation sent successful']);

    }

    public function getValidation(Request $request){

        $society = Society::where('login_tokens',$request->token)->first();

        $validation = modelVal::where('society_id',$society->id)->with('jobCategory')->first();

        return response()->json(['validation'=>[
            "id"=>$validation->id,
            "status"=>$validation->status,
            "work_experience"=>$validation->work_experience,
            "job_category_id"=>$validation->jobCategory->job_category,
            "job_position"=>$validation->job_position,
            "reason_accepted"=>$validation->reason_accepted,
            "validator_notes"=>$validation->validator_notes,
            "validator"=>$validation->validator

        ]],200);

    }
}
