<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\Http\Requests;
use App\User;
use App\Review;
use App\Order;
use App\Restaurants;
use Illuminate\Http\Request;

class IndexController extends MainAdminController
{
	
    public function index()
    {   
    	if (Auth::check()) {
                        
            return redirect('admin/dashboard'); 
        }
 
        return view('admin.index');
    }
	
	/**
     * Do user login
     * @return $this|\Illuminate\Http\RedirectResponse
     */
	 
    public function postLogin(Request $request)
    {
    	
    //echo bcrypt('123456');
    //exit;	
    	
      $this->validate($request, [
            'email' => 'required|email', 'password' => 'required',
        ]);


        $credentials = $request->only('email', 'password');

		 
		
         if (Auth::attempt($credentials, $request->has('remember'))) {

            if(Auth::user()->usertype=='banned'){
                \Auth::logout();
                return array("errors" => 'You account has been banned!');
            }

            return $this->handleUserWasAuthenticated($request);
        }

       // return array("errors" => 'The email or the password is invalid. Please try again.');
        //return redirect('/admin');
       return redirect('/admin')->withErrors('The email or the password is invalid. Please try again.');
        
    }
    
     /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  bool  $throttles
     * @return \Illuminate\Http\Response
     */
    protected function handleUserWasAuthenticated(Request $request)
    {

        if (method_exists($this, 'authenticated')) {
            return $this->authenticated($request, Auth::user());
        }

        return redirect('admin/dashboard'); 
    }
    
    
    /**
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        Auth::logout();

        return redirect('admin/');
    }


    
    public function temp()
    {
        // echo "<pre>";
        $total_orders = Order::where(['user_id'=>31 , 'restaurant_id'=>15])->count();
        $total_completed = Order::where(['user_id'=>49 , 'restaurant_id'=>20 , 'status'=>'Completed'])->count();
        echo "total ordres : " . $total_orders . "<br>";
        echo "total ordres : " . $total_completed . "<br>";

        $total_review = Review::where(['user_id'=>31 , 'restaurant_id'=>15])->count();
        echo "total reviews : " . $total_review . "<br>";

    }
    	
}
