<?php

namespace App\Http\Controllers\Frontend;
use App\Model\Contracts\UserServiceInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Socialite;

class AuthController extends Controller
{
	
	protected $userService;
	
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserServiceInterface $userService)
    {
		$this->userService = $userService;
        $this->middleware('guest')->except('logout');
    }	
/*
   public function redirectToGoogleProvider()
    {
		
        return Socialite::driver('google')->redirect();
		
    }
	*/
	public function register() {
		
		return view('frontend.register');
		
	}
	
	public function store(Request $request) {
		
		if($this->userService->validate($request)) {
			
			$user = $this->userService->register();
			$token = $user->createToken('Authentication')->accessToken;
			\Cookie::queue('authToken', json_encode(['token' => $token]), 36000);
			return redirect('/');
			
		}
		
		return back()->withInput()->with('error', 'Ne visi laukai uzpildyti');
		
	}
	
	public function login() {
		
		return view('frontend.login');
		
	}
	
	public function logUserIn(Request $request) {
		
		if (\Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {
			
			$token = $this->userService->get(\Auth::id())->oauth_access_token->id;
			\Cookie::queue('authToken', json_encode(['token' => $token]), 36000);
            return redirect('/');
			
        }else{
			
			return back()->withInput()->with('error', 'Nera tokio vartotojo');
			
		}
		
	}
	
	/*

    public function handleGoogleProviderCallback()
    {
		
        $user = Socialite::driver('google')->user();
		
		$regUser = $this->userService->loginExists($user->getEmail());

		\Cookie::queue('token', $user->token, 36000);
		if(!$regUser) {
			
			$this->userService->register($user->getName(), $user->getEmail(), $user->getId());
			 
		}else{
			
			\Auth::login($regUser);
			
		}
		
		return redirect('/');

    }	*/
	
	public function logout() {
		
		\Cookie::queue(\Cookie::forget('token'));
		\Auth::logout();
		return redirect('/');
		
	}	

}
   
   
   
