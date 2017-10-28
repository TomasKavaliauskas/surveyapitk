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

class SurveyServiceTest extends TestCase
{
	
	use DatabaseTransactions;
	
	protected $surveyService;
	protected $ansRepo;
	protected $user;
	
	public function setUp() {
		
		parent::setUp();
		$this->surveyService = App::make(SurveyServiceInterface::class);
		$this->surveyRepo = App::make(SurveyRepositoryInterface::class);
		$this->user = factory(App\Model\Models\User::class)->create(['access_level' => 0]);
		
	}
	
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_when_survey_is_not_fully_described_validator_fails()
    {
        
		$request = new Request();
		
		$request->merge(['title' => 'pavadinimas', 'description' => 'aprasymas']);
		
		$this->assertFalse($this->surveyService->validate($request));
		
		$errorMessages = $this->surveyService->errors()->getMessages();
		
		$this->assertArrayHasKey('icon', $errorMessages);
		$this->assertCount(1, $errorMessages);
		
    }
	
    public function test_when_survey_is_fully_described_validator_succeeds()
    {
        
		$request = new Request();
		
		$request->merge(['title' => 'pavadinimas', 'description' => 'aprasymas', 'icon' => 'fa-laptop']);
		
		$this->assertTrue($this->surveyService->validate($request));
		
		$errorMessages = $this->surveyService->errors()->getMessages();

		$this->assertCount(0, $errorMessages);
		
		$survey_id = $this->surveyService->store($this->user->id);
		
		$this->assertNotNull($survey_id);
		
    }

	public function test_when_survey_is_stored_it_has_one_record_in_database()
    {
        
		$request = new Request();
		
		$request->merge(['title' => 'pavadinimas', 'description' => 'aprasymas', 'icon' => 'fa-laptop']);
		
		$this->assertTrue($this->surveyService->validate($request));
		
		$errorMessages = $this->surveyService->errors()->getMessages();

		$this->assertCount(0, $errorMessages);
		
		$survey_id = $this->surveyService->store($this->user->id);
		
		$this->assertNotNull($survey_id);
		
		$this->assertEquals(1, count($this->surveyService->all(9999, 0)));
		
    }
	
	public function test_when_survey_is_deleted_there_is_no_records_in_database()
    {
        
		$request = new Request();
		
		$request->merge(['title' => 'pavadinimas', 'description' => 'aprasymas', 'icon' => 'fa-laptop']);
		
		$this->assertTrue($this->surveyService->validate($request));
		
		$errorMessages = $this->surveyService->errors()->getMessages();

		$this->assertCount(0, $errorMessages);
		
		$survey_id = $this->surveyService->store($this->user->id);
		
		$this->assertNotNull($survey_id);
		
		$this->assertEquals(1, count($this->surveyService->all(9999, 0)));
		
		$this->surveyService->delete($survey_id);
		
		$this->assertEquals(0, count($this->surveyService->all(9999, 0)));
		
    }	
	
	public function test_when_survey_is_updated_it_has_a_new_title()
    {
        
		$request = new Request();
		
		$request->merge(['title' => 'pavadinimas', 'description' => 'aprasymas', 'icon' => 'fa-laptop']);
		
		$this->assertTrue($this->surveyService->validate($request));
		
		$errorMessages = $this->surveyService->errors()->getMessages();

		$this->assertCount(0, $errorMessages);
		
		$survey_id = $this->surveyService->store($this->user->id);
		
		$this->assertNotNull($survey_id);
		
		$request = new Request();
		
		$request->merge(['title' => 'pavadinimas2', 'description' => 'aprasymas', 'icon' => 'fa-laptop']);
		
		$this->assertTrue($this->surveyService->validate($request));
		$this->surveyService->update($survey_id);
		
		$survey = $this->surveyService->get($survey_id);
		
		$this->assertEquals('pavadinimas2', $survey->title);
		
    }

	public function test_when_survey_is_created_user_has_one_created_survey()
    {
        
		$request = new Request();
		
		$request->merge(['title' => 'pavadinimas', 'description' => 'aprasymas', 'icon' => 'fa-laptop']);
		
		$this->assertTrue($this->surveyService->validate($request));
		
		$errorMessages = $this->surveyService->errors()->getMessages();

		$this->assertCount(0, $errorMessages);
		
		$survey_id = $this->surveyService->store($this->user->id);
		
		$this->assertNotNull($survey_id);
		
		$this->assertEquals(1, count($this->surveyService->userCreatedSurveys($this->user->id, 9999, 0)));
		
		$this->assertEquals(1, count($this->user->surveys));
		
    }	
	
}
