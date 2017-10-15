<?php

namespace App\Model\Repositories;

use App\Model\Contracts\RepositoryInterface;

abstract class Repository implements RepositoryInterface {

    protected $model;

    public function __construct() 
	{
	    $this->makeModel();
    }

	abstract function model();

	public function makeModel() 
	{

		$model =  \App::make($this->model());
		return $this->model = $model->newQuery();

	}
	
	public function create($data) {
		
		return $this->model->create($data);
		
	}
	
	public function get($id) {
		
		return $this->model->find($id);
		
	}
	
	public function update($id, $data) {
		
		$this->model->find($id)->update($data);
		
	}
	
	public function delete($id) {
		
		$this->model->find($id)->delete();
		
	}

}