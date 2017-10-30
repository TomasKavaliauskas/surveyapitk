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


	
	public function register() {
		$data['current_page'] = request()->segment(1);
		return view('frontend.register', $data);
		
	}
	
	public function store(Request $request) {
		$data['current_page'] = request()->segment(1);
		if($this->userService->validate($request)) {
			
			$user = $this->userService->register();
			$token = $user->createToken('Authentication')->accessToken;
			\Cookie::queue('authToken', json_encode(['token' => $token]), 36000);
			return redirect('/');
			
		}
		
		return back()->withInput()->with('error', 'Ne visi laukai uzpildyti');
		
	}
	
	public function login() {
		$data['current_page'] = request()->segment(1);
		return view('frontend.login', $data);
		
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
	
    public function redirectToGoogleProvider()
    {
		
		session(['web' => false]);
        return Socialite::driver('google')->with(['web' => false])->redirect();
		
    }

	public function redirectToGoogleProviderWeb()
    {
		
		session(['web' => true]);
        return Socialite::driver('google')->with(['web' => true])->redirect();
		
    }	
	
	public function handleGoogleProviderCallback()
    {
		
        $user = Socialite::driver('google')->user();
		
		$regUser = $this->userService->loginExists($user->getEmail());

		if(!$regUser) {
			
			$regUser = $this->userService->register($user->getName(), $user->getEmail(), $user->getId());
			 
		}
		
		if(!session('web')) {
			session()->flush();
			return response()->json([
				'access_token' => $user->token
			]);
		
		}
		session()->flush();
		\Cookie::queue('authToken', json_encode(['token' => $user->token]), 36000);

		\Auth::login($regUser);
		return redirect('/');

    }
	
	public function logout() {
		
		\Cookie::queue(\Cookie::forget('authToken'));
		\Auth::logout();
		return redirect('/');
		
	}	

}
   
   
   
