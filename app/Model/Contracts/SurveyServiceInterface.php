<?php

namespace App\Model\Contracts;

interface SurveyServiceInterface
{

	public function validate($data);
	
	public function errors();
	
	public function store($userId);
	
	public function all($size, $offset);	
	
	public function userCreatedSurveys($authorId, $size, $offset);
	
	public function get($id);
	
	public function delete($id);
	
	public function update($id);

}