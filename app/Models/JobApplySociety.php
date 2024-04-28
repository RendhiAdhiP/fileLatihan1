<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplySociety extends Model
{
    use HasFactory;

    protected $guarded = [];
    public $timestamps = false;


    public function jobVacancy(){
        return $this->belongsTo(JobVacancy::class);
    }

    public function jobPosition(){
        return $this->hasMany(JobApplyPosition::class,'job_apply_societies_id','id');
    }

    // public function availablePosition(){
    //     return $this->hasMany(AvailablePosition::class);
    // }
}
