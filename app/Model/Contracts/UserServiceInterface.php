<?php

namespace App\Model\Contracts;

interface UserServiceInterface
{
	
	public function validate($data);
	
	public function errors();
	
	public function loginExists($email, $password);
	
	public function authExists($auth);
	
	public function register();	
	
	public function isTokenValid($token);
	
	public function hasAnswered($userId, $surveyId);

}