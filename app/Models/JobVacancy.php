<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobVacancy extends Model
{
    use HasFactory;

    public function jobCategory(){
        return $this->belongsTo(JobCategory::class);
    }
    public function availablePosition(){
        return $this->hasMany(AvailablePosition::class);
    }
    public function jobApply(){
        return $this->hasMany(JobApplySociety::class);
    }
    public function jobPosition(){
        return $this->hasMany(JobApplyPosition::class);
    }
}
