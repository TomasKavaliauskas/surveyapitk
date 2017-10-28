<?php

namespace Tests\Unit;

use App;
use App\Model\Models\Answer;
use Illuminate\Http\Request;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Model\Contracts\AnswerServiceInterface;
use App\Model\Contracts\UserServiceInterface;
use App\Model\Contracts\AnswerRepositoryInterface;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AnswerServiceTest extends TestCase
{
	
	use DatabaseTransactions;
	
	protected $ansService;
	protected $userService;
	protected $ansRepo;
	protected $user;
	
	public function setUp() {
		
		parent::setUp();
		$this->ansService = App::make(AnswerServiceInterface::class);
		$this->userService = App::make(UserServiceInterface::class);
		$this->ansRepo = App::make(AnswerRepositoryInterface::class);
		$this->survey = factory(App\Model\Models\Survey::class)->create(['user_id' => null, 'icon' => 'fa-laptop']);
		$this->question = factory(App\Model\Models\Question::class)->create(['option1' => 1, 'option2' => 2, 'option3' => null, 'option4' => null,  'survey_id' => $this->survey->id]);
		$this->user = factory(App\Model\Models\User::class)->create(['access_level' => 0]);
		
	}
	
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_when_answer_option_is_not_set_validator_fails()
    {
        
		$request = new Request();
		
		$request->merge([]);
		
		$this->assertFalse($this->ansService->validate($request));
		
		$errorMessages = $this->ansService->errors()->errors()->getMessages();
		
		$this->assertArrayHasKey('option', $errorMessages);
		$this->assertCount(1, $errorMessages);
		
    }
	
    public function test_when_answer_option_is_not_correct_validator_fails()
    {
        
		$request = new Request();
		
		$request->merge(['option' => "abc"]);
		
		$this->assertFalse($this->ansService->validate($request));
		
		$errorMessages = $this->ansService->errors()->errors()->getMessages();
		
		$this->assertArrayHasKey('option', $errorMessages);
		$this->assertCount(1, $errorMessages);
		
    }

    public function test_when_answer_option_is_not_in_correct_range_validator_fails()
    {
        
		$request = new Request();
		
		$request->merge(['option' => 5]);
		
		$this->assertFalse($this->ansService->validate($request));
		
		$errorMessages = $this->ansService->errors()->errors()->getMessages();
		
		$this->assertArrayHasKey('option', $errorMessages);
		$this->assertCount(1, $errorMessages);
		
    }

	public function test_when_answer_option_is_correct_validator_succeeds()
    {
        
		$request = new Request();
		
		$request->merge(['option' => 2]);
		
		$this->assertTrue($this->ansService->validate($request));
		
		$errorMessages = $this->ansService->errors()->errors()->getMessages();

		$this->assertCount(0, $errorMessages);
		
    }
	
	public function test_when_answer_is_correct_add_it_to_database()
    {
        
		$request = new Request();
		
		$request->merge(['option' => 2]);
		
		$this->assertTrue($this->ansService->validate($request));
		
		$errorMessages = $this->ansService->errors()->errors()->getMessages();

		$this->assertCount(0, $errorMessages);
		
		$this->assertNotNull($this->ansService->store(2, $this->user->id, $this->question->id, $this->survey->id));
		
    }	
	
	public function test_when_user_answers_question_it_belongs_to_him()
    {
        
		$request = new Request();
		
		$request->merge(['option' => 2]);
		
		$this->assertTrue($this->ansService->validate($request));
		
		$errorMessages = $this->ansService->errors()->errors()->getMessages();

		$this->assertCount(0, $errorMessages);
		$this->assertFalse($this->userService->hasAnswered($this->user->id, $this->survey->id));
		$answer_id = $this->ansService->store(2, $this->user->id, $this->question->id, $this->survey->id);
		
		$answer = $this->ansRepo->get($answer_id);
		
		$this->assertEquals($this->user->id, $answer->user->id);
		$this->assertEquals($this->survey->id, $answer->survey->id);
		$this->assertEquals($this->question->id, $answer->question->id);
		$this->assertEquals(1, count($this->user->answers));
		$this->assertEquals(1, count($this->user->answered_surveys));
		$this->assertTrue($this->userService->hasAnswered($this->user->id, $this->survey->id));
		
    }
	
}
