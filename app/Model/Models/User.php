<?php

namespace App\Model\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
	
	use HasApiTokens, Notifiable;

	protected $guarded = ['id'];
	
	public function surveys() {
        return $this->hasMany('App\Model\Models\Survey');
    }
	
	public function answers() {
        return $this->hasMany('App\Model\Models\Answer');
    }	
	
	public function answered_surveys() {
		return $this->hasMany('App\Model\Models\Answered_survey');
	}
	
	public function oauth_access_token() {
		return $this->hasOne('App\Model\Models\Oauth_access_token');
	}	

}
