<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Restaurants;
use App\Categories;
use App\Menu;
use App\Types;
use App\Review;
use App\VerifyUser;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Mail\VerifyMail;

class IndexController extends Controller
{
	

	public function resetSuccess()
	{
		    \Auth::logout();
		   
		   $status="Password Changed Successfully. Please Login to continue";
			
			return view('pages.password_reset',compact('status'));
			
	}	

    public function index()
    { 
    	
    	 
         $types=Types::orderBy('type')->get();  

         $restaurants = DB::table('restaurants')
                           ->leftJoin('restaurant_types', 'restaurants.restaurant_type', '=', 'restaurant_types.id')                           
                           ->select('restaurants.*','restaurant_types.type')
                           ->where('restaurants.review_avg', '>=', '4')
                           ->orderBy('restaurants.review_avg', 'desc')
                           ->take(6)
                           ->get();
        
          

        return view('pages.index',compact('restaurants','types'));
    }
    
    public function about_us()
    { 
                  
        return view('pages.about');
    }

    public function contact_us()
    {        
        return view('pages.contact');
    }

	public function verifyUser($token){
		$verifyUser = VerifyUser::where('token', $token)->first();
		if(isset($verifyUser) ){
		$user = $verifyUser->user;
		if(!$user->verified) {
		$verifyUser->user->verified = 1;
		$verifyUser->user->save();
		$status = "Your e-mail is verified. You can now login.";
		}else{
		$status = "Your e-mail is already verified. You can now login.";
		}
		}else{
		return redirect('/login')->with('warning', "Sorry your email cannot be identified.");
		}
		return redirect('/login')->with('status', $status);
}
  
    /**
     * Do user login
     * @return $this|\Illuminate\Http\RedirectResponse
     */
     
     public function login()
    { 
                   
        return view('pages.login');
    }

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
       return redirect('/login')->withErrors('The email or the password is invalid. Please try again.');
        
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

        return redirect('/'); 
    }
    
    
    /**
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        Auth::logout();

        \Session::flash('flash_message', 'Logout successfully...');

        return redirect('/login');
    }


    public function register()
    { 
                   
        return view('pages.register');
    }
	private function convertToBlank($array){
		
		foreach ($array as $key => $value) {
			if (is_null($value)) {
				 $array[$key] = "";
			}
		}
		return $array;
		
	}	
		public  function slugify($text)
{
		  // replace non letter or digits by -
		  $text = preg_replace('~[^\pL\d]+~u', '-', $text);

		  // transliterate
		  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

		  // remove unwanted characters
		  $text = preg_replace('~[^-\w]+~', '', $text);

		  // trim
		  $text = trim($text, '-');

		  // remove duplicate -
		  $text = preg_replace('~-+~', '-', $text);

		  // lowercase
		  $text = strtolower($text);

		  if (empty($text)) {
			return 'n-a';
		  }

		  return $text;
}

    public function register_user(Request $request)
    { 
        
        $data =  \Input::except(array('_token')) ;
        
        $inputs = $request->all();
        
        $rule=array(
		        'restaurent_name' => 'required',
				'restaurent_contact_no' => 'required',
                'name' => 'required',
				'owner_contact_no' => 'required',                
                'email' => 'required|email|max:75',
                'password' => 'required|min:3|confirmed'
                 );
		$messsages = array(
		'restaurent_name.required'=>'Restaurant name is required',
		'restaurent_contact_no.required'=>'Restaurant contact no is required',
                'name.required'=>'Owner name is required',
				'owner_contact_no.required'=>'Owner mobile no is required',
	     );
        
        
         $validator = \Validator::make($data,$rule, $messsages);
 
        if ($validator->fails())
        {
                return redirect()->back()->withErrors($validator->messages());
        } 
         $userInfo=User::where(['email'=>$request->email,'usertype'=>'Merchant'])->first();
		 if(!empty($userInfo)){
			 
			    return redirect()->back()->withErrors(['Email Address is already in use.']); 
			 
		 }
		 $userInfoM=User::where(['mobile_no'=>$request->input('owner_contact_no'),'usertype'=>'Merchant'])->first();
		 if(!empty($userInfoM)){
			 
			    $this->content['status']=false;
				$this->content['message'] = "Error in Registering User";
				$this->content['data']="Mobile No is already in use";
				$status = 200;
					
                return redirect()->back()->withErrors(['Mobile No is already in use.']);
				
			 
		 } 
       
       	if ($request->has('email') && $request->has('password')) {
			$user = new User;
			$user->email=$request->input('email');
			$user->first_name=$user->name= $request->input('name');
			$user->mobile_no=$request->input('owner_contact_no');
			//$user->device_id=$request->input('device_id');
			///$user->device=$request->input('device');
			if($request->input('profile_pic_url'))
			$user->profile_pic_url=$request->input('profile_pic_url');
					
			$user->usertype='Merchant';
            $user->status = 1;
			$user->password=bcrypt($request->input('password'));
			if($request->input('fcm_id')!=""){
				 $user->fcm_id=$request->input('fcm_id');
				 
			}
			
			if($user->save()){
				$userInfo=$user;
				
				$restronent= new Restaurants;
                $restronent->restaurant_id = "res" . substr($request->restaurent_name, 0,3) . rand(100000,999999) . substr($request->restaurent_name, 0,3);
				$restronent->restaurant_name=$request->restaurent_name;
				$restronent->restaurant_address=$request->restaurent_address;
				$restronent->user_id=$user->id;		
				$restronent->restaurant_slug=$this->slugify($request->restaurent_name).'-'.$user->id;			
				$restronent->restaurent_contact_no=$request->restaurent_contact_no;
				$restronent->save();
				$this->content['token'] =  $user->createToken('food App'.$user->id)->accessToken;
				$this->content['status']=true;
				$this->content['message'] = "Merchant Registered Successfully";
					
                $userInfo->mobile_verified=0;			
			   /* $otpInfo=$this->sendOTP($userInfo->mobile_no);
                $userInfo->otp=$otpInfo['otp'];*/
				$userInfo->save();
				
				$user=User::find($user->id)->toArray();		
				$responseData=$this->convertToBlank($user);
				$responseData['restaurant_id']=$restronent->id;
				$this->content['data']=$responseData;
				$status = 200;				
				$verifyUser = VerifyUser::create([
					'user_id' => $userInfo->id,
					'token' => str_random(40)
				]);
				
				\Mail::to($userInfo->email)->send(new VerifyMail($userInfo));				
				\Session::flash('flash_message', 'Registered Successfully.');				
				 return \Redirect::back();
				
			}else{

				\Session::flash('flash_message', 'Error in Registering...');

				return \Redirect::back();
			  
			}
		}
       

            

         
    }    

    public function profile()
    { 
        $user_id=Auth::user()->id;
        $user = User::findOrFail($user_id);

        return view('pages.profile',compact('user'));
    } 
    

    public function editprofile(Request $request)
    { 
        
        $data =  \Input::except(array('_token')) ;
        
        $inputs = $request->all();
        
        
            $rule=array(
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|email|max:75',
                'mobile' => 'required',
                'city' => 'required',
                'postal_code' => 'required',
                'address' => 'required'
                 );
       
        
         $validator = \Validator::make($data,$rule);
 
        if ($validator->fails())
        {
                return redirect()->back()->withErrors($validator->messages());
        } 
          
        $user_id=Auth::user()->id;
           
        $user = User::findOrFail($user_id);
 
         
        
        $user->first_name = $inputs['first_name']; 
        $user->last_name = $inputs['last_name'];       
        $user->email = $inputs['email'];
        $user->mobile = $inputs['mobile'];
        $user->city = $inputs['city'];
        $user->postal_code = $inputs['postal_code'];
        $user->address = $inputs['address'];         
         
         
        $user->save();
        
         
            \Session::flash('flash_message', 'Changes Saved');

            return \Redirect::back();
         
         
    }        

    public function change_password()
    { 
        
        return view('pages.change_password');
    }

        
     public function edit_password(Request $request)
    { 
        
        $data =  \Input::except(array('_token')) ;
        
        $inputs = $request->all();
        
        $rule=array(                
                'password' => 'required|min:3|confirmed'
                 );
        
        
        
         $validator = \Validator::make($data,$rule);
 
        if ($validator->fails())
        {
                return redirect()->back()->withErrors($validator->messages());
        } 
          
       
        $user_id=Auth::user()->id;
           
        $user = User::findOrFail($user_id);
       
        $user->password= bcrypt($inputs['password']);  
        
         
        $user->save(); 

            \Session::flash('flash_message', 'Password has been changed...');

            return \Redirect::back();

         
    } 
    public function subscribe(Request $request)
    { 
	 $inputs = $request->all();
	 \Session::flash('flash_message_subscribe', 'Thanks for subscribing us.');
	 
	        $data = array(
            'city' => $inputs['city'],
            'email' => $inputs['email'],
            );

            
		
			$subject="New User Subscription";
			
			$to=$inputs['email'];
           \Mail::send('emails.subscribe', $data, function ($message) use ($subject,$to){

                $message->from('admin@donalds.in', getcong('site_name'));

                $message->to('donaldslunchdelivery@gmail.com')->subject($subject);

            });

            return \Redirect::back();
	
	}

    public function contact_send(Request $request)
    { 
        
        $data =  \Input::except(array('_token')) ;
        
        $inputs = $request->all();
        
        $rule=array(                
                'name' => 'required',
                'email' => 'required|email|max:75'
                 );
        
        
        
         $validator = \Validator::make($data,$rule);
 
        if ($validator->fails())
        {
                return redirect()->back()->withErrors($validator->messages());
        } 
          
            $data = array(
            'name' => $inputs['name'],
            'email' => $inputs['email'],
            'phone' => $inputs['phone'],
            'subject' => $inputs['subject'],
            'user_message' => $inputs['message'],
             );

            
		
			$subject="New Contact us request Send";
			
			$to=$inputs['email'];
           \Mail::send('emails.contact', $data, function ($message) use ($subject,$to){

                $message->from('admin@donalds.in', getcong('site_name'));

                $message->to('donaldslunchdelivery@gmail.com')->subject($subject);

            });
        

            \Session::flash('flash_message_contact', 'Thank You for Your Request.');

            return \Redirect::back();         
    }  
}
