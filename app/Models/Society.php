<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Society extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $guarded = [];

    public $hidden = ['id','id_card_number','password','regional_id','login_tokens'];

    public function regional(){
        return $this->belongsTo(Regional::class);
    }

    public function validation(){
        return $this->hasMany(Validation::class);
    }

    public function jobApply(){
        return $this->hasMany(JobApplySociety::class);
    }

    public function jobPosition(){
        return $this->hasMany(JobApplyPosition::class);
    }
}
