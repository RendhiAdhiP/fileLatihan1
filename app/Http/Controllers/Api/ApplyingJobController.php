<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\JobApplyPosition;
use Illuminate\Support\Facades\Validator as val;

class ApplyingJobController extends Controller
{
    public function applyingJob(Request $request){
        $society = $request->society;

        if($society->validation[0]->status != 'accepted'){
            return response()->json(['message'=>'your validation do not accpted'], 401);
        }

        $validate = val::make($request->all(),[
            'vacancy_id'=>'required',
            'positions'=>'required',
            'notes'=>'required',
        ]);

        if($validate->fails()) return response()->json($validate->errors(),400);

        $jobSociety = $society->jobApply()->create([
            'job_vacancy_id'=>$request->vacancy_id,
            'notes'=>$request->notes,
            'date'=>now(),
        ]);
        
        $positions = collect(str($request->positions)->explode(',')); 
        
        $avPos = $society->jobPosition->map(function($a) use($positions){
            $ids = $a->availablePosition->whereIn('position',$positions);
            $id = $ids->pluck('id');
            $i = $id->flatten(INF)->all();
            return $i;
        });

        $pos = collect($avPos->flatten(INF)->all());

        // $positions = ['mobile dev','web dev']; 
        // $avPos = $society->jobPosition->map(function($a) use($positions){
        //     $ids = $a->availablePosition->filter(function($pos)use($positions){
        //         return in_array($pos->position,$positions);
        //     });
        //     $id= $ids->pluck('id');
        //     return $id;
        // });


        $pos->map(fn ($pos) => $society->jobPosition()->create([
            'date' => now(),
            'job_vacancy_id' => $request->vacancy_id,
            'position_id' => $pos,
            'status' => 'pending',
            'job_apply_societies_id' => $jobSociety->id,
        ]));


        return response()->json(['message' => 'Success apply']);
    }

    public function getSuccessApply(Request $request){

        $society = $request->society;

        $jobApply = $society->jobApply;
        $jobApply->load(['jobVacancy.jobCategory','jobPosition.availablePosition']);

        $va = $jobApply->map(function($v){
            return 
                [
                'id' =>  $v->id,
                'category_id' => $v->jobVacancy->jobCategory,
                'company' =>  $v->jobVacancy->company,
                'addrees' =>  $v->jobVacancy->address,
                'position'=> $v->jobPosition->map(function($p){
                    return [
                        'position'=>$p->availablePosition->position,
                        'applay_status'=>$p->status,
                        'notes'=>$p->jobApply->notes,
                    ];
                })
            ];
                
            
        });

        return response()->json(['vacancies'=>$va]
    );

    }
}
