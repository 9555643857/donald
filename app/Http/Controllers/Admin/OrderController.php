<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Session;
use App\User;
use App\Order;
use App\Categories;
use App\Restaurants;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image; 


class OrderController extends MainAdminController
{
	public function __construct()
    {
		 $this->middleware('auth');
		  
		parent::__construct(); 	
		  
    }
    public function orderlist($id)    { 
        
              
        $order_list = Order::where("restaurant_id", $id)->orderBy('id','desc')->orderBy('created_date','desc')->get();
        
        if(Auth::User()->usertype!="Admin"){

            \Session::flash('flash_message', 'Access denied!');

            return redirect('admin/dashboard');
            
        }
        
        $restaurant_id=$id; 

        return view('admin.pages.order_list',compact('order_list','restaurant_id'));
    }
    
    public function alluser_order()    { 
        
        // $data = DB::table('restaurant_order')
        //     ->join()

        // die();

        $order_list = Order::orderBy('id','desc')->get();

        if(Auth::User()->usertype!="Admin"){

            \Session::flash('flash_message', 'Access denied!');

            return redirect('admin/dashboard');
            
        }

        // echo "<pre>";
        // print_r($order_list);
        // die();

        return view('admin.pages.order_list_for_all',compact('order_list'));
    }

    public function order_status($id,$order_id,$status)   
    { 
         
        $order = Order::findOrFail($order_id);

        $order->status = $status; 
        $user_details = User::findOrFail($order->user_id); 
        if($order->status == "Processing")
        {
            if($user_details->mobile_no != "")
            {
                $otpInfo = $this->sendMsg($user_details->mobile_no , "Processing");   
            }
            else
            {
                \Session::flash('flash_message', 'Status change but, user mobile numebr not found');

                return \Redirect::back(); 
            }            
        }
        elseif ($order_status = "Completed") {
           $restaurent_details = Restaurants::findOrFail($order->restaurant_id);
    

            if($restaurent_details->delivery_time != "")
            {
                $to_time=strtotime("+$restaurent_details->delivery_time minutes",strtotime($order->created_at));
                $from_time = strtotime(date("Y-m-d H:i:s"));
                $diff =  round(($to_time - $from_time) / 60,2)." minute";
                if($diff < 20)
                    $otpInfo = $this->sendMsg($user_details->mobile_no , "Completed",20);
                else
                    $otpInfo = $this->sendMsg($user_details->mobile_no , "Completed",$diff);

            }
            else
            {
                \Session::flash('flash_message', 'Status change but, user mobile numebr not found');

                return \Redirect::back(); 
            }         
        }
         
        $order->save();
        
        
            \Session::flash('flash_message', 'Status change');

            return \Redirect::back();
        
    } 
     
    public function delete($id,$order_id)
    {
        if(Auth::User()->usertype!="Admin"){

            \Session::flash('flash_message', 'Access denied!');

            return redirect('admin/dashboard');
            
        }
            
        $order = Order::findOrFail($order_id);
        $order->delete();

        \Session::flash('flash_message', 'Deleted');

        return redirect()->back();

    } 
    

    public function owner_orderlist()    { 
        
         $user_id=Auth::User()->id;

         $restaurant= Restaurants::where('user_id',$user_id)->first();

         $restaurant_id=$restaurant['id'];
 

        $order_list = Order::where("restaurant_id", $restaurant_id)->orderBy('created_date')->get();
        
        if(Auth::User()->usertype!="Owner"){

            \Session::flash('flash_message', 'Access denied!');

            return redirect('admin/dashboard');
            
        }
        
         

        return view('admin.pages.owner.order_list',compact('order_list','restaurant_id'));
    }

    public function owner_order_status($order_id,$status)   
    { 
         
        $order = Order::findOrFail($order_id);

        

        $order->status = $status; 
         
        
         
        $order->save();
        
        
            \Session::flash('flash_message', 'Status change');

            return \Redirect::back();
        
    } 

    public function owner_delete($order_id)
    {
        if(Auth::User()->usertype!="Owner"){

            \Session::flash('flash_message', 'Access denied!');

            return redirect('admin/dashboard');
            
        }
            
        $order = Order::findOrFail($order_id);
        $order->delete();

        \Session::flash('flash_message', 'Deleted');

        return redirect()->back();

    } 

    private function sendMsg($mobile_no , $status, $time)
    {
        //Your authentication key
        $authKey = "226344As0L5erym55b4c4ec1";

        //check whether mobile number contains +91 or not
        $sub = substr($mobile_no, 0, 3);
        if ($sub == "+91")
            $mobile_no = substr($mobile_no, 3);


        //Multiple mobiles numbers separated by comma
        $mobileNumber = '91' . $mobile_no;
        //Sender ID,While using route4 sender id should be 6 characters long.
        $senderId = "Donalds";

        $message = "";
        //Your message to send, Add URL encoding here.
        if($status == "Processing")
        {
            $message = urlencode("Your order has been confirmend by the vendor, and it would be dispatched shortly.");
        }
        elseif ($status == "Completed") {
            $message = urldecode("Your order has been dispatched by the vendor, and would reach you within $time minutes");
        }

        //Define route 
        $route = 4;

        //Prepare you post parameters
        $postData = array(
            'authkey' => $authKey,
            'mobiles' => $mobileNumber,
            'message' => $message,
            'sender' => $senderId,
            'route' => $route,

        );

       $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => "http://api.msg91.com/api/sendhttp.php?country=91&sender=Donald&route=4&mobiles=$mobileNumber&authkey=226344As0L5erym55b4c4ec1&encrypt=&message=$message&response=&campaign=http://donalds.in",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_SSL_VERIFYHOST => 0,
          CURLOPT_SSL_VERIFYPEER => 0,
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
          echo "cURL Error #:" . $err;
        }
        else {
            return $response;
        }
    }

}
