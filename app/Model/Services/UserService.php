<?php 
namespace App\Model\Services;

use App\Model\Contracts\UserServiceInterface;
use App\Model\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\Validator;
use App\Model\Contracts\AnsweredSurveyRepositoryInterface;

class UserService implements UserServiceInterface
{

    protected $userRepo;
	protected $ansSurveyRepo;
	
	private $validator;
	private $data;
	private $id;
	private $user;

    public function __construct(UserRepositoryInterface $userRepo, AnsweredSurveyRepositoryInterface $ansSurveyRepo)
    {
		
        $this->userRepo = $userRepo;
		$this->ansSurveyRepo = $ansSurveyRepo;
		
    }
	
	public function loginExists($email) {
		
		return $this->userRepo->getByEmail($email);
		
	}	
	
	public function register($name = null, $email = null, $auth_key = null) {
		
		if($name) {
			$this->data['name'] = $name;
		}
		
		if($email) {
			$this->data['email'] = $email;
		}

		if($auth_key) {
			$this->data['auth_key'] = $auth_key;
		}		
		
		$this->data['access_level'] = 0;
		
		$this->user = $this->userRepo->create($this->data);
		
		return $this->user;
		
	}	
	
	/*
	public function authExists($auth) {
		
		return $this->userRepo->getByAuth($auth);
		
	}*/
	
	
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

		$user = $this->get_content('https://www.googleapis.com/oauth2/v1/userinfo?access_token=' . $token);
		$user = json_decode($user);

		if($user && isset($user->id)) {
			$this->user = $this->userRepo->getByAuth($user->id);
			return $this->user;
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