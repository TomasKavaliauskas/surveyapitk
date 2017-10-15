<?php

namespace App\Model\Contracts;

interface SurveyRepositoryInterface
{

	public function all($size, $offset);
	
	public function userCreatedSurveys($authorId);

}