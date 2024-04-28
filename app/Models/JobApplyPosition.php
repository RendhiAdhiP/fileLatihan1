<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplyPosition extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;

    public function jobVacancy(){
        return $this->belongsTo(jobVacancy::class);
    }

    public function jobApply(){
        return $this->belongsTo(JobApplySociety::class,'job_apply_societies_id','id');
    }

    public function Society(){
        return $this->belongsTo(Society::class);
    }

    public function availablePosition(){
        return $this->belongsTo(AvailablePosition::class,'position_id','id');
    }
}
