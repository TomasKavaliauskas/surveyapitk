<?php

namespace App\Model\Repositories;

use App\Model\Repositories\Repository;
use App\Model\Contracts\QuestionRepositoryInterface;
use App\Model\Models\Answer;

class QuestionRepository extends Repository implements QuestionRepositoryInterface
{

	public function model()
	{
		return 'App\Model\Models\Question';
	}


}