<?php 
namespace App\Model\Services;

use App\Model\Contracts\SurveyServiceInterface;
use App\Model\Contracts\SurveyRepositoryInterface;
use Illuminate\Support\Facades\Validator;

class SurveyService implements SurveyServiceInterface
{

    protected $surveyRepo;
	
	private $validator;
	private $data;

    public function __construct(SurveyRepositoryInterface $surveyRepo)
    {
        $this->surveyRepo = $surveyRepo;
    }

	public function validate($request) {
		
		$this->data = [
			'title' => $request->input('title'),
			'description' => $request->input('description'),
			'icon' => $request->input('icon')
		];
		
		$this->validator = Validator::make($request->all(), [
			'title' => 'required',
			'description' => 'required',
			'icon' => 'required'
		]);
		
		if($this->validator->fails()) {
			return false;
		}
		
		return true;
		
	}
	
	public function errors() {
		
		return $this->validator != null ? $this->validator->errors() : null;
		
	}
	
	public function store($userId) {
		
		$this->data['user_id'] = $userId;
		
		return $this->surveyRepo->create($this->data)->id;
				
		
	}
	
	public function update($id) {
		
		return $this->surveyRepo->update($id, $this->data);		
		
	}
	
	public function all($size = null, $offset = null) {
		
		return $this->surveyRepo->all($size, $offset);
		
	}
	
	public function userCreatedSurveys($authorId, $size = null, $offset = null) {
		
		return $this->surveyRepo->userCreatedSurveys($authorId, $size, $offset);
		
	}
	
	public function get($id) {
		
		return $this->surveyRepo->get($id);
		
	}
	
	public function delete($id) {
		
		$this->surveyRepo->delete($id);
		
	}


}