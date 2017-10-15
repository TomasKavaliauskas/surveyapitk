<?php

namespace App\Model\Models;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
  
    protected $guarded = ['id'];
  
	public function user() { 
        return $this->belongsTo('App\Model\Models\User'); 
    }	
	
	public function questions() { 
        return $this->hasMany('App\Model\Models\Question'); 
    }
	
}
