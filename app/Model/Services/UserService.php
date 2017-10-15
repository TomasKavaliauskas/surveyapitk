<?php 
namespace App\Model\Services;

use App\Model\Contracts\UserServiceInterface;
use App\Model\Contracts\UserRepositoryInterface;
use App\Model\Contracts\OauthRepositoryInterface;
use Illuminate\Support\Facades\Validator;
use App\Model\Contracts\AnsweredSurveyRepositoryInterface;

class UserService implements UserServiceInterface
{

    protected $userRepo;
	protected $ansSurveyRepo;
	protected $authRepo;
	
	private $validator;
	private $data;
	private $id;
	private $user;

    public function __construct(UserRepositoryInterface $userRepo, AnsweredSurveyRepositoryInterface $ansSurveyRepo, OauthRepositoryInterface $authRepo)
    {
		
        $this->userRepo = $userRepo;
		$this->ansSurveyRepo = $ansSurveyRepo;
		$this->authRepo = $authRepo;
		
    }
	
	public function validate($request) {
		
		$this->data['name'] = $request->input('name');
		$this->data['email'] = $request->input('email');
		$this->data['password'] = bcrypt($request->input('password'));
		
		$this->validator = Validator::make($request->all(), [
			'name' => 'required',
			'email' => 'required|unique:users|email',
			'password' => 'required',
			'password_match' => 'required|same:password'
		]);
		
		return !$this->validator->fails();		
		
	}
	
	public function errors(){
		
		return $this->validator != null ? $this->validator : null;
		
	}
	
	public function loginExists($email, $password) {
		
		return $this->userRepo->getByEmail($email, $password);
		
	}	
	
	public function register() {
		
		$this->data['access_level'] = 0;
		
		$user = $this->userRepo->create($this->data);
		
		\Auth::login($user);
		
		return $user;
		
	}	
	
	public function authExists($auth) {
		
		return $this->userRepo->getByAuth($auth);
		
	}
	
	private function get_content($URL){
		  $ch = curl_init();
		  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		  curl_setopt($ch, CURLOPT_URL, $URL);
		  $data = curl_exec($ch);
		  curl_close($ch);
		  return $data;
	}
	
	public function getUserId() {
		
		return $this->user->id;
		
	}
	
	public function get($id) {
		
		return $this->userRepo->get($id);
		
	}
	
	public function isTokenValid($token) {
		
		$auth = $this->authRepo->get($token);
		
		if($auth) {
			
			$this->user = $this->get($auth->user_id);
			return true;
			
		}
		
		return "Token is invalid";
		
	}
	
	public function hasAnswered($userId, $surveyId) {
		
		$user = $this->userRepo->get($userId);
		
		foreach($user->answered_surveys as $survey) {
			
			if($survey->survey_id == $surveyId) return true;
			
		}
		
		return false;
		
	}

}