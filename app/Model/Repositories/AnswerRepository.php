<?php

namespace App\Model\Repositories;

use App\Model\Repositories\Repository;
use App\Model\Contracts\AnswerRepositoryInterface;
use App\Model\Models\Answer;

class AnswerRepository extends Repository implements AnswerRepositoryInterface
{

	function model()
	{
		return 'App\Model\Models\Answer';
	}


}