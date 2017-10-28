<?php 
namespace App\Model\Services;

use App\Model\Contracts\AnswerServiceInterface;
use App\Model\Contracts\AnswerRepositoryInterface;
use App\Model\Contracts\AnsweredSurveyRepositoryInterface;
use Illuminate\Support\Facades\Validator;

class AnswerService implements AnswerServiceInterface
{

    protected $answerRepo;
	protected $ansSurveyRepo;
	
	private $validator;
	private $data;

    public function __construct(AnswerRepositoryInterface $answerRepo, AnsweredSurveyRepositoryInterface $ansSurveyRepo)
    {
        $this->answerRepo = $answerRepo;
		$this->ansSurveyRepo = $ansSurveyRepo;
    }

	public function validate($request) {
		
		$this->data = [
			'option' => $request->input('option')
		];
		
		$this->validator = Validator::make($request->all(), [
			'option' => 'required|numeric|between:1,4'
		]);
		
		return !$this->validator->fails();
		
	}
	
	public function errors() {
		
		return $this->validator;
		
	}
	
	public function store($answer, $userId, $questionId, $surveyId) {
		
		$this->data['option'] = $answer;
		$this->data['user_id'] = $userId;
		$this->data['question_id'] = $questionId;
		$this->data['survey_id'] = $surveyId;
		
		$this->ansSurveyRepo->create(['user_id' => $userId, 'survey_id' => $surveyId]);
		
		return $this->answerRepo->create($this->data)->id;
		
	}	


}