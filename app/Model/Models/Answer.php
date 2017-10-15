<?php

namespace App\Model\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
	
	protected $guarded = ['id'];
    
	public function user() { 
        return $this->belongsTo('App\Model\Models\User'); 
    }

	public function survey() { 
        return $this->belongsTo('App\Model\Models\Survey'); 
    }	
	
	public function question() { 
        return $this->belongsTo('App\Model\Models\Question'); 
    }	
	
}
