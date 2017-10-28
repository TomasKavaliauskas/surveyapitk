<?php

namespace Tests\Unit;

use App;
use App\Model\Models\Answer;
use Illuminate\Http\Request;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Model\Contracts\UserServiceInterface;
use App\Model\Contracts\UserRepositoryInterface;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserServiceTest extends TestCase
{
	
	use DatabaseTransactions;
	
	protected $userService;
	protected $userRepo;
	protected $user;
	
	public function setUp() {
		
		parent::setUp();
		$this->userService = App::make(UserServiceInterface::class);
		$this->userRepo = App::make(UserRepositoryInterface::class);
	
	}
	
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_when_user_is_not_set_validator_fails()
    {
        
		$request = new Request();
		
		$request->merge(['name' => 'abc', 'password' => 'abc', 'password_match' => 'abc']);
		
		$this->assertFalse($this->userService->validate($request));
		
		$errorMessages = $this->userService->errors()->errors()->getMessages();
		
		$this->assertArrayHasKey('email', $errorMessages);
		$this->assertCount(1, $errorMessages);
		
    }
	
    public function test_when_user_is_set_validator_succeeds()
    {
        
		$request = new Request();
		
		$request->merge(['name' => 'abc', 'password' => 'abc', 'password_match' => 'abc', 'email' => 'abc@gmail.com']);
		
		$this->assertTrue($this->userService->validate($request));
		
		$errorMessages = $this->userService->errors()->errors()->getMessages();

		$this->assertCount(0, $errorMessages);
		
		$user = $this->userService->register();
		$token = $user->createToken('Authentication')->accessToken;
		
		$user = $this->userService->get($this->userService->getUserId());
		$this->assertNotNull($user);

		$this->assertTrue($this->userService->isTokenValid($user->oauth_access_token->id));
		$this->assertEquals('Token is invalid', $this->userService->isTokenValid('fake'));
		
    }	

    public function test_when_user_is_registered_get_by_email_method_returns_it()
    {
        
		$request = new Request();
		
		$request->merge(['name' => 'abc', 'password' => 'abc', 'password_match' => 'abc', 'email' => 'abc@gmail.com']);
		
		$this->assertTrue($this->userService->validate($request));
		
		$errorMessages = $this->userService->errors()->errors()->getMessages();

		$this->assertCount(0, $errorMessages);
		
		$this->assertFalse($this->userService->loginExists('abc@gmail.com'));
		
		$user = $this->userService->register();
		
		$user = $this->userService->loginExists('abc@gmail.com');
		$this->assertNotNull($user);
		
    }	
	
}
