<?php

namespace Tests\Unit;

use App;
use App\Model\Models\Answer;
use Illuminate\Http\Request;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Model\Contracts\SurveyServiceInterface;
use App\Model\Contracts\SurveyRepositoryInterface;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SurveyControllerTest extends TestCase
{
	
	use DatabaseTransactions;
	
	protected $surveyService;
	protected $ansRepo;
	protected $user;
	protected $survey;
	protected $question;
	
	public function setUp() {
		
		parent::setUp();
		global $argv, $argc;
		//$this->token = 'ya29.Gl30BA__NSUdPWDsDkUhOnHRxkyvVdYJPsUHmB6Zypgxq6DWshfZNya1PntNID1Xypezb5MHOOLUeWSF4swNHOV-gdCr8g84gSG4pRYz6R-rna6ZBL14ke6uRyYDv8Y';
		$this->token = getenv('token');
		$this->surveyService = App::make(SurveyServiceInterface::class);
		$this->surveyRepo = App::make(SurveyRepositoryInterface::class);
		$this->user = factory(App\Model\Models\User::class)->create(['access_level' => 0, 'email' => 'tokavaliauskas@gmail.com']);	
		$this->survey = factory(App\Model\Models\Survey::class)->create(['user_id' => $this->user->id, 'icon' => 'fa-laptop']);
		$this->question = factory(App\Model\Models\Question::class)->create(['option1' => 1, 'option2' => 2, 'option3' => null, 'option4' => null,  'survey_id' => $this->survey->id]);

		
	}
	
	
	public function test_redirect_if_authenticated() {		
		
		$this->be($this->user);
		
		$response = $this->call('GET', \URL::to('/api/surveys/login'));

		$this->assertEquals(302, $response->getStatusCode());			
		
	}
	
	public function testCanAccessSmth()
	{
		
		$response = $this->call('GET', \URL::to('/page'));
		$this->assertEquals(404, $response->status());
		
	}
	
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_when_auth_token_is_not_set_api_returns_400()
    {
        
		$request = \Request::create('/api/surveys/' . $this->survey->id, 'GET');
		$request->headers->set('Accept', 'application/json');
		$response = app()->handle($request);		
		
		$this->assertEquals(400, $response->getStatusCode());
		
    }
	
    public function test_when_auth_token_is_set_but_incorrect_api_returns_401()
    {
        
		$request = \Request::create('/api/surveys/' . $this->survey->id, 'GET');
		$request->headers->set('AuthenticationToken', 'abc');
		$request->headers->set('Accept', 'application/json');
		$response = app()->handle($request);		
		
		$this->assertEquals(401, $response->getStatusCode());
		
    }	
	

	public function test_when_auth_token_is_set_and_correct_get_survey()
    {
        
		$request = \Request::create('/api/surveys/' . $this->survey->id, 'GET');
		$request->headers->set('AuthenticationToken', $this->token);
		$request->headers->set('Accept', 'application/json');
		$response = app()->handle($request);		
		
		$this->assertEquals(200, $response->getStatusCode());
		
    }
	
	public function test_when_auth_token_is_set_and_incorrect_survey_id()
    {
        
		$request = \Request::create('/api/surveys/' . 999, 'GET');
		$request->headers->set('AuthenticationToken', $this->token);
		$request->headers->set('Accept', 'application/json');
		$response = app()->handle($request);		
		
		$this->assertEquals(404, $response->getStatusCode());
		
    }	
	
    public function test_when_auth_token_is_not_set_store_api_returns_400()
    {
        
		$request = \Request::create('/api/surveys', 'POST');
		$request->headers->set('Accept', 'application/json');
		$response = app()->handle($request);		
		
		$this->assertEquals(400, $response->getStatusCode());
		
    }
	
    public function test_when_auth_token_is_set_but_incorrect_store_api_returns_401()
    {
        
		$request = \Request::create('/api/surveys', 'POST');
		$request->headers->set('AuthenticationToken', 'abc');
		$request->headers->set('Accept', 'application/json');
		$response = app()->handle($request);		
		
		$this->assertEquals(401, $response->getStatusCode());
		
    }

	public function test_when_auth_token_is_set_but_survey_data_is_incorrect_returns_400()
    {
		
		$request_data = new Request();
		$request_data->merge(['title' => 'abc', 'description' => 'abc']);
        
		$request = \Request::create('/api/surveys', 'POST', $request_data->all());
		$request->headers->set('AuthenticationToken', $this->token);
		$request->headers->set('Accept', 'application/json');
		$response = app()->handle($request);		
		
		$this->assertEquals(400, $response->getStatusCode());
		
    }	
	
	public function test_when_auth_token_is_set_but_but_has_no_questions_returns_400()
    {
		
		$request_data = new Request();
		$request_data->merge(['title' => 'abc', 'description' => 'abc', 'icon' => 'fa-laptop']);
        
		$request = \Request::create('/api/surveys', 'POST', $request_data->all());
		$request->headers->set('AuthenticationToken', $this->token);
		$request->headers->set('Accept', 'application/json');
		$response = app()->handle($request);		
		
		$this->assertEquals(400, $response->getStatusCode());
		
    }	

	public function test_when_auth_token_is_set_and_survey_is_correct_return_201()
    {
		
		$request_data = new Request();
		$request_data->merge(['title' => 'abc', 'description' => 'abc', 'icon' => 'fa-laptop', 'question_-100_title' => 'Klausimas', 'question_-100_option_1' => 'abc', 'question_-100_option_2' => 'aabc']);
        
		$request = \Request::create('/api/surveys', 'POST', $request_data->all());
		$request->headers->set('AuthenticationToken', $this->token);
		$request->headers->set('Accept', 'application/json');
		$response = app()->handle($request);		
		
		$this->assertEquals(201, $response->getStatusCode());
		
    }		
	
    public function test_when_auth_token_is_not_set_destroy_api_returns_400()
    {
        
		$request = \Request::create('/api/surveys/'.$this->survey->id, 'DELETE');
		$request->headers->set('Accept', 'application/json');
		$response = app()->handle($request);		
		
		$this->assertEquals(400, $response->getStatusCode());
		
    }
	
    public function test_when_auth_token_is_set_but_incorrect_destroy_api_returns_401()
    {
        
		$request = \Request::create('/api/surveys/'.$this->survey->id, 'DELETE');
		$request->headers->set('AuthenticationToken', 'abc');
		$request->headers->set('Accept', 'application/json');
		$response = app()->handle($request);		
		
		$this->assertEquals(401, $response->getStatusCode());
		
    }

	public function test_when_tries_to_delete_other_survey_gets_403()
    {
		
		$user2 = factory(App\Model\Models\User::class)->create(['access_level' => 0]);
		$user2->createToken('Authentication');
		$survey2 = factory(App\Model\Models\Survey::class)->create(['user_id' => $user2->id, 'icon' => 'fa-laptop']);
        
		$request = \Request::create('/api/surveys/'.$survey2->id, 'DELETE');
		$request->headers->set('AuthenticationToken', $this->token);
		$request->headers->set('Accept', 'application/json');
		$response = app()->handle($request);		
		
		$this->assertEquals(403, $response->getStatusCode());
		
    }
	
	public function test_when_tries_to_delete_his_own_survey_gets_200()
    {

		//dd($this->user->id == $this->survey->user->id);
		$request = \Request::create('/api/surveys/'.$this->survey->id, 'DELETE');
		$request->headers->set('AuthenticationToken', $this->token);
		$request->headers->set('Accept', 'application/json');
		$response = app()->handle($request);		
		
		$this->assertEquals(200, $response->getStatusCode());
		
    }

		/* UPDATE */
		
    public function test_when_auth_token_is_not_set_update_api_returns_400()
    {
        
		$request = \Request::create('/api/surveys/'.$this->survey->id, 'PUT');
		$request->headers->set('Accept', 'application/json');
		$response = app()->handle($request);		
		
		$this->assertEquals(400, $response->getStatusCode());
		
    }
	
    public function test_when_auth_token_is_set_but_incorrect_update_api_returns_401()
    {
        
		$request = \Request::create('/api/surveys/'.$this->survey->id, 'PUT');
		$request->headers->set('AuthenticationToken', 'abc');
		$request->headers->set('Accept', 'application/json');
		$response = app()->handle($request);		
		
		$this->assertEquals(401, $response->getStatusCode());
		
    }

	
	public function test_when_tries_to_update_other_survey_gets_403()
    {
		
		$user2 = factory(App\Model\Models\User::class)->create(['access_level' => 0]);
		$user2->createToken('Authentication');
		$survey2 = factory(App\Model\Models\Survey::class)->create(['user_id' => $user2->id, 'icon' => 'fa-laptop']);
        
		$request = \Request::create('/api/surveys/'.$survey2->id, 'PUT');
		$request->headers->set('AuthenticationToken', $this->token);
		$request->headers->set('Accept', 'application/json');
		$response = app()->handle($request);		
		
		$this->assertEquals(403, $response->getStatusCode());
		
    }
	
	
	public function test_when_tries_to_update_his_own_survey_but_data_incorrect_gets_400()
    {
        
		$request_data = new Request();
		$request_data->merge(['title' => 'abc', 'description' => 'abc']);		
		
		$request = \Request::create('/api/surveys/'.$this->survey->id, 'PUT', $request_data->all());
		$request->headers->set('AuthenticationToken', $this->token);
		$request->headers->set('Accept', 'application/json');
		$response = app()->handle($request);		
		
		$this->assertEquals(400, $response->getStatusCode());
		
    }	

	public function test_when_tries_to_update_his_own_survey_gets_200()
    {
        
		$request_data = new Request();
		$request_data->merge(['title' => 'abc', 'description' => 'abc', 'icon' => 'fa-laptop']);		
		
		$request = \Request::create('/api/surveys/'.$this->survey->id, 'PUT', $request_data->all());
		$request->headers->set('AuthenticationToken', $this->token);
		$request->headers->set('Accept', 'application/json');
		$response = app()->handle($request);		
		
		$this->assertEquals(200, $response->getStatusCode());
		
    }	

	/* ANSWER */
	
    public function test_when_auth_token_is_not_set_answer_api_returns_400()
    {
        
		$request = \Request::create('/api/surveys/'.$this->survey->id.'/answer', 'POST');
		$request->headers->set('Accept', 'application/json');
		$response = app()->handle($request);		
		
		$this->assertEquals(400, $response->getStatusCode());
		
    }
	
    public function test_when_auth_token_is_set_but_incorrect_answer_api_returns_401()
    {
        
		$request = \Request::create('/api/surveys/'.$this->survey->id.'/answer', 'POST');
		$request->headers->set('AuthenticationToken', 'abc');
		$request->headers->set('Accept', 'application/json');
		$response = app()->handle($request);		
		
		$this->assertEquals(401, $response->getStatusCode());
		
    }	
	
    public function test_when_auth_token_is_set_but_answer_survey_does_not_exist_gets_404()
    {
        
		$request = \Request::create('/api/surveys/900/answer', 'POST');
		$request->headers->set('AuthenticationToken', $this->token);
		$request->headers->set('Accept', 'application/json');
		$response = app()->handle($request);		
		
		$this->assertEquals(404, $response->getStatusCode());
		
    }	

    public function test_when_auth_token_is_set_but_answer_is_empty_get_400()
    {
		
		$request_data = new Request();
		$request_data->merge(['answer_' . $this->question->id => '']);
        
		$request = \Request::create('/api/surveys/'.$this->survey->id.'/answer', 'POST', $request_data->all());
		$request->headers->set('AuthenticationToken', $this->token);
		$request->headers->set('Accept', 'application/json');
		$response = app()->handle($request);		
		
		$this->assertEquals(400, $response->getStatusCode());
		
    }	

	public function test_when_auth_token_is_set_answer_is_correct_get_201()
    {
		
		$request_data = new Request();
		$request_data->merge(['answer_' . $this->question->id => 1]);
        
		$request = \Request::create('/api/surveys/'.$this->survey->id.'/answer', 'POST', $request_data->all());
		$request->headers->set('AuthenticationToken', $this->token);
		$request->headers->set('Accept', 'application/json');
		$response = app()->handle($request);		
		
		$this->assertEquals(201, $response->getStatusCode());
		
    }
	
	public function test_when_user_tries_to_answer_same_survey_twice_gets_401()
    {
		
		$request_data = new Request();
		$request_data->merge(['answer_' . $this->question->id => 1]);
        
		$request = \Request::create('/api/surveys/'.$this->survey->id.'/answer', 'POST', $request_data->all());
		$request->headers->set('AuthenticationToken', $this->token);
		$request->headers->set('Accept', 'application/json');
		$response = app()->handle($request);
        
		$request = \Request::create('/api/surveys/'.$this->survey->id.'/answer', 'POST', $request_data->all());
		$request->headers->set('AuthenticationToken', $this->token);
		$request->headers->set('Accept', 'application/json');
		$response = app()->handle($request);	
		
		$this->assertEquals(401, $response->getStatusCode());
		
    }

	
	/* INDEX */
	
	public function test_when_user_doesnt_have_auth_but_author_is_none_gets_200()
    {
        
		$request = \Request::create('/api/surveys', 'GET');
		$request->headers->set('Accept', 'application/json');
		$response = app()->handle($request);	
		
		$this->assertEquals(200, $response->getStatusCode());
		
    }	
	
	public function test_when_user_doesnt_have_auth_and_wants_author_surveys_gets_400()
    {
        
		$request = \Request::create('/api/surveys', 'GET');
		$request->headers->set('author', 'true');
		$request->headers->set('Accept', 'application/json');
		$response = app()->handle($request);	
		
		$this->assertEquals(400, $response->getStatusCode());
		
    }

	public function test_when_user_have_invalid_auth_and_wants_author_surveys_gets_401()
    {
        
		$request = \Request::create('/api/surveys', 'GET');
		$request->headers->set('author', 'true');
		$request->headers->set('AuthenticationToken', 'abc');
		$request->headers->set('Accept', 'application/json');
		$response = app()->handle($request);	
		
		$this->assertEquals(401, $response->getStatusCode());
		
    }
	
	public function test_when_user_have_valid_auth_and_wants_author_surveys_gets_200()
    {
        
		$request = \Request::create('/api/surveys', 'GET');
		$request->headers->set('author', 'true');
		$request->headers->set('AuthenticationToken', $this->token);
		$request->headers->set('Accept', 'application/json');
		$response = app()->handle($request);	
		
		$this->assertEquals(200, $response->getStatusCode());
		
    }

	public function test_when_user_have_valid_auth_and_wants_all_surveys_gets_200()
    {
        
		$request = \Request::create('/api/surveys', 'GET');
		$request->headers->set('AuthenticationToken', $this->token);
		$request->headers->set('Accept', 'application/json');
		$response = app()->handle($request);	
		
		$this->assertEquals(200, $response->getStatusCode());
		
    }
	
	public function test_when_user_have_valid_auth_and_wants_all_surveys_with_size_and_offset_gets_200()
    {
        
		$request = \Request::create('/api/surveys?size=10&offset=0', 'GET');
		$request->headers->set('AuthenticationToken', $this->token);
		$request->headers->set('Accept', 'application/json');
		$response = app()->handle($request);	
		
		$this->assertEquals(200, $response->getStatusCode());
		
    }	

}
