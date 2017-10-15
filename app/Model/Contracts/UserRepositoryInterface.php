<?php

namespace App\Model\Contracts;

interface UserRepositoryInterface
{

	public function getByEmail($email, $password);
	
	public function getByAuth($auth);

}