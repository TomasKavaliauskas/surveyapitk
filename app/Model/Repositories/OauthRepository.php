<?php

namespace App\Model\Repositories;

use App\Model\Repositories\Repository;
use App\Model\Contracts\OauthRepositoryInterface;
use App\Model\Models\Oauth_access_token;

class OauthRepository extends Repository implements OauthRepositoryInterface
{

	function model()
	{
		return 'App\Model\Models\Oauth_access_token';
	}
	
	public function get($id) {
		
		return $this->model->where('id', '=', $id)->first();
		
	}	
	
}