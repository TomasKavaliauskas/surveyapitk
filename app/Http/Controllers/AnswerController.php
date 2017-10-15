<?php

namespace App\Http\Controllers;

use App\Model\Contracts\AnswerServiceInterface;
use App\Model\Contracts\UserServiceInterface;
use App\Model\Contracts\QuestionServiceInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
	
	protected $answerService;
	protected $userService;
	protected $questionService;
	
    public function __construct(AnswerServiceInterface $answerService, UserServiceInterface $userService, QuestionServiceInterface $questionService)
    {
		$this->answerService = $answerService;
		$this->userService = $userService;
		$this->questionService = $questionService;
    }		
	
	public function show($answerId) {
		
		$request = request();
		
		if(!$request->hasHeader('token')) {

			return "No auth token found.";
			
		}
		
		$tokenCheck = $this->userService->isTokenValid($request->header('token'));
		
		if($tokenCheck !== true) {
			
			return $tokenCheck;
			
		}	
		
		return $this->questionService->get($answerId);		
		
	}
	
	public function store(Request $request) {
		
		if(!$request->hasHeader('token')) {

			return "No auth token found.";
			
		}
		
		if(!$request->hasHeader('question_id')) {

			return "No question ID specified.";
			
		}		
		
		$tokenCheck = $this->userService->isTokenValid($request->header('token'));
		
		if($tokenCheck !== true) {
			
			return $tokenCheck;
			
		}
		
		$question = $this->questionService->get($request->header('question_id'));
		
		if(!$question) {
			
			return "Question with such ID doesn't exist";
			
		}
		
		$surveyId = $question->survey->id;
		
		if($this->answerService->validate($request)) {
			
			$this->answerService->store($this->userService->getUserId(), $question->id, $surveyId);
			return "true";
			
		}else{
			
			return "Apklausos laukai užpildyti neteisingai.";
			
		}		
		
	}

}
