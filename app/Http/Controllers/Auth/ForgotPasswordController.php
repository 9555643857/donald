<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
	public function __construct()
    {
        $this->middleware('guest');
    }

	
public function sendResetLinkEmail(Request $request)
{
    $this->validate($request, ['email' => 'required|email']);

    // We will send the password reset link to this user. Once we have attempted
    // to send the link, we will examine the response then see the message we
    // need to show to the user. Finally, we'll send out a proper response.
	
	view()->share('usertype', strtolower($request->input('usertype')));

    $response = $this->broker()->sendResetLink(
        ['email'=>$request->input('email'),'usertype'=>ucfirst($request->input('usertype'))], $this->resetNotifier() 
    );
   $data= \DB::table('password_resets')
            ->where('email', $request->only('email'))
            ->update(['usertype' => strtolower($request->input('usertype'))]);

    switch ($response) {
        case \Password::RESET_LINK_SENT:
		 $this->content['status']=true;
		 $this->content['message'] = "Reset email Send Successfully";
		 $this->content['data']="";
		 $status = 200;
         return response()->json($this->content, $status);

        case \Password::INVALID_USER:
        default:
         $this->content['status']=false;
		 $this->content['message'] = "Invalid email id";
		 $this->content['data']="";
		 $status = 200;
         return response()->json($this->content, $status);
    }
}

// overwritte function resetNotifier() on trait SendsPasswordResetEmails
protected function resetNotifier()
{
    return function($token){
		
        return new ResetPasswordNotification($token);
    };
}
}
