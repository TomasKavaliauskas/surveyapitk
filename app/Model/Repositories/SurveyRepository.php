<?php

namespace App\Model\Repositories;

use App\Model\Repositories\Repository;
use App\Model\Contracts\SurveyRepositoryInterface;
use App\Model\Models\Survey;

class SurveyRepository extends Repository implements SurveyRepositoryInterface
{

	public function model()
	{
		return 'App\Model\Models\Survey';
	}
	
	public function all($size = null, $offset = null) {
		
		return $this->model->offset($offset)->limit($size)->get();
		
	}
	
	public function get($id) {
		
		return $this->model->with(['questions', 'questions.answers'])->find($id);
		
	}	
	
	public function userCreatedSurveys($authorId, $size = null, $offset = null) {
		
		return $this->model->where('user_id', $authorId)->with('questions')->offset($offset)->limit($size)->get();
		
	}
	
}