<?php

namespace App\Model\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{

	protected $guarded = ['id'];

	public function survey() { 
        return $this->belongsTo('App\Model\Models\Survey'); 
    }

	public function answers() { 
        return $this->hasMany('App\Model\Models\Answer'); 
    }
	
}
