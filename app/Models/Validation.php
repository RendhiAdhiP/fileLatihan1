<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Validation extends Model
{
    use HasFactory;
    public $timestamps = false;

 
    protected $guarded = [];

    public function society(){
        return $this->belongsTo(Society::class, 'society_id','id');
    }

    public function jobCategory(){
        return $this->belongsTo(JobCategory::class, 'job_category_id','id');
    }

    public function validator(){
        return $this->belongsTo(Validator::class, 'validator_id','id');
    }

}
