<?php

namespace App\Model\Contracts;

interface UserRepositoryInterface
{

	public function getByEmail($email);
	
	/*
	public function getByAuth($auth);
	*/

}