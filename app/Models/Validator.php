<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Validator extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function validation(){
        return $this->hasMany(validation::class, 'validator_id','id');
    }
}
