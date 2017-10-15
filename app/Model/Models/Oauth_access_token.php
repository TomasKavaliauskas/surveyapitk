<?php

namespace App\Model\Models;

use Illuminate\Database\Eloquent\Model;

class Oauth_access_token extends Model
{
	
	protected $guarded = ['id'];
	
	public $incrementing = false;
    
	public function user() { 
        return $this->belongsTo('App\Model\Models\User'); 
    }
	
}
