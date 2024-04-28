<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobCategory extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function validation(){
        return $this->hasMany(Validation::class, 'job_category_id','id');
    }

    public function jobVacancy(){
        return $this->hasMany(JobVacancy::class, 'job_category_id','id');
    }
}
