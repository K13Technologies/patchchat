<?php

namespace App\Http\Controllers\Auth;

//use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

use App\Models\User;
use App\Models\Industry;
use Illuminate\Http\Request as Request;
use Input;
use Mail;
use Config;
use Auth;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6',
            'g-recaptcha-response' => 'required|recaptcha',		
        ]);
    }       

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {        
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
    
    public function postRegister(Request $request, Industry $industry = null)
	{   
	    $input = Input::all();
	    $validator = $this->validator($input);
		if ($validator->fails())
		{
			$this->throwValidationException(
				$request, $validator
			);
		}
		$user = $this->create($input);
		
		if($industry and $industry->id) {
	        $user->industry()->attach($industry);
	    }
	    
	    Mail::send('emails.registration', [
		    'user' => $user		    
	    ], function ($m) use ($user) {
            $m->to($user->email);
            $m->from(Config::get("email.from_email"), Config::get("email.from_name"));
            //$m->replyTo($email);
            $m->subject("Welcome to PatchChat");
        });
        
		Auth::login($user);
		
		return redirect()->intended($this->redirectPath());
    }
    
     public function mypostLogin(Request $request)
    {
        $this->validate($request, [
            'g-recaptcha-response' => 'required|recaptcha',
        ]);
        return $this->postLogin($request);
    }
}
