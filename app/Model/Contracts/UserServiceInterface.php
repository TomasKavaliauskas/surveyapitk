<?php

namespace App\Model\Contracts;

interface UserServiceInterface
{

	public function loginExists($email);

	public function register();	
	
	public function isTokenValid($token);
	
	public function hasAnswered($userId, $surveyId);

}