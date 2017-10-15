<?php

namespace App\Model\Contracts;

interface RepositoryInterface {
	
	public function create($data);
	
	public function get($id);
	
	public function update($id, $data);
	
	public function delete($id);

}
