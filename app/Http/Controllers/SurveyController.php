<?php

namespace App\Http\Controllers;

use App\Model\Contracts\SurveyServiceInterface;
use App\Model\Contracts\UserServiceInterface;
use App\Model\Contracts\QuestionServiceInterface;
use App\Model\Contracts\AnswerServiceInterface;
use App\Model\Contracts\AnsweredSurveyRepositoryInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SurveyController extends Controller
{
	
	protected $surveyService;
	protected $userService;
	protected $questionService;
	protected $answerService;
	protected $ansSurveyRepo;
	
    public function __construct(AnsweredSurveyRepositoryInterface $ansSurveyRepo, SurveyServiceInterface $surveyService, UserServiceInterface $userService, QuestionServiceInterface $questionService, AnswerServiceInterface $answerService)
    {
		
		$this->surveyService = $surveyService;
		$this->userService = $userService;
		$this->questionService = $questionService;
		$this->answerService = $answerService;
		$this->ansSurveyRepo = $ansSurveyRepo;
		
    }

	public function login(Request $request) {
		
		$response = new Response();
		
		if($request->input('email') == null) {
			
			$response->setContent(['error' => "No email given."]);
			$response->setStatusCode(400);
			return $response;			
			
		}
		
		if($request->input('password') == null) {
			
			$response->setContent(['error' => "No password given."]);
			$response->setStatusCode(400);
			return $response;			
			
		}
		
		if(!\Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {
			
			$response->setContent(['error' => "No user with such credentials"]);
			$response->setStatusCode(401);
			return $response;			
			
		}
		
		$response->setContent(['token' => $this->userService->get(\Auth::id())->oauth_access_token->id]);
		$response->setStatusCode(200);
		return $response;
		
	}

	public function index(Request $request)
	{
		
		$response = new Response();
		
		$size = 999999;
		$offset = 0;
		
		if($request->has('size')) {
			$size = $request->size;
		}
		if($request->has('offset')) {
			$offset = $request->offset;
		}		

		/* CHECK AUTH */
		if(!$request->hasHeader('AuthenticationToken')) {

			if(!$request->hasHeader('author')) {
				$response->setContent($this->surveyService->all($size, $offset));
				$response->setStatusCode(200);
				return $response;
			}
			
			$response->setContent(['error' => "No auth token found."]);
			$response->setStatusCode(400);
			return $response;
			
		}
		
		$tokenCheck = $this->userService->isTokenValid($request->header('AuthenticationToken'));
		
		if($tokenCheck !== true) {
			
			$response->setContent(['error' => $tokenCheck]);
			$response->setStatusCode(401);
			return $response;
			
		}
		
		if($request->hasHeader('author')) {

			$response->setContent($this->surveyService->userCreatedSurveys($this->userService->getUserId(), $size, $offset));
			$response->setStatusCode(200);
			return $response;
			
		}		

		$response->setContent($this->surveyService->all($size, $offset));
		$response->setStatusCode(200);
		return $response;
		
	}
	
	private function validateAuth($request) {
		
		$response = new Response();
		
		if(!$request->hasHeader('AuthenticationToken')) {

			$response->setContent(['error' => "No auth token found."]);
			$response->setStatusCode(400);
			return $response;
			
		}
		
		$tokenCheck = $this->userService->isTokenValid($request->header('AuthenticationToken'));
		
		if($tokenCheck !== true) {
			
			$response->setContent(['error' => $tokenCheck]);
			$response->setStatusCode(401);
			return $response;
			
		}

		return $response;		
		
	}
	
	public function show($surveyId) {
		
		$request = request();
		$response = $this->validateAuth($request);
		
		if($response->getStatusCode() == 400 || $response->getStatusCode() == 401) {
			return $response;
		}
		
		$survey = $this->surveyService->get($surveyId);
		
		if(!$survey) {
			
			$response->setContent(['error' => "Tokia apklausa neegzistuoja"]);
			$response->setStatusCode(404);
			return $response;			
			
		}
		
		$response->setContent($this->surveyService->get($surveyId));
		$response->setStatusCode(200);
		return $response;		
		
	}
	
	public function store(Request $request) {
		
		$response = $this->validateAuth($request);
		
		if($response->getStatusCode() == 400 || $response->getStatusCode() == 401) {
			return $response;
		}
		
		if($this->surveyService->validate($request)) {
			
			$surveyId = $this->surveyService->store($this->userService->getUserId());
			
			$k = 0;
			for($i = -100; $i < 0; $i++) {
				
				if($request->input('question_' . $i . '_title') != null) {
					
					if($this->questionService->validate($request, $i, $surveyId)) {
						
						$this->questionService->store();
						$k++;
						
					}
					
				}
				
			}
			
			if($k > 0) {
			
				$response->setContent(['success' => true]);
				$response->setStatusCode(201);
				return $response;
			
			}else{
				
				$this->surveyService->delete($surveyId);
				$response->setContent(['error' => "Ne vienas klausimas nera teisingai sudarytas"]);
				$response->setStatusCode(400);
				return $response;
				
			}
			
		}else{
			
			$response->setContent(['error' =>"Apklausos laukai uzpildyti neteisingai"]);
			$response->setStatusCode(400);
			return $response;
			
		}		
		
	}
	
	public function destroy($surveyId) {
		
		$request = request();
		$response = $this->validateAuth($request);
		
		if($response->getStatusCode() == 400 || $response->getStatusCode() == 401) {
			return $response;
		}

		$userId = $this->userService->getUserId();
		
		$survey = $this->surveyService->get($surveyId);
		
		if($survey->user->id == $userId) {
			
			$this->surveyService->delete($surveyId);
			$response->setContent(['success' => true]);
			$response->setStatusCode(200);
			return $response;
			
		}
		
		$response->setContent(['error' => "Negalite trinti ne savo apklausu"]);
		$response->setStatusCode(403);
		return $response;		
		
	}
	
	public function update($surveyId) {
		
		$request = request();
		$response = $this->validateAuth($request);
		
		if($response->getStatusCode() == 400 || $response->getStatusCode() == 401) {
			return $response;
		}

		$userId = $this->userService->getUserId();
		
		$survey = $this->surveyService->get($surveyId);
		
		if($survey->user->id == $userId) {
			
			if($this->surveyService->validate($request)) {
			
				$this->surveyService->update($surveyId, $request->all);
				$response->setContent(['success' => true]);
				$response->setStatusCode(200);
				return $response;
				
			}
			
			$response->setContent($request->all());
			$response->setStatusCode(400);
			return $response;
			
		}
		
		$response->setContent(['error' => "Negalite redaguoti ne savo apklausu"]);
		$response->setStatusCode(403);
		return $response;		
		
	}
	
	public function answer($surveyId) {
		
		$request = request();
		$response = $this->validateAuth($request);
		
		if($response->getStatusCode() == 400 || $response->getStatusCode() == 401) {
			return $response;
		}
		
		$survey = $this->surveyService->get($surveyId);
		
		if(!$survey) {
			
			$response->setContent(['error' => "Apklausa neegzistuoja"]);
			$response->setStatusCode(404);
			return $response;
			
		}
		
		if($this->userService->hasAnswered($this->userService->getUserId(), $surveyId)) {
			
			$response->setContent(['error' => 'Jus jau atsakinejote i sia apklausa']);
			$response->setStatusCode(401);
			return $response;			
			
		}
		
		foreach($survey->questions as $question) {
			
			if($request->input('answer_'.$question->id) == null) {
					
				$response->setContent(['error' => "Butina uzpildyti visus laukus"]);
				$response->setStatusCode(400);
				return $response;
				
			}
			
		}
		
		foreach($survey->questions as $question) {
			
			$this->answerService->store(
				$request->input('answer_'.$question->id),
				$this->userService->getUserId(),
				$question->id,
				$surveyId
			);
			
		}

		$data_pivot = [
			'user_id' => $this->userService->getUserId(),
			'survey_id' => $surveyId
		];		
		
		$this->ansSurveyRepo->create($data_pivot);
			
		$response->setContent(['success' => true]);
		$response->setStatusCode(201);
		return $response;

	}

}
