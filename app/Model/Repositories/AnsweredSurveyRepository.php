<?php

namespace App\Model\Repositories;

use App\Model\Repositories\Repository;
use App\Model\Contracts\AnsweredSurveyRepositoryInterface;
use App\Model\Models\Answer;

class AnsweredSurveyRepository extends Repository implements AnsweredSurveyRepositoryInterface
{

	public function model()
	{
		return 'App\Model\Models\Answered_survey';
	}


}