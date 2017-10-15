<?php

namespace App\Model\Contracts;

interface AnswerServiceInterface
{

	public function validate($data);
	
	public function errors();

}