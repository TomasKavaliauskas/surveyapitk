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
	protected $token;
	
	public function setUp() {
		
		parent::setUp();
		$this->token = getenv('token');
		$this->userService = App::make(UserServiceInterface::class);
		$this->userRepo = App::make(UserRepositoryInterface::class);
	
	}
	
    public function test_when_user_is_set_validator_succeeds()
    {
		
		$user = $this->userService->register('tomas', 'tokavaliauskas@gmail.com', '109511313140306130594');
		
		$user = $this->userService->get($this->userService->getUserId());
		$this->assertNotNull($user);

		$this->assertEquals($user, $this->userService->isTokenValid($this->token));
		$this->assertEquals('Token is invalid', $this->userService->isTokenValid('fake'));
		
    }	

    public function test_when_user_is_registered_get_by_email_method_returns_it()
    {
		
		$this->assertFalse($this->userService->loginExists('tokavaliauskas@gmail.com.com'));
		
		$user = $this->userService->register('tomas', 'tokavaliauskas@gmail.com', '109511313140306130594');
		
		$user = $this->userService->loginExists('tokavaliauskas@gmail.com');
		$this->assertNotNull($user);
		
    }	
	
}
