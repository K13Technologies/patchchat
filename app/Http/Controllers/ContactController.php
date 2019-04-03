<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Email;
use Form;
use Input;
use Redirect;
use Mail;
use Config;

class ContactController extends Controller
{
    protected $emailRules = [
		'subject' => ['required'],		
		'name' => ['required'],	
		'email' => ['required'],	
		'message' => ['required'],
		'g-recaptcha-response' => 'required|recaptcha',		
	];
    
    protected $advertisingRules = [
		'company' => ['required'],
		'industry' => ['required'],
		'name' => ['required'],	
		'email' => ['required'],	
		'budget' => ['required'],
		'message' => ['required'],
		'g-recaptcha-response' => 'required|recaptcha',
	];

    /**
     * contact form
     *
     * @return Response
     */
    public function index()
    {
        return view('contact.index');        
    }

    /**
     * Show the contact form 
     *
     * @return Response
     */
    public function contact()
    {        
        return view('contact.contact');        
    }

    /**
     * send contact request
     *
     * @return Response
     */
    public function send(Request $request)
    {
        $messages = [
            'g-recaptcha-response.required' => 'Please check I am not a robot checkbox, just to be sure!',
        ];
	    $this->validate($request, $this->emailRules, $messages);
		
		$input = Input::all();
	    
	    $name = $input['name'];
	    $email = $input['email'];
	    $subject = $input['subject'];
	    $body = nl2br(htmlspecialchars($input['message']));
	    
		Mail::send('emails.contact', [
		    'name' => $name,
		    'email' => $email,
		    'body' => $body,
		    'subject' => $subject  
	    ], function ($m) use ($name, $email, $subject) {
            $m->to(Config::get("email.contact"));
            $m->from(Config::get("email.from_email"), $name);
            $m->replyTo($email);
            $m->subject($subject);
        });
        return view('contact.sent');        		
    }

    /**
     * Show the contact form  for advertising
     *
     * @return Response
     */
    public function advertising()
    {        
        return view('advertising.contact');        
    }

    /**
     * send contact request
     *
     * @return Response
     */
    public function advertisingSend(Request $request)
    {
        $messages = [
            'g-recaptcha-response.required' => 'Please check I am not a robot checkbox, just to be sure!',
        ];
	    $this->validate($request, $this->advertisingRules, $messages);
		
		$input = Input::all();
	    
	    $name = $input['name'];
	    $email = $input['email'];
	    $body = nl2br(htmlspecialchars($input['message']));
	    
		Mail::send('emails.advertising-contact', [
		    'name' => $name,
		    'email' => $email,
		    'body' => $body,
		    'input' => $input  
	    ], function ($m) use ($name, $email) {
            $m->to(Config::get("email.contact"));
            $m->from(Config::get("email.from_email"), $name);
            $m->replyTo($email);
            $m->subject("Advertising Inquiry");
        });
        return view('contact/advertising-sent');        		
    }
}
