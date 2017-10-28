<?php

namespace Tests\Unit;

use App;
use App\Model\Models\Answer;
use Illuminate\Http\Request;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Model\Contracts\QuestionServiceInterface;
use App\Model\Contracts\QuestionRepositoryInterface;
use App\Model\Contracts\AnswerServiceInterface;
use App\Model\Contracts\AnswerRepositoryInterface;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class QuestionServiceTest extends TestCase
{
	
	use DatabaseTransactions;
	
	protected $questionService;
	protected $questionRepo;
	protected $ansService;
	protected $ansRepo;	
	protected $user;
	
	public function setUp() {
		
		parent::setUp();
		$this->questionService = App::make(QuestionServiceInterface::class);
		$this->questionRepo = App::make(QuestionRepositoryInterface::class);
		$this->ansService = App::make(AnswerServiceInterface::class);
		$this->ansRepo = App::make(AnswerRepositoryInterface::class);		
		$this->survey = factory(App\Model\Models\Survey::class)->create(['user_id' => null, 'icon' => 'fa-laptop']);
		$this->user = factory(App\Model\Models\User::class)->create(['access_level' => 0]);
		
	}
	
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_when_question_is_not_fully_described_validator_fails()
    {
        
		$request = new Request();
		
		$request->merge(['question_-100_option_1' => 'opt1', 'question_-100_option_2' => 'opt2']);
		
		$this->assertFalse($this->questionService->validate($request, -100, $this->survey->id));
		
		$errorMessages = $this->questionService->errors()->getMessages();
		
		$this->assertArrayHasKey('question_-100_title', $errorMessages);
		$this->assertCount(1, $errorMessages);
		
    }
	
    public function test_when_question_is_fully_described_validator_succeeds_and_it_has_no_answers()
    {
        
		$request = new Request();
		
		$request->merge(['question_-100_title' => 'klausimas', 'question_-100_option_1' => 'opt1', 'question_-100_option_2' => 'opt2']);
		
		$this->assertTrue($this->questionService->validate($request, -100, $this->survey->id));
		
		$errorMessages = $this->questionService->errors()->getMessages();
		$this->assertCount(0, $errorMessages);
		
		$question_id = $this->questionService->store();
		$this->assertNotNull($question_id);
		
		$question = $this->questionService->get($question_id);
		$this->assertNotNull($question);
		
		
		$request = new Request();
		$request->merge(['option' => 1]);
		$this->assertTrue($this->ansService->validate($request));
		$this->assertNotNull($this->ansService->store(1, $this->user->id, $question->id, $this->survey->id));		
		
		$request = new Request();
		$request->merge(['option' => 2]);
		$this->assertTrue($this->ansService->validate($request));
		$this->assertNotNull($this->ansService->store(2, $this->user->id, $question->id, $this->survey->id));

		$request = new Request();
		$request->merge(['option' => 3]);
		$this->assertTrue($this->ansService->validate($request));
		$this->assertNotNull($this->ansService->store(3, $this->user->id, $question->id, $this->survey->id));

		$request = new Request();
		$request->merge(['option' => 4]);
		$this->assertTrue($this->ansService->validate($request));
		$this->assertNotNull($this->ansService->store(4, $this->user->id, $question->id, $this->survey->id));	
		
		$questions = $this->questionService->countVotes($this->survey->questions);
		
		$this->assertEquals(1, $questions[0]->option1_votes);
		
    }	
	
	
}
