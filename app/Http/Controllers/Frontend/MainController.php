<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use GuzzleHttp\Exception\GuzzleException;
use App\Model\Contracts\UserServiceInterface;
use App\Model\Contracts\QuestionServiceInterface;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class MainController extends Controller
{
	
	protected $userService;
	protected $questionService;
	
    public function __construct(UserServiceInterface $userService, QuestionServiceInterface $questionService)
    {
		$this->userService = $userService;
		$this->questionService = $questionService;
    }		

	public function index() {
		$data['current_page'] = request()->segment(1);
		$request = \Request::create('/api/surveys', 'GET');
		$request->headers->set('Accept', 'application/json');
		$data['surveys'] = app()->handle($request)->original;
		

		if(!is_object($data['surveys'])) {
			
			$data['surveys'] = [];
			\Auth::logout();
			
		}		
		
		if(\Auth::check()) {
			
			foreach($data['surveys'] as $survey) {
				
				$survey->has_answered = $this->userService->hasAnswered(\Auth::user()->id, $survey->id);		
				
			}
			
		}
		
		return view('frontend.homepage', $data);
		
	}
	
	public function api() {
		
		$data['current_page'] = request()->segment(1);
		return view('frontend.api', $data);
		
	}
	
	public function surveys() {
		$data['current_page'] = request()->segment(1);
		$request = \Request::create('/api/surveys', 'GET');
		$request->headers->set('AuthenticationToken', json_decode(\Cookie::get('authToken'))->token);
		$request->headers->set('Accept', 'application/json');
		$request->headers->set('author', \Auth::id());
		$data['surveys'] = app()->handle($request)->original;
		
		if(!is_object($data['surveys'])) {
			
			$data['surveys'] = [];
			
		}
		
		return view('frontend.surveys', $data);
		
	}

	public function survey($id) {
		$data['current_page'] = request()->segment(1);
		$request = \Request::create('/api/surveys/' . $id, 'GET');
		$request->headers->set('AuthenticationToken', json_decode(\Cookie::get('authToken'))->token);
		$request->headers->set('Accept', 'application/json');
		$data['survey'] = app()->handle($request)->original;
		
		if(!is_object($data['survey'])) {
			
			$data['survey'] = [];
			
		}

		return view('frontend.survey', $data);		
		
	}
	
	public function create() {
		$data['current_page'] = request()->segment(1);
		return view('frontend.survey-create', $data);	
		
	}
	
	public function store(Request $request) {
		$data['current_page'] = request()->segment(1);
		$request = \Request::create('/api/surveys', 'POST', $request->all());
		$request->headers->set('AuthenticationToken', json_decode(\Cookie::get('authToken'))->token);
		$request->headers->set('Accept', 'application/json');
		$response = app()->handle($request)->original;		
		
		if(isset($response['success'])) {
			
			return redirect('http://surveyapi.tk/surveys');
			
		}else{

			return redirect('http://surveyapi.tk/surveys/create')->withInput()->with('error', $response['error']);
			
		}
		
	}
	
	public function delete($id) {
		$data['current_page'] = request()->segment(1);
		$request = \Request::create('/api/surveys/'.$id, 'DELETE');
		$request->headers->set('AuthenticationToken', json_decode(\Cookie::get('authToken'))->token);
		$request->headers->set('Accept', 'application/json');
		$response = app()->handle($request)->original;

		if(isset($response['success'])) {
			
			return redirect('http://surveyapi.tk/surveys')->with('success', "Apklausa sėkmingai ištrinta");
			
		}else{

			return redirect('http://surveyapi.tk/surveys')->with('error', $response['error']);
			
		}		
		
	}
	
	public function edit($id) {
		$data['current_page'] = request()->segment(1);
		$request = \Request::create('/api/surveys/' . $id, 'GET');
		$request->headers->set('AuthenticationToken', json_decode(\Cookie::get('authToken'))->token);
		$request->headers->set('Accept', 'appilcation/json');
		$data['survey'] = app()->handle($request)->original;
		
		if(!is_object($data['survey'])) {
			
			return redirect('http://surveyapi.tk');
			
		}
		
		return view('frontend.survey-edit', $data);	
		
	}
	
	public function update($id) {
		$data['current_page'] = request()->segment(1);
		$request = request();
		
		$request = \Request::create('/api/surveys/' . $id, 'PUT', $request->all());
		$request->headers->set('AuthenticationToken', json_decode(\Cookie::get('authToken'))->token);
		$request->headers->set('Accept', 'application/json');
		$response = app()->handle($request)->original;		
		
		if(isset($response['success'])) {
			
			return redirect('http://surveyapi.tk/surveys');
			
		}else{

			return redirect('http://surveyapi.tk/surveys/edit')->withInput()->with('error', $response['error']);
			
		}		
		
	}
	
	public function answer($id) {
		$data['current_page'] = request()->segment(1);
		$request = request();
		
		$request = \Request::create('/api/surveys/'.$id.'/answer', 'POST', $request->all());
		$request->headers->set('AuthenticationToken', json_decode(\Cookie::get('authToken'))->token);
		$request->headers->set('Accept', 'application/json');
		$response = app()->handle($request)->original;		
		
		if(isset($response['success'])) {
			
			return redirect('http://surveyapi.tk/');
			
		}else{

			return redirect('http://surveyapi.tk/surveys/' . $id)->withInput()->with('error', $response['error']);
			
		}		
		
	}
	
	public function stats($surveyId) {
		$data['current_page'] = request()->segment(1);
		$request = \Request::create('/api/surveys/' . $surveyId, 'GET');
		$request->headers->set('AuthenticationToken', json_decode(\Cookie::get('authToken'))->token);
		$request->headers->set('Accept', 'application/json');
		$data['survey'] = app()->handle($request)->original;

		if($data['survey']->user->id != \Auth::id()) {
			return redirect('/');
		}
		
		$data['survey']->questions = $this->questionService->countVotes($data['survey']->questions);
		
		return view('frontend.stats', $data);
		
	}

}
