<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AvailablePosition extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function jobVacancy(){
        return $this->belongsTo(JobVacancy::class);
    }
    public function jobPosition(){
        return $this->hasMany(JobApplyPosition::class, 'position_id','id');
    }
}
