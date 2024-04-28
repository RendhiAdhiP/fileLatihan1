<?php

namespace App\Http\Controllers\Api;

use App\Models\Society;
// use App\Models\JobVacancy as Vac;
use App\Models\Validation;
use App\Models\JobCategory;
use Illuminate\Http\Request;
use App\Models\JobVacancy as Job;
use App\Http\Controllers\Controller;

class JobVacancyController extends Controller
{
    public function GetJob(Request $request)
    {
        $society = $request->society;


        if($society->validation[0]->status != 'accepted') return response()->json(['message'=>'Your validation not yet accepted']);

        $vacancy = $society->validation[0]->jobCategory->jobVacancy;
        $vacancy->load(['jobCategory','availablePosition']);

        $vac = $vacancy->map(function($v){
            return [
                'id'=>$v->id,
                'job_category_id'=>$v->jobCategory,
                'company'=>$v->company,
                'address'=>$v->address,
                'available_position'=>$v->availablePosition->map(function($a){
                    return [
                        "position"=> $a->position,
		                "capacity"=> $a->capacity,
               		    "apply_capacity"=> $a->apply_capacity,

                    ];
                })
            ];
        });

        return response()->json([
            'Vacancies' => $vac,
            
        ], 200);

    }

    public function detailJob($id, Request $request)
    {
        $society = $request->society;
        if($society->validation[0]->status != 'accepted'){
            return response()->json(['message'=>'your validation do not accpted'],401);
        }
        $job = Job::where('id',$id)->with('jobCategory', 'availablePosition')->first();

        $j = [
                'id'=>$job->id,
                'job_category_id'=>$job->jobCategory,
                'company'=>$job->company,
                'address'=>$job->address,
                'description'=>$job->description,
                'available_position'=>$job->availablePosition->map(function($a){
                    return [
                        "position"=> $a->position,
		                "capacity"=> $a->capacity,
               		    "apply_capacity"=> $a->apply_capacity,

                    ];
                })
            ];
        

        return response()->json(['Vacancies' => $j],200);
    }
}
