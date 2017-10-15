<?php

namespace App\Model\Repositories;

use App\Model\Repositories\Repository;
use App\Model\Contracts\UserRepositoryInterface;
use App\Model\Models\User;

class UserRepository extends Repository implements UserRepositoryInterface
{

	function model()
	{
		return 'App\Model\Models\User';
	}
	
	public function getByEmail($email, $password) {
		
		$user = $this->model->where('email', '=', $email)->where('password', '=', bcrypt($password))->first();
		
		if($user) {
			return $user;
		}
		
		return false;
		
	}	
	
	public function get($id) {
		
		return $this->model->with('oauth_access_token')->find($id);
		
	}	
	
	public function getByAuth($auth) {
		
		$user = $this->model->where('auth_key', $auth)->first();
		
		if($user) {
			return $user;
		}
		
		return false;		
		
	}

}