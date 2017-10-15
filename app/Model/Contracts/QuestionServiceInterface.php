<?php

namespace App\Model\Contracts;

interface QuestionServiceInterface
{

	public function validate($data, $id, $surveyId);
	
	public function errors();
	
	public function store();
	
	public function get($id);
	
	public function countVotes($questions);

}