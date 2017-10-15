<?php 
namespace App\Model\Services;

use App\Model\Contracts\QuestionServiceInterface;
use App\Model\Contracts\QuestionRepositoryInterface;
use Illuminate\Support\Facades\Validator;

class QuestionService implements QuestionServiceInterface
{

    protected $questionRepo;
	
	private $validator;
	private $data;

    public function __construct(QuestionRepositoryInterface $questionRepo)
    {
        $this->questionRepo = $questionRepo;
    }

	public function validate($request, $id, $surveyId) {
		
		$this->data = [
			'question' => $request->input('question_'.$id.'_title'),
			'option1' => $request->input('question_'.$id.'_option_1'),
			'option2' => $request->input('question_'.$id.'_option_2'),
			'option3' => $request->input('question_'.$id.'_option_3'),
			'option4' => $request->input('question_'.$id.'_option_4'),
			'survey_id' => $surveyId
		];
		
		$this->validator = Validator::make($request->all(), [
			'question_'.$id.'_title' => 'required',
			'question_'.$id.'_option_1' => 'required',
			'question_'.$id.'_option_2' => 'required'
		]);
		
		return !$this->validator->fails();
		
	}
	
	public function errors() {
		
		return $this->validator != null ? $this->validator->errors() : null;
		
	}
	
	public function store() {
		
		$this->questionRepo->create($this->data);
		$this->data = [];
		
	}
	
	public function get($id) {
		
		return $this->questionRepo->get($id);
		
	}
	
	public function countVotes($questions) {
		
		foreach($questions as $question) {
			
			$answers = $question->answers;
			
			$count1 = 0;
			$count2 = 0;
			$count3 = 0;
			$count4 = 0;
			
			foreach($answers as $answer) {
				
				switch($answer->option) {
					
					case 1:
						$count1++;
						break;
					case 2:
						$count2++;
						break;					
					case 3:
						$count3++;
						break;					
					case 4:
						$count4++;
						break;					
				}
				
			}
			
			$question->option1_votes = $count1;
			$question->option2_votes = $count2;
			$question->option3_votes = $count3;
			$question->option4_votes = $count4;
			
		}
		
		return $questions;
		
	}


}