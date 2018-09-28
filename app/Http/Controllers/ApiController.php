<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\User;
use App\VerifyUser;
use App\Menu;
use App\Address;
use App\Categories;
use App\RestaurantImages;
use App\Restaurants;
use App\Review;
use App\Notifications;
use App\Order;
use App\Mail\VerifyMail;
use App\Mail\VerifyOtp;
use App\Mail\ChangePassword;

use Intervention\Image\Facades\Image;
use Auth;

class ApiController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        return 1;
    }

    private function restronentType($types = "")
    {
        if ($types != "") {
            $SQL = "Select type from restaurant_types where id in ($types)";
            $restaurant_types = \DB::select($SQL);
            $types = [];
            foreach ($restaurant_types as $key => $restaurant) {
                $types[] = $restaurant->type;
            }

            return implode(",", $types);
        } else {

            return "";
        }

    }

    public function listCuisene($types = "")
    {

        $SQL = "Select id, type from restaurant_types";
        $restaurant_types = \DB::select($SQL);
        $types = [];
        foreach ($restaurant_types as $key => $restaurant) {
            $types[] = $restaurant;
        }

        $this->content['status'] = true;
        $this->content['message'] = "Success: Restaurant Cuisenes List";
        $this->content['data'] = $types;
        $status = 200;

        return response()->json($this->content, $status);

    }

    public function listAddresses($types = "")
    {

        $SQL = "Select * from addresses where user_id=" . Auth::user()->id;
        $addresses = \DB::select($SQL);
        $types = [];
        foreach ($addresses as $key => $address) {
            $types[] = $this->convertToBlank((array)$address);
        }

        $this->content['status'] = true;
        $this->content['message'] = "Success: Users Addresses List";
        $this->content['data'] = $types;
        $status = 200;

        return response()->json($this->content, $status);

    }


    public function addAddress(Request $request)
    {
        $address = new Address;
        $address->user_id = Auth::user()->id;
        $address->flat_no = $request->input('flat_no');
        $address->colony = $request->input('colony');
        $address->state = $request->input('state');
        $address->city = $request->input('city');
        $address->area = $request->input('area');
        $address->pincode = $request->input('pincode');
        $address->lanmark = $request->input('lanmark');
        $address->save();
        if ($address->id) {
            $this->content['status'] = true;
            $this->content['message'] = "Success: Address added Successfully";
            $this->content['data'] = $this->convertToBlank($address->toArray());
            $status = 200;

        } else {
            $this->content['status'] = false;
            $this->content['message'] = "Error: Address not created";
            $this->content['data'] = "";
            $status = 200;

        }

        return response()->json($this->content, $status);

    }


    public function removeAddress(Request $request)
    {

        $addressInfo = Address::where(['id' => $request->id])->first();
        if ($addressInfo) {
            $addressInfo->delete();
            $this->content['status'] = true;
            $this->content['message'] = "Address Removed Successfully";
            $this->content['data'] = "";
            $status = 200;
        } else {
            $this->content['status'] = false;
            $this->content['message'] = "Sorry:Invalid Address Id";
            $this->content['data'] = "";
            $status = 200;
        }
        return response()->json($this->content, $status);

    }

    private function sendOTP($mobile_no)
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

        $digits = 4;
        $otp = rand(pow(10, $digits - 1), pow(10, $digits) - 1);

        //Your message to send, Add URL encoding here.
        $message = urlencode("Your OTP is " . $otp . " for http://donalds.in/");



        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => "http://control.msg91.com/api/sendotp.php?template=&otp_length=&authkey=226344As0L5erym55b4c4ec1&message=$message&sender=Donalds&mobile=$mobileNumber&otp=$otp&otp_expiry=&email=",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => "",
          CURLOPT_SSL_VERIFYHOST => 0,
          CURLOPT_SSL_VERIFYPEER => 0,
        ));












        //Define route 
        // $route = 4;

        //Prepare you post parameters
        // $postData = array(
        //     'authkey' => $authKey,
        //     'mobiles' => $mobileNumber,
        //     'message' => $message,
        //     'sender' => $senderId,
        //     'route' => $route,
        // );


        //API URL
        // $url = "https://control.msg91.com/api/sendhttp.php";

        // init the resource
        // $ch = curl_init();
        // curl_setopt_array($ch, array(
        //     CURLOPT_URL => $url,
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_POST => true,
        //     CURLOPT_POSTFIELDS => $postData
        //     //,CURLOPT_FOLLOWLOCATION => true
        // ));


        //Ignore SSL certificate verification
        // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);


        //get response
        // $output = curl_exec($ch);

        //Print error if any
        // if (curl_errno($ch)) {
        //     echo 'error:' . curl_error($ch);
        // }
        $output = curl_exec($curl);
        $err = curl_error($curl);

        // curl_close($curl);

        // if ($err) {
        //   echo "cURL Error #:" . $err;
        // } 
        // else {
        //   echo $response;
        // }

        curl_close($curl);
        // $optInfo= new \stdClass;
        if ($output != null) {
            $optInfo['otp'] = $otp;
            $otpInfo['type'] = 'success';
            $otpInfo['message'] = $output;
            $optInfo = ['otp' => $otp, 'type' => 'success', 'message' => $output];
        } else {
            $otpInfo['type'] = 'error';

        }

        return $optInfo;
    }


    public function updateMobile(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $mobile_no = $request->mobile_no;
//		  if($user){

        $user->mobile_no = $mobile_no;
        $user->mobile_verified = 0;
        $otpInfo = $this->sendOTP($mobile_no);
        $user->otp = $otpInfo['otp'];
        $user->save();
        $this->content['status'] = true;
        $this->content['message'] = "Mobile Updated Successfully";
        $this->content['data'] = $this->convertToBlank($user->toArray());
        $status = 200;

//		   }else{
//				$this->content['status']=false;
//				$this->content['message'] = "Sorry:Invalid User Id";
//				$this->content['data']="";
//				$status = 200;
//			}
        return response()->json($this->content, $status);
    }


    public function verifyMobile(Request $request)
    {
        $otp = $request->otp;
        $user = User::find(Auth::user()->id);
        //echo $otp;
        if ($otp == $user->otp) {
            $user->mobile_verified = 1;
            $user->save();
            $this->content['status'] = true;
            $this->content['message'] = "Mobile Verified Successfully";
            $this->content['data'] = "";
            $status = 200;
        } else {
            $this->content['status'] = false;
            $this->content['message'] = "Invalid Otp";
            $this->content['data'] = "";
            $status = 200;

        }
        return response()->json($this->content, $status);

    }


    public function updateAddress(Request $request)
    {

        $address = Address::where(['id' => $request->id])->first();
        if ($address) {

            $address->flat_no = $request->input('flat_no');
            $address->colony = $request->input('colony');
            $address->state = $request->input('state');
            $address->city = $request->input('city');
            $address->area = $request->input('area');
            $address->pincode = $request->input('pincode');
            $address->lanmark = $request->input('lanmark');
            $address->save();
            $this->content['status'] = true;
            $this->content['message'] = "Address Updated Successfully";
            $this->content['data'] = $this->convertToBlank($address->toArray());
            $status = 200;

        } else {
            $this->content['status'] = false;
            $this->content['message'] = "Sorry:Invalid Address Id";
            $this->content['data'] = "";
            $status = 200;
        }
        return response()->json($this->content, $status);


    }

    private function getRestronentTypefromName($types)
    {

        $SQL = "Select id from restaurant_types where id in ($types)";
        $restaurant_types = \DB::select($SQL);
        $types = [];
        foreach ($restaurant_types as $key => $restaurant) {
            $types[] = $restaurant->id;
        }

        return $types;

    }

    public function filterRestaurant(Request $request){
        
        $filter="";
    
        if($request->type){
            $type=$request->type;
            if($type != "both")
                $filter .=" and type='".strtolower($type)."'";   
        }

        if($request->cuisine){
            $cuisene=$request->cuisine;
            $filter .= ' and ';
            $types= $this->getRestronentTypefromName($cuisene);
            if(count($types))
                $filter .=" ( ";
            foreach($types as $type){
                $filter .="  FIND_IN_SET('".$type."',restaurant_type) or";
            }

            $filter=rtrim($filter,'or');
            
            if(count($types))
                $filter .=" ) ";
        }
        
        if($request->availability){
            $availablity=$request->availability;
            $filter .=' and ';
            $atypes=    explode(',',$availablity);
            
            if(count($atypes))
                $filter .=" ( ";
            foreach($atypes as $type){
                $filter .="  FIND_IN_SET('".$type."',availablity) or";
            }
            
            $filter=rtrim($filter,'or');
            
            if(count($atypes))
                $filter .=" ) ";
        }
        
        if($request->packages){
            $packages=$request->packages;
            $filter .=' and ';
            $packages=  explode(',',$packages);
            
            if(count($packages))
                $filter .=" ( ";
            foreach($packages as $package){
                $filter .="  FIND_IN_SET('".$package."',packages_available) or";
            }
            
            $filter=rtrim($filter,'or');
            
                if(count($packages))
                $filter .=" ) ";
            
        
        }

        $lng=$request->lng; 
        $lat=$request->lat;
        $distance=$request->distance;


        $SQL="SELECT *, 3956 * 2 * 
      ASIN(SQRT( POWER(SIN(($lat - abs(lat))*pi()/180/2),2)
      +COS($lat*pi()/180 )*COS(abs(lat)*pi()/180)
      *POWER(SIN(($lng-lng)*pi()/180/2),2))) 
      as distance FROM restaurants WHERE 
      lng between ($lng-$distance/abs(cos(radians($lat))*69)) 
      and ($lng+$distance/abs(cos(radians($lat))*69)) 
      and lat between ($lat-($distance/69)) 
      and ($lat+($distance/69)) and status=1". $filter ."
      having distance < $distance and max_delivery_distance >=$distance ORDER BY max_delivery_distance DESC ,distance limit 20";
      
      // return $SQL;
     $restaurants= \DB::select($SQL);
     $restaurantsData=[];
     foreach($restaurants as $key => $restaurant ){
        $restaurant->restaurant_type=$this->restronentType($restaurant->restaurant_type);
        $restaurant->restaurant_logo=$restaurant->restaurant_logo."-s.jpg";
        $restaurant->packages_available =explode(",",$restaurant->packages_available);
        $restaurant->availablity=explode(",",$restaurant->availablity);
        $restaurantsData[]= $this->convertToBlank((array)$restaurant);
     }
     $this->content['status']=true;
     $this->content['message'] = "Success: restaurants near you";
     $this->content['data']=$restaurantsData;
     $status = 200;
     
     return response()->json($this->content, $status);
    }

    private function categoryNameById($menu_cat)
    {
        $category = Categories::where(['id' => $menu_cat])->first();

        return $category->category_name;

    }

    public function listMenuByRestaurant(Request $request)
    {

        $menus = Menu::where(['restaurant_id' => $request->restaurant_id, 'status' => 1])->get();
        $menusData = [];
        foreach ($menus as $key => $menu) {
            if ($menu->menu_cat)
                $menu->menu_cat = $this->categoryNameById($menu->menu_cat);
            $menu->menu_image = $menu->menu_image . "-s.jpg";
            $menusData[] = $this->convertToBlank((array)$menu);
        }

        $this->content['status'] = true;
        $this->content['message'] = "Success: restaurants menus list";
        $this->content['data'] = $menusData;
        $status = 200;

        return response()->json($this->content, $status);

    }

    private function getUserDataById($id)
    {
        $userData = User::find($id)->toArray();
        return $this->convertToBlank($userData);
    }

    public function getRatingByRestaurant(Request $request)
    {
        if ($request->page > 1)
            $page = ($request->page - 1) * 5;
        else
            $page = 0;
        $ratings = Review::where(['restaurant_id' => $request->restaurant_id])->orderBy('date')->offset($page)->limit(5)->get();
        $ratingData = [];
        foreach ($ratings as $key => $rating) {
            $rating->user = $this->getUserDataById($rating->user_id);
            $ratingData[] = $this->convertToBlank($rating->toArray());
        }

        $this->content['status'] = true;
        $this->content['message'] = "Rating by restaurant";
        $this->content['data'] = $ratingData;
        $status = 200;

        return response()->json($this->content, $status);

    }

    public function editReview(Request $request)
    {


        $validator = Validator::make(
            [
                'review_id' => $request->review_id,
                'restaurant_id' => $request->restaurant_id,
                'rating' => $request->rating

            ],
            [
                'review_id' => 'required',
                'restaurant_id' => 'required',
                'rating' => 'required'
            ]
        );


        if ($validator->fails()) {
            $errors = $validator->messages()->toArray();
            $vErrors = [];
            foreach ($errors as $key => $error) {

                $vErrors[$key] = $error[0];

            }

            $this->content['status'] = false;
            $this->content['message'] = "Data Validation Failed";
            $this->content['data'] = $vErrors;
            $status = 200;
            return response()->json($this->content, $status);
        }
        $review = Review::find($request->review_id);

        if (!$review) {
            $this->content['status'] = false;
            $this->content['message'] = "Invalid review Id";
            $this->content['data'] = "";
            $status = 200;

            return response()->json($this->content, $status);

        }
        $review->restaurant_id = $request->restaurant_id;
        $review->user_id = Auth::user()->id;
        $review->review_text = $request->review_text;
        $review->rating = $request->rating;
        $review->food_quality = 0;
        $review->price = 0;
        $review->punctuality = 0;
        $review->courtesy = 0;
        date_default_timezone_set('Asia/Kolkata');
        $review->date = strtotime(date('Y-m-d H:i:s'));

        if ($review->save()) {
            $this->content['status'] = true;
            $this->content['message'] = "Review updated successfully";
            $this->content['data'] = "";
            $status = 200;
        }

        return response()->json($this->content, $status);

    }

    public function updateOrderStatus(Request $request)
    {
        $order_id = $request->order_id;
        $status = $request->status;
        $orderInfo = Order::where('order_id',$order_id)->first();
    
        if ($orderInfo) {
            $user_details = User::findOrFail($orderInfo->user_id);  
            $orderInfo->status = $status;
            $orderInfo->save();
            $this->content['status'] = true;
            $this->content['message'] = "Order status changed to " . $status;
            $this->content['data'] = "";


            $favcolor = "red";
            $restronent = Restaurants::find($orderInfo->restaurant_id);
            $msg = "";
            switch ($status) {
                case "accepted":
                    // $otpInfo = $this->sendMsg($user_details->mobile_no , "accepted" , "" ,""); 
                    $msg = "Your order has been confirmend by the vendor, and it would be dispatched shortly.";  
                    $this->sendNotification('Order Accepted' , $msg, $orderInfo->user_id ,"user");
                    break;

                case "dispatched":
                    $to_time=strtotime("+$restronent->delivery_time minutes",strtotime($orderInfo->created_at));
                    $from_time = strtotime(date("Y-m-d H:i:s"));
                    $diff =  round(($to_time - $from_time) / 60,2)." minute";
                    if($diff < 20)
                    {
                        // $otpInfo = $this->sendMsg($user_details->mobile_no , "dispatched",20 , "");
                        $msg = "Your order has been dispatched by the vendor, and would reach you within 20 minutes.";
                    }
                    else
                    {
                        // $otpInfo = $this->sendMsg($user_details->mobile_no , "dispatched",$diff, "");
                        $msg = "Your order has been dispatched by the vendor, and would reach you within $diff minutes.";
                    }
                    $this->sendNotification('Order Dispatched' , $msg , $orderInfo->user_id,"user");
                    break;

                case "delivered":
                    // $otpInfo = $this->sendMsg($user_details->mobile_no , "delivered",$orderInfo->order_id, $orderInfo->item_price);
                    $msg = "Your Donalds order number " . $orderInfo->order_id . ", amounting Rs. " . $orderInfo->item_price . " has been successfully delivered.";
                    $this->sendNotification('Order Delivered' , $msg , $orderInfo->user_id,"user");

                    break;
                case "cancelled":
                    // $otpInfo = $this->sendMsg($user_details->mobile_no , "cancelled",$orderInfo->order_id, "");
                    $msg = "Sorry  your no " . $orderInfo->order_id . " is cancelled by Merchant.";
                    $this->sendNotification('Order Cacelled' , $msg , $orderInfo->user_id,"user");
                    break;

            }
            if ($msg != "") {
                $notification = new Notifications;
                $notification->text = $msg;
                $notification->user_id = $orderInfo->user_id;
                $notification->order_id = $orderInfo->id;
                $notification->save();
            }

            $status = 200;
        } else {
            $this->content['status'] = false;
            $this->content['message'] = "Invalid Order Id";
            $this->content['data'] = "";
            $status = 200;

        }
        return response()->json($this->content, $status);
    }

    public function listRestaurantOrders(Request $request)
    {

        $restaurant_id = $request->restaurant_id;
        $status = $request->status;

        if ($request->page > 1)
            $page = ($request->page - 1) * 5;
        else
            $page = 0;
        $count = Order::where(['restaurant_id' => $restaurant_id, 'status' => $status])->count();
        if ($status != 'history') {
            $orders = Order::where(['restaurant_id' => $restaurant_id, 'status' => $status])
                ->orderBy('id', 'DESC')
                ->offset($page)->limit(5)->get();
        } else {
            $orders = Order::where(['restaurant_id' => $restaurant_id])->where('status', '!=', 'new')
                ->orderBy('id', 'DESC')
                ->offset($page)->limit(5)->get();
        }
        $userOrders = [];
        // $user=$this->convertToBlank($this->convertAuthUserToarray());
        foreach ($orders as $order) {
            $temp = [];
            $temp['id'] = $order->id;
            $temp['user'] = User::where('id', $order->user_id)->first();
            $menu = Menu::where(['id' => $order->menu_id, 'status' => 1])->first();
            $orderMenu = [];
            if ($menu) {
                $orderMenu = $this->convertToBlank($menu->toArray());
            }
            $temp['menu'] = $orderMenu;

            $restaurant = Restaurants::where(['id' => $order->restaurant_id, 'status' => 1])->first();
            $restaurantData = [];
            if ($restaurant) {
                $restaurantData = $this->convertToBlank($restaurant->toArray());
            }

            $address = Address::where(['id' => $order->address_id])->first();
            $addressData = [];
            if ($address) {
                $addressData = $this->convertToBlank($address->toArray());
            }

            $is_reviewed = Review::where(['restaurant_id' => $order->restaurant_id, 'user_id' => Auth::user()->id])->first();
            $temp['is_reviewed'] = 0;


            if ($is_reviewed) {
                $temp['is_reviewed'] = 1;

            }
            $temp['delivery_address'] = $addressData;
            $temp['restaurant'] = $restaurantData;
            $temp['cod'] = $order->cod;
            $temp['order_id'] = $order->order_id;
            $temp['item_price'] = $order->item_price;
            $temp['quantity'] = $order->quantity;
            $temp['status'] = $order->status;
            $temp['payment_mode'] = $order->payment_mode;
            $temp['extra_note'] = $order->extra_note;
            $temp['package_type'] = $order->package_type;
            $temp['order_date'] = date('Y-m-d', strtotime($order->created_at));
            $temp['order_time'] = date('H:i:s', strtotime($order->created_at));
            $userOrders[] = $temp;
        }
        $responseData['current_page'] = $request->page;
        $responseData['total_page'] = round($count / 5);
        $responseData['results'] = $userOrders;
        $this->content['status'] = true;
        $this->content['message'] = "Users Order List";
        $this->content['data'] = $responseData;
        $this->pages = $page;
        $status = 200;


        return response()->json($this->content, $status);
    }

    public function listUserOrders(Request $request)
    {

        $user_id = Auth::user()->id;


        if ($request->page > 1)
            $page = ($request->page - 1) * 5;
        else
            $page = 0;

        $count = Order::where(['user_id' => $user_id])->count();
        $orders = Order::where(['user_id' => $user_id])->orderBy('id', 'DESC')->offset($page)->limit(5)->get();
        $userOrders = [];
        $user = $this->convertToBlank($this->convertAuthUserToarray());
        foreach ($orders as $order) {
            $temp = [];
            $temp['id'] = $order->id;
            $temp['user'] = $user;
            $menu = Menu::where(['id' => $order->menu_id, 'status' => 1])->first();
            $orderMenu = [];
            if ($menu) {
                $orderMenu = $this->convertToBlank($menu->toArray());
            }
            $temp['menu'] = $orderMenu;

            $restaurant = Restaurants::where(['id' => $order->restaurant_id, 'status' => 1])->first();
            $restaurantData = [];
            if ($restaurant) {
                $restaurantData = $this->convertToBlank($restaurant->toArray());
            }

            $address = Address::where(['id' => $order->address_id])->first();
            $addressData = [];
            if ($address) {
                $addressData = $this->convertToBlank($address->toArray());
            }
            $is_reviewed = Review::where(['restaurant_id' => $order->restaurant_id, 'user_id' => Auth::user()->id])->first();
            $temp['is_reviewed'] = 0;


            if ($is_reviewed) {
                $temp['is_reviewed'] = 1;

            }


            $temp['delivery_address'] = $addressData;
            $temp['restaurant'] = $restaurantData;
            $temp['cod'] = $order->cod;
            $temp['item_price'] = $order->item_price;
            $temp['quantity'] = $order->quantity;
            $temp['status'] = $order->status;
            $temp['payment_mode'] = $order->payment_mode;
            $temp['extra_note'] = $order->extra_note;
            $temp['package_type'] = $order->package_type;
            $temp['package_type'] = $order->package_type;
            $temp['order_date'] = date('Y-m-d', strtotime($order->created_at));
            $temp['order_time'] = date('H:i:s', strtotime($order->created_at));
            // s$temp['order_date']=$order->created_at;

            $userOrders[] = $temp;

        }
        $responseData['current_page'] = $request->page;
        $responseData['total_page'] = round($count / 5);
        $responseData['results'] = $userOrders;
        $this->content['status'] = true;
        $this->content['message'] = "Users Order List";
        $this->content['data'] = $responseData;
        $this->content['pages'] = $page;
        $status = 200;


        return response()->json($this->content, $status);
    }

    public function createOrder(Request $request)
    {
        $validator = Validator::make(
            [
                'restaurant_id' => $request->restaurant_id,
                'item_price' => $request->item_price,
                'quantity' => $request->quantity,
                'address_id' => $request->address_id,
                'payment_id' => $request->payment_id

            ],
            [
                'restaurant_id' => 'required',
                'item_price' => 'required',
                'quantity' => 'required',
                'address_id' => 'required',
                'payment_id' => 'required',
            ]
        );


        if ($validator->fails()) {
            $errors = $validator->messages()->toArray();
            $vErrors = [];
            foreach ($errors as $key => $error) {

                $vErrors[$key] = $error[0];

            }

            $this->content['status'] = false;
            $this->content['message'] = "Data Validation Failed";
            $this->content['data'] = $vErrors;
            $status = 200;
            return response()->json($this->content, $status);
        }

        // fetch the data regards order_id
        $user_name = User::where('id', Auth::user()->id)->get(['name']);
        $user_name = $user_name[0]->name;

        $restuarant_name = Restaurants::where('id', $request->restaurant_id)->get(['restaurant_name']);
        $restuarant_name = $restuarant_name[0]->restaurant_name;
        // order_id data fetch over

        $order = new Order;

        $order->user_id = Auth::user()->id;
        $order->order_id = substr($restuarant_name, 0, 3) . round(microtime(true) * 1000) . rand(1000, 9999) . substr($user_name, 0, 3);
        $order->restaurant_id = $request->restaurant_id;
        $order->menu_id = $request->menu_id;
        $order->cod = $request->cod;
        $order->item_price = $request->item_price;
        $order->quantity = $request->quantity;
        $order->address_id = $request->address_id;
        $order->payment_id = $request->payment_id;
        $order->payment_mode = $request->payment_mode;
        $order->package_type = $request->package_type;
        $order->extra_note = $request->extra_note;
        $order->payment_extra_data = $request->payment_extra_data;
        $order->order_type = $request->order_type;
        $order->status = 'new';

        if ($order->save()) {
            $this->content['status'] = true;
            $this->content['message'] = "Order created successfully";
            $this->content['data'] = $this->convertToBlank($order->toArray());
            $status = 200;
        }

        $restaurant_owner_id = Restaurants::where('id', $request->restaurant_id)->first(['user_id']);
        $msg = "New order received from $user_name , " . $request->package_type . " of " . $request->item_price . " Rs";

        $notification = new Notifications;
        $notification->text = $msg;
        $notification->user_id = $restaurant_owner_id;
        $notification->order_id = $order->order_id;
        $notification->save();

        $this->sendNotification("New Order",$msg, $restaurant_owner_id,"merchant");
        return response()->json($this->content, $status);
    }

    public function addReview(Request $request)
    {
        $validator = Validator::make(
            [
                'restaurant_id' => $request->restaurant_id,
                'rating' => $request->rating

            ],
            [
                'restaurant_id' => 'required',
                'rating' => 'required'
            ]
        );


        if ($validator->fails()) {
            $errors = $validator->messages()->toArray();
            $vErrors = [];
            foreach ($errors as $key => $error) {

                $vErrors[$key] = $error[0];

            }

            $this->content['status'] = false;
            $this->content['message'] = "Data Validation Failed";
            $this->content['data'] = $vErrors;
            $status = 200;
            return response()->json($this->content, $status);
        }


        /*
            validate the review
            a user can review to a restaurent only after he had ordered and succesfully
            he will not able to edit it or will not able to give it again till he ordered new order
        */

        $total_orders = Order::where(['user_id' => Auth::user()->id, 'restaurant_id' => $request->restaurant_id])->count();

        $total_review = Review::where(['user_id' => Auth::user()->id, 'restaurant_id' => $request->restaurant_id])->count();

        //compare total order with total review
        if ($total_orders <= $total_review) {
            $this->content['status'] = false;
            $this->content['message'] = "Data Validation Failed";
            $this->content['data'] = "You must have a new order to make review";
            $status = 200;
            return response()->json($this->content, $status);
        }

        $total_completed = Order::where(['user_id' => Auth::user()->id, 'restaurant_id' => $request->restaurant_id, 'status' => 'Completed'])->count();

        //compare total review with complete orders
        if ($total_completed <= $total_review) {
            $this->content['status'] = false;
            $this->content['message'] = "Data Validation Failed";
            $this->content['data'] = "You can give review after your order will complete";
            $status = 200;
            return response()->json($this->content, $status);
        }

        $review = new Review;
        $review->restaurant_id = $request->restaurant_id;
        $review->user_id = Auth::user()->id;
        $review->review_text = $request->review_text;
        $review->rating = $request->rating;
        $review->food_quality = 0;
        $review->price = 0;
        $review->punctuality = 0;
        $review->courtesy = 0;
        date_default_timezone_set('Asia/Kolkata');
        $review->date = strtotime(date('Y-m-d H:i:s'));

        if ($review->save()) {
            $this->content['status'] = true;
            $this->content['message'] = "Review added successfully";
            $this->content['data'] = "";
            $status = 200;
        }

        return response()->json($this->content, $status);

    }

    public function restaurantDetails(Request $request)
    {

        $restaurant = Restaurants::find($request->restaurant_id);

        if (!$restaurant) {

            $this->content['status'] = false;
            $this->content['message'] = "Invalid Restaurant Id";
            $this->content['data'] = "";
            $status = 200;

            return response()->json($this->content, $status);
        }
        $restaurant->restaurant_type = $this->restronentType($restaurant->restaurant_type);
        $restaurant->restaurant_logo = $restaurant->restaurant_logo . "-s.jpg";
        $restaurant->packages_available = explode(",", $restaurant->packages_available);
        $restaurant->availablity = explode(",", $restaurant->availablity);
        $restaurantsData = $this->convertToBlank($restaurant->toArray());

        $is_reviewed = Review::where(['restaurant_id' => $request->restaurant_id, 'user_id' => Auth::user()->id])->first();
        $is_ordered = Order::where(['restaurant_id' => $request->restaurant_id, 'user_id' => Auth::user()->id])->first();

        $ratings = Review::where(['restaurant_id' => $request->restaurant_id])->orderBy('date')->offset(0)->limit(2)->get();
        $ratingData = [];
        $reviews = Review::where(['restaurant_id' => $request->restaurant_id])->get();
        foreach ($ratings as $key => $rating) {
            $rating->user = $this->getUserDataById($rating->user_id);
            $ratingData[] = $this->convertToBlank($rating->toArray());
        }
        $review_count = 0;
        $rating_sum = 0;
        $rating_average = 0;
        foreach ($reviews as $review) {
            $rating_sum = $rating_sum + $review->rating;
            $review_count++;
        }
        if ($rating_sum > 0) {
            $rating_average = round($rating_sum / $review_count, 1);
        }
        $restaurantsData['is_reviewed'] = 0;
        $restaurantsData['is_ordered'] = 0;
        if ($is_reviewed) {
            $restaurantsData['is_reviewed'] = 1;
        }
        if ($is_ordered) {
            $restaurantsData['is_ordered'] = 1;
        }
        $restaurantsData['rating_average'] = $rating_average;
        $restaurantsData['review_count'] = $review_count;
        $imageObj = RestaurantImages::where(['restaurant_id' => $request->restaurant_id])->get();
        $images = [];
        foreach ($imageObj as $obj) {
            $images[] = $obj->image . "-b.jpg";
        }
        $restaurantsData['images'] = $images;
        date_default_timezone_set('Asia/Kolkata');
        $day = date('l', strtotime('now'));


        //$SQL="select * from menu where restaurant_id=".$request->restaurant_id." and FIND_IN_SET('".$day."',days_avail)";
        $SQL = "select * from menu where restaurant_id=" . $request->restaurant_id;


        $menus = \DB::select($SQL);

        $menusData = [];
        foreach ($menus as $key => $menu) {
            if ($menu->menu_cat)
                $menu->menu_cat = $this->categoryNameById($menu->menu_cat);
            $menu->menu_image = $menu->menu_image . "-s.jpg";
            $menusData[] = $this->convertToBlank((array)$menu);
        }

        $restaurantsData['menu'] = $menusData;
        $restaurantsData['review'] = $ratingData;


        $this->content['status'] = true;
        $this->content['message'] = "Success: restaurants Details";
        $this->content['data'] = $restaurantsData;
        $status = 200;

        return response()->json($this->content, $status);
    }

    public function getOffers(Request $request)
    {
        $offers = \DB::table('offers')->where(['status' => 1])->get()->toArray();
        $this->content['status'] = true;
        $this->content['message'] = "Success: offers list";
        $this->content['data'] = $offers;
        $status = 200;

        return response()->json($this->content, $status);

    }

    public function getNearByRestaurant(Request $request){
		
			    $validator = Validator::make(
								[
									'lng' => $request->lng,
									'lat' => $request->lat,
									'distance' => $request->distance
									
								],
								[
									'lng' => 'required',
									'lat' => 'required',
									'distance' => 'required',
								]
							);
		
		
		if ($validator->fails()){
				$errors = $validator->messages()->toArray();
				$vErrors=[];
				foreach($errors as $key => $error){
					
					$vErrors[$key]=$error[0];
					
				}
				
				$this->content['status']=false;
				$this->content['message'] = "Data Validation Failed";
				$this->content['data']=$vErrors;
				$status = 200;
				return response()->json($this->content, $status); 
		}
	
	 $lng=$request->lng;	
	 $lat=$request->lat;
	 $distance=$request->distance;

      $SQL="SELECT *, 3956 * 2 * 
      ASIN(SQRT( POWER(SIN(($lat - abs(lat))*pi()/180/2),2)
      +COS($lat*pi()/180 )*COS(abs(lat)*pi()/180)
      *POWER(SIN(($lng-lng)*pi()/180/2),2))) 
      as distance FROM restaurants WHERE 
      lng between ($lng-$distance/abs(cos(radians($lat))*69)) 
      and ($lng+$distance/abs(cos(radians($lat))*69)) 
      and lat between ($lat-($distance/69)) 
      and ($lat+($distance/69)) and status=1
      having distance < $distance and max_delivery_distance >=$distance ORDER BY max_delivery_distance DESC ,distance limit 20";
	  
	 $restaurants= \DB::select($SQL);
	 $restaurantsData=[];
	 foreach($restaurants as $key => $restaurant ){
		$restaurant->restaurant_type=$this->restronentType($restaurant->restaurant_type);
		$restaurant->restaurant_logo=$restaurant->restaurant_logo."-s.jpg";
		$restaurant->packages_available =explode(",",$restaurant->packages_available);
		$restaurant->availablity=explode(",",$restaurant->availablity);
		$restaurantsData[]= $this->convertToBlank((array)$restaurant);
	 }
	$this->content['status']=true;
	$this->content['message'] = "Success: restaurants near you";
	$this->content['data']=$restaurantsData;
	$status = 200;
	 
	 return response()->json($this->content, $status);  
		
	}

    private function convertAuthUserToarray()
    {
        $user = Auth::user();
        return array(
            'id' => $user->id,
            'usertype' => $user->usertype,
            'otp' => $user->otp,
            'first_name' => $user->first_name,
            'name' => $user->name,
            'email' => $user->email,
            'image_icon' => $user->image_icon,
            'profile_pic_url' => $user->profile_pic_url,
            'social' => $user->social,
            'mobile_no' => $user->mobile_no,
            'address' => $user->address,
            'city' => $user->city,
            'device_id' => $user->device_id,
            'device' => $user->device,
            'postal_code' => $user->postal_code,
            'status' => $user->status,
            'fcm_id' => $user->fcm_id,
            'email_verified' => (int)$user->email_verified,
            'mobile_verified' => (int)$user->mobile_verified

        );

    }


    public function profileDetails()
    {
        if (Auth::user()->id) {

            $userData = $this->convertAuthUserToarray();
            $this->content['status'] = true;
            $this->content['message'] = "User Profile Details";
            $this->content['data'] = $this->convertToBlank($userData);
            $status = 200;

        } else {
            $this->content['status'] = false;
            $this->content['message'] = "Unauthorized Access:Invalid Token";
            $this->content['data'] = "";
            $status = 200;

        }

        return response()->json($this->content, $status);
    }


    public function authenticateMerchant(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'usertype' => 'Merchant'])) {
            $user = User::where(['email'=>$request->email , 'usertype'=>'Merchant'])->first();
            $Restaurants = Restaurants::where('user_id',$user->id)->first();
            if ( $user->mobile_verified == 0 ) {
                    $this->content['status'] = true;
                    $this->content['message'] = "Inactive User";
                    $this->content['token'] = $user->createToken('food App' . $user->id)->accessToken;
                    $this->content['data'] = $user;
                    $this->content['data']['restaurant_id'] = $Restaurants->id;
                    $status = 200;
                } 
                elseif ($user->mobile_verified == 1 && $user->email_verified == 1 && $user->status == 0)
                {
                    $this->content['status'] = false;
                    $this->content['message'] = "Please contact admin to active your account";
                    $this->content['data'] = "";
                    $this->content['token'] = $user->createToken('food App' . $user->id)->accessToken;
                    $status = 200;  
                } 
                // elseif($user->mobile_verified == 1)
                // {
                //     $userData = $this->convertAuthUserToarray();

                //     $restronent = Restaurants::where(['user_id' => Auth::user()->id])->first();
                //     $responseData = $this->convertToBlank($userData);

                //     $responseData['restaurant_id'] = $restronent->id;
                //     $this->content['token'] = $user->createToken('food App' . $user->id)->accessToken;
                //     $this->content['status'] = true;
                //     $this->content['message'] = "Logged In Successfully";
                //     $this->content['data'] = $responseData;
                //     $status = 200;  
                //     return response()->json($this->content, $status);

                // }
                else {
                $userData = $this->convertAuthUserToarray();

                $restronent = Restaurants::where(['user_id' => Auth::user()->id])->first();
                $responseData = $this->convertToBlank($userData);

                $responseData['restaurant_id'] = $restronent->id;
                $this->content['token'] = $user->createToken('food App' . $user->id)->accessToken;
                $this->content['status'] = true;
                $this->content['message'] = "Logged In Successfully";
                $this->content['data'] = $responseData;
                $status = 200;
            }
        } else {
            $this->content['status'] = false;
            $this->content['message'] = "Unauthorised: Invalid Email or Password";
            $this->content['data'] = "";
            $status = 200;
        }
        return response()->json($this->content, $status);
    }

    /**
     * authenticate app users.
     *
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        if ($request->social != "") {

            $userInfo = User::where(['email' => $request->email, 'usertype' => 'User'])->first();
            if (!empty($userInfo)) {
                if ($userInfo->email_verified == 1 && $userInfo->mobile_verified == 1 && $userInfo->statusF == 0) {
                    $this->content['status'] = false;
                    $this->content['message'] = "sorry your account has been disabled please talk to our customer support";
                    $this->content['data'] = "";
                    $status = 200;  
                }
                if($userInfo->email_verified == $request->email)
                {
                    $userInfo->fcm_id = $request->input('fcm_id');
                    $userInfo->save();
                    $userData = $userInfo->toArray();
                    $this->content['token'] = $userInfo->createToken('food App' . $userInfo->id)->accessToken;
                    $this->content['status'] = true;
                    $this->content['message'] = "Logged In Successfully";
                    $this->content['data'] = $this->convertToBlank($userData);
                    $status = 200;
                }
                else {
                    $userInfo->social = $request->input('social');
                    if ($request->input('name')) {
                        $userInfo->name = $request->input('name');
                    }
                    if ($request->input('profile_pic_url')) {

                        $userInfo->profile_pic_url = $request->input('profile_pic_url');

                    }
                    if ($request->input('fcm_id') != "") {
                        $userInfo->fcm_id = $request->input('fcm_id');
                        $userInfo->save();
                        $userData = $userInfo->toArray();
                        $this->content['token'] = $userInfo->createToken('food App' . $userInfo->id)->accessToken;
                        $this->content['status'] = true;
                        $this->content['message'] = "Logged In Successfully";
                        $this->content['data'] = $this->convertToBlank($userData);
                        $status = 200;

                    } else {

                        $user = new User;
                        $user->email = $request->input('email');
                        $user->first_name = $user->name = $request->input('name');
                        $user->mobile_no = $request->input('mobile_no');
                        $user->device_id = $request->input('device_id');
                        $user->device = $request->input('device');
                        if ($request->input('profile_pic_url'))
                            $user->profile_pic_url = $request->input('profile_pic_url');
                        $user->social = $request->input('social');
                        $user->usertype = $request->input('usertype') ? $request->input('usertype') : 'User';
                        $user->status = $request->input('usertype') == 'user' ? 1 : 0;
                        if ($request->input('fcm_id') != "") {
                            $user->fcm_id = $request->input('fcm_id');
                        }
                        if ($user->save()) {
                            $this->content['token'] = $user->createToken('food App' . $user->id)->accessToken;
                            $this->content['status'] = true;
                            $this->content['message'] = "LoggedIn Successfully";
                            $user = User::find($user->id)->toArray();
                            $responseData = $this->convertToBlank($user);
                            $this->content['data'] = $responseData;
                            $status = 200;
                        } else {

                            $this->content['status'] = false;
                            $this->content['message'] = "Error in Registering User";
                            $this->content['data'] = "";
                            $status = 200;

                        }

                    }
                }
                return response()->json($this->content, $status);
            }

            if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'usertype' => 'User'])) {
                $user = Auth::user();

                if ($userInfo->email_verified == 1 && $userInfo->mobile_verified == 1 && $userInfo->status == 0) {
                    $this->content['status'] = false;
                    $this->content['message'] = "sorry your account has been disabled please talk to our customer support";
                    $this->content['data'] = "";
                    $status = 200;  
                }
                else {
                    $userData = $this->convertAuthUserToarray();
                    $this->content['token'] = $user->createToken('food App' . $user->id)->accessToken;
                    $this->content['status'] = true;
                    $this->content['message'] = "Logged In Successfully";
                    $this->content['data'] = $this->convertToBlank($userData);
                    $status = 200;
                }
            } else {
                $this->content['status'] = false;
                $this->content['message'] = "Unauthorised: Invalid Email or Password";
                $this->content['data'] = "";
                $status = 200;
            }
            return response()->json($this->content, $status);
        }
        else
        {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'usertype' => 'User'])) {
                $userInfo = Auth::user();

                if ($userInfo->email_verified == 1 && $userInfo->mobile_verified == 1 && $userInfo->status == 0) {
                    $this->content['status'] = false;
                    $this->content['message'] = "sorry your account has been disabled please talk to our customer support";
                    $this->content['data'] = "";
                    $status = 200;  
                }
                else {
                    $userData = $this->convertAuthUserToarray();
                    $this->content['token'] = $userInfo->createToken('food App' . $userInfo->id)->accessToken;
                    $this->content['status'] = true;
                    $this->content['message'] = "Logged In Successfully";
                    $this->content['data'] = $this->convertToBlank($userData);
                    $status = 200;
                }
            } else {
                $this->content['status'] = false;
                $this->content['message'] = "Unauthorised: Invalid Email or Password";
                $this->content['data'] = "";
                $status = 200;
            }
            return response()->json($this->content, $status);   
        }

    }

    private function convertToBlank($array)
    {
        foreach ($array as $key => $value) {
            if (is_null($value)) {
                $array[$key] = "";
            }
        }
        return $array;
    }

    public function slugify($text)
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

    /**
     * register new users.
     *
     * @return \Illuminate\Http\Response
     */
    public function registerVendor(Request $request)
    {
        $validator = Validator::make(
            [
                'name' => $request->name,
                'password' => $request->password,
                'email' => $request->email,
                'device_id' => $request->device_id,
                'device' => $request->device,
                'restaurent_name' => $request->restaurent_name,
                'restaurent_address' => $request->restaurent_address,
                'restaurent_contact_no' => $request->restaurent_contact_no,
                'owner_contact_no' => $request->owner_contact_no,

            ],
            [
                'name' => 'required|string|min:4',
                'password' => 'required|min:6',
                'email' => 'required|string|email|max:255',
                'device_id' => 'required',
                'device' => 'required',
                'restaurent_name' => 'required|string|min:4',
                'restaurent_address' => 'required|string|min:4',
                'restaurent_contact_no' => 'required',
                'owner_contact_no' => 'required',
            ]
        );


        if ($validator->fails()) {
            $errors = $validator->messages()->toArray();
            $vErrors = [];
            foreach ($errors as $key => $error) {

                $vErrors['error'] = $error[0];
                break;

            }

            $this->content['status'] = false;
            $this->content['message'] = "Data Validation Failed";
            $this->content['data'] = $vErrors;
            $status = 200;
            return response()->json($this->content, $status);
        }
        $userInfo = User::where(['email' => $request->email, 'usertype' => 'Merchant'])->first();
        if (!empty($userInfo)) {

            $this->content['status'] = false;
            $this->content['message'] = "Error in Registering User";
            $this->content['data'] = "Email is already in use";
            $status = 200;
            return response()->json($this->content, $status);

        }
        $userInfoM = User::where(['mobile_no' => $request->input('owner_contact_no'), 'usertype' => 'Merchant'])->first();
        if (!empty($userInfoM)) {

            $this->content['status'] = false;
            $this->content['message'] = "Error in Registering User";
            $this->content['data'] = "Mobile No is already in use";
            $status = 200;
            return response()->json($this->content, $status);

        }

        if ($request->has('email') && $request->has('password')) {
            $user = new User;
            $user->email = $request->input('email');
            $user->first_name = $user->name = $request->input('name');
            $user->mobile_no = $request->input('owner_contact_no');
            $user->mobile = $request->input('restaurent_contact_no');
            $user->device_id = $request->input('device_id');
            $user->device = $request->input('device');
            $user->address = $request->input('restaurent_address');
            $user->status = 1;
            if ($request->input('profile_pic_url'))
                $user->profile_pic_url = $request->input('profile_pic_url');

            $user->usertype = 'Merchant';
            $user->password = bcrypt($request->input('password'));
            if ($request->input('fcm_id') != "") {
                $user->fcm_id = $request->input('fcm_id');

            }

            if ($user->save()) {
                $userInfo = $user;

                $restronent = new Restaurants;
                $restronent->restaurant_id = "res" . substr($request->restaurent_name, 0,3) . rand(100000,999999) . substr($request->restaurent_name, 0,3);
                $restronent->restaurant_name = $request->restaurent_name;
                $restronent->restaurant_address = $request->restaurent_address;
                $restronent->user_id = $user->id;
                $restronent->restaurant_slug = $this->slugify($request->restaurent_name) . '-' . $request->device_id;
                $restronent->restaurent_contact_no = $request->restaurent_contact_no;
                $restronent->save();
                $this->content['token'] = $user->createToken('food App' . $user->id)->accessToken;
                $this->content['status'] = true;
                $this->content['message'] = "Merchant Registered Successfully";

                $userInfo->mobile_verified = 0;
                $otpInfo = $this->sendOTP($userInfo->mobile_no);
                $userInfo->otp = $otpInfo['otp'];
                $userInfo->save();

                $user = User::find($user->id)->toArray();
                $responseData = $this->convertToBlank($user);
                $responseData['restaurant_id'] = $restronent->id;
                $this->content['data'] = $responseData;
                $status = 200;
                $verifyUser = VerifyUser::create([
                    'user_id' => $userInfo->id,
                    'token' => str_random(40)
                ]);

                \Mail::to($userInfo->email)->send(new VerifyMail($userInfo));
            } else {

                $this->content['status'] = false;
                $this->content['message'] = "Error in Registering Merchant";
                $this->content['data'] = "";
                $status = 200;

            }
        } else {
            $this->content['status'] = false;
            $this->content['message'] = "Invalid request: Email or Password is missing";
            $this->content['data'] = "";
            $status = 200;
        }

        return response()->json($this->content, $status);
    }


    /**
     * register new users.
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        if ($request->social != "") {
            $userInfo = User::where(['email' => $request->email, 'usertype' => 'User'])->first();
            if (!empty($userInfo)) {
                $userInfo->social = $request->input('social');
                if ($request->input('name')) {
                    $userInfo->name = $request->input('name');
                }
                if ($request->input('profile_pic_url')) {

                    $userInfo->profile_pic_url = $request->input('profile_pic_url');

                }
                if ($request->input('fcm_id') != "") {
                    $userInfo->fcm_id = $request->input('fcm_id');

                }
                $userInfo->save();

                $userData = $userInfo->toArray();
                $this->content['token'] = $userInfo->createToken('food App' . $userInfo->id)->accessToken;
                $this->content['status'] = true;
                $this->content['message'] = "Logged In Successfully";
                $this->content['data'] = $this->convertToBlank($userData);
                $status = 200;

            } else {

                $user = new User;
                $user->email = $request->input('email');
                $user->first_name = $user->name = $request->input('name');
                $user->mobile_no = $request->input('mobile_no');
                $user->device_id = $request->input('device_id');
                $user->device = $request->input('device');
                if ($request->input('profile_pic_url'))
                    $user->profile_pic_url = $request->input('profile_pic_url');
                $user->social = $request->input('social');
                $user->usertype = $request->input('usertype') ? $request->input('usertype') : 'User';
                $user->status = 1;
                if ($request->input('fcm_id') != "") {

                    $user->fcm_id = $request->input('fcm_id');

                }
                if ($user->save()) {
                    $this->content['token'] = $user->createToken('food App' . $user->id)->accessToken;
                    $this->content['status'] = true;
                    $this->content['message'] = "Registered Successfully";
                    $user = User::find($user->id)->toArray();
                    $responseData = $this->convertToBlank($user);
                    $this->content['data'] = $responseData;
                    $status = 200;
                } else {

                    $this->content['status'] = false;
                    $this->content['message'] = "Error in Registering User";
                    $this->content['data'] = "";
                    $status = 200;

                }

            }
            return response()->json($this->content, $status);

        } else {
            $validator = Validator::make(
                [
                    'name' => $request->name,
                    'password' => $request->password,
                    'email' => $request->email,
                    'device_id' => $request->device_id,
                    'device' => $request->device,
                ],
                [
                    'name' => 'required|string|min:4',
                    'password' => 'required|min:6',
                    'email' => 'required|string|email|max:255',
                    'device_id' => 'required',
                    'device' => 'required',
                ]
            );


            if ($validator->fails()) {
                $errors = $validator->messages()->toArray();
                $vErrors = [];
                foreach ($errors as $key => $error) {

                    $vErrors['error'] = $error[0];
                    break;

                }

                $this->content['status'] = false;
                $this->content['message'] = "Data Validation Failed";
                $this->content['data'] = $vErrors;
                $status = 200;
                return response()->json($this->content, $status);
            }

            $userInfo = User::where(['email' => $request->email, 'usertype' => 'User'])->first();
            if (!empty($userInfo)) {

                $this->content['status'] = false;
                $this->content['message'] = "Error in Registering User";
                $this->content['data'] = "email is already in use";
                $status = 200;
                return response()->json($this->content, $status);

            }
            if ($request->has('email') && $request->has('password')) {
                $user = new User;
                $user->email = $request->input('email');
                $user->first_name = $user->name = $request->input('name');
                $user->mobile_no = $request->input('mobile_no');
                $user->device_id = $request->input('device_id');
                $user->device = $request->input('device');
                if ($request->input('profile_pic_url'))
                    $user->profile_pic_url = $request->input('profile_pic_url');
                $user->social = $request->input('social');

                $user->usertype = $request->input('usertype') ? $request->input('usertype') : 'User';
                $user->status = 1;
                $user->password = bcrypt($request->input('password'));
                if ($request->input('fcm_id') != "") {
                    $user->fcm_id = $request->input('fcm_id');

                }

                if ($user->save()) {
                    $userInfo = $user;
                    $this->content['token'] = $user->createToken('food App' . $user->id)->accessToken;
                    $this->content['status'] = true;
                    $this->content['message'] = "Registered Successfully";
                    $user = User::find($user->id)->toArray();
                    $responseData = $this->convertToBlank($user);
                    $this->content['data'] = $responseData;
                    $status = 200;
                    $verifyUser = VerifyUser::create([
                        'user_id' => $userInfo->id,
                        'token' => str_random(40)
                    ]);

                    \Mail::to($userInfo->email)->send(new VerifyMail($userInfo));
                } else {

                    $this->content['status'] = false;
                    $this->content['message'] = "Error in Registering User";
                    $this->content['data'] = "";
                    $status = 200;

                }
            } else {
                $this->content['status'] = false;
                $this->content['message'] = "Invalid request: Email or Password is missing";
                $this->content['data'] = "";
                $status = 200;
            }

            return response()->json($this->content, $status);
        }
    }

    public function isVerifiedUser(Request $request)
    {
        $user = User::find(Auth::user()->id);

        $this->content['status'] = true;
        $this->content['message'] = "User verification details";
        $responseData = ['email_verified' => (int)$user->email_verified, 'mobile_verified' => (int)$user->mobile_verified, 'status' => $user->status];
        $this->content['data'] = $responseData;
        $status = 200;

        return response()->json($this->content, $status);


    }

    /**
     * updateProfile app users.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateProfile(Request $request)
    {


        $validator = Validator::make(
            [

                'name' => $request->name,
                'email' => $request->email,

            ],
            [

                'name' => 'required|string|min:4',
                'email' => 'required|string|email|max:255|  unique:users,email,' . Auth::user()->id
            ]
        );


        if ($validator->fails()) {
            $errors = $validator->messages()->toArray();
            $vErrors = [];
            foreach ($errors as $key => $error) {

                $vErrors[$key] = $error[0];

            }

            $this->content['status'] = false;
            $this->content['message'] = "Data Validation Failed";
            $this->content['data'] = $vErrors;
            $status = 200;
            return response()->json($this->content, $status);
        }


        $userInfo = User::where(['id' => Auth::user()->id])->first();
        if ($userInfo) {

            $userInfo->name = $request->name;
            $userInfo->email = $request->email;
            $userInfo->mobile_no = $request->mobile_no;
            if ($request->profile_pic_url) {
                $imageName = time() . '.' . $request->profile_pic_url->getClientOriginalExtension();
                $request->profile_pic_url->move(public_path('upload'), $imageName);
                $userInfo->profile_pic_url = "http://donalds.in/upload/" . $imageName;
            }
            if ($request->input('fcm_id') != "") {
                $userInfo->fcm_id = $request->input('fcm_id');
            }
            $userInfo->save();
            $this->content['status'] = true;
            $this->content['message'] = "Profile Updated Successfully";
            $responseData = $this->convertToBlank($userInfo->toArray());
            $this->content['data'] = $responseData;
            $status = 200;

        } else {
            $this->content['status'] = false;
            $this->content['message'] = "Sorry:Invalid user Id";
            $this->content['data'] = "";
            $status = 200;
        }
        return response()->json($this->content, $status);
    }


    /**
     * changePassword app users.
     *
     * @return \Illuminate\Http\Response
     */
    public function changePassword(Request $request)
    {

        $user = Auth::user();

        $validator = Validator::make(
            [

                'current_password' => $request->current_password,
                'new_password' => $request->new_password,
                'confirm_password' => $request->confirm_password,

            ],
            [

                'current_password' => 'required|min:6',
                'new_password' => 'required|min:6',
                'confirm_password' => 'required_with:new_password|same:new_password|min:6'
            ]
        );


        if ($validator->fails()) {
            $errors = $validator->messages()->toArray();
            $vErrors = [];
            foreach ($errors as $key => $error) {

                $vErrors[$key] = $error[0];

            }

            $this->content['status'] = false;
            $this->content['message'] = "Data Validation Failed";
            $this->content['data'] = $vErrors;
            $status = 200;
            return response()->json($this->content, $status);
        }
        $userInfo = User::where(['id' => $user->id])->first();


        if ($userInfo) {
            if (!\Hash::check($request->current_password, $userInfo->password)) {
                $this->content['status'] = false;
                $this->content['message'] = "Current pasword does not match with our records";
                $status = 200;

            } else {
                $userInfo->password = bcrypt($request->confirm_password);
                if ($request->input('fcm_id') != "") {
                    $userInfo->fcm_id = $request->input('fcm_id');
                }
                $userInfo->save();
                $this->content['status'] = true;
                $this->content['message'] = "Password Updated Successfully";
                $this->content['data'] = $this->convertToBlank($userInfo->toArray());
                $status = 200;

            }

        } else {
            $this->content['status'] = false;
            $this->content['message'] = "Sorry:Invalid User Id";
            $this->content['data'] = "";
            $status = 200;
        }
        return response()->json($this->content, $status);
    }

    public function resendEmailVerificationMerchant(Request $request)
    {
        $validator = Validator::make(
            [

                'email' => $request->email
            ],
            [

                'email' => 'required|string|email|max:255'
            ]
        );
        if ($validator->fails()) {
            $errors = $validator->messages()->toArray();
            $vErrors = [];
            foreach ($errors as $key => $error) {

                $vErrors[$key] = $error[0];

            }

            $this->content['status'] = false;
            $this->content['message'] = "Data Validation Failed";
            $this->content['data'] = $vErrors;
            $status = 200;
            return response()->json($this->content, $status);
        }
        $userInfo = User::where(['email' => $request->email, 'usertype' => 'Merchant'])->first();

        if ($userInfo) {

            $this->content['status'] = true;
            $this->content['message'] = "Email verification mail sent successfully.";

            $this->content['data'] = "";
            $status = 200;
            $verifyUser = VerifyUser::create([
                'user_id' => $userInfo->id,
                'token' => str_random(40)
            ]);
            \Mail::to($userInfo->email)->send(new VerifyMail($userInfo));


        } else {
            $this->content['status'] = false;
            $this->content['message'] = "Sorry:This Email is not registered with us";
            $this->content['data'] = "";
            $status = 200;
        }
        return response()->json($this->content, $status);


    }

    public function resendEmailVerification(Request $request)
    {
        $validator = Validator::make(
            [

                'email' => $request->email
            ],
            [

                'email' => 'required|string|email|max:255'
            ]
        );
        if ($validator->fails()) {
            $errors = $validator->messages()->toArray();
            $vErrors = [];
            foreach ($errors as $key => $error) {

                $vErrors[$key] = $error[0];

            }

            $this->content['status'] = false;
            $this->content['message'] = "Data Validation Failed";
            $this->content['data'] = $vErrors;
            $status = 200;
            return response()->json($this->content, $status);
        }
        $userInfo = User::where(['email' => $request->email, 'usertype' => 'User'])->first();

        if ($userInfo) {

            //if user is already verfied his email then notify him
            if($userInfo->email_verified == 1)
            {
                $this->content['status'] = true;
                $this->content['message'] = "Email is already verified";
                $this->content['data'] = "";
                $status = 200;
                
                return response()->json($this->content, $status);
            }

            $this->content['status'] = false;
            $this->content['message'] = "Email verification mail sent successfully.";

            $this->content['data'] = "";
            $status = 200;
            $verifyUser = VerifyUser::create([
                'user_id' => $userInfo->id,
                'token' => str_random(40)
            ]);
            \Mail::to($userInfo->email)->send(new VerifyMail($userInfo));


        } else {
            $this->content['status'] = false;
            $this->content['message'] = "Sorry:This Email is not registered with us";
            $this->content['data'] = "";
            $status = 200;
        }
        return response()->json($this->content, $status);


    }

    /**
     * forgotPassword app users.
     *
     * @return \Illuminate\Http\Response
     */
    public function forgotPassword(Request $request)
    {

        $validator = Validator::make(
            [

                'email' => $request->email
            ],
            [

                'email' => 'required|string|email|max:255'
            ]
        );


        if ($validator->fails()) {
            $errors = $validator->messages()->toArray();
            $vErrors = [];
            foreach ($errors as $key => $error) {

                $vErrors[$key] = $error[0];

            }

            $this->content['status'] = false;
            $this->content['message'] = "Data Validation Failed";
            $this->content['data'] = $vErrors;
            $status = 200;
            return response()->json($this->content, $status);
        }


        $userInfo = User::where(['email' => $request->email])->first();
        if ($userInfo) {

            $this->content['status'] = true;
            $this->content['message'] = "We have sent reset password Information on your registered Email";

            $this->content['data'] = "";
            $status = 200;
            $data = array('name' => $userInfo->first_name, "body" => "Please click on below link to reset your password");
            //$request->only('email')

            $response = $this->passwords->sendResetLink($userInfo->email, function ($m) {
                $m->subject($this->getEmailSubject());
            });


        } else {
            $this->content['status'] = false;
            $this->content['message'] = "Sorry:This Email is not registered with us";
            $this->content['data'] = "";
            $status = 200;
        }
        return response()->json($this->content, $status);
    }


    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make(
            [

                'new_password' => $request->new_password,
                'confirm_password' => $request->confirm_password,

            ],
            [


                'new_password' => 'required|min:6',
                'confirm_password' => 'required_with:new_password|same:new_password|min:6'
            ]
        );
        if ($validator->fails()) {
            $errors = $validator->messages()->toArray();
            $vErrors = [];
            foreach ($errors as $key => $error) {

                $vErrors[$key] = $error[0];

            }

            $this->content['status'] = false;
            $this->content['message'] = "Data Validation Failed";
            $this->content['data'] = $vErrors;
            $status = 200;
            return response()->json($this->content, $status);
        }
        $user = User::find($user->id);
        $user->password = bcrypt($request->input('password'));
        if ($request->input('fcm_id') != "") {
            $user->fcm_id = $request->input('fcm_id');
        }
        if ($user->save()) {
            $this->content['status'] = true;
            $this->content['message'] = "Password Updated Successfully";
            $this->content['data'] = "";
            $status = 200;
            return response()->json($this->content, $status);
        } else {

            $this->content['status'] = false;
            $this->content['message'] = "Error in Updating Password";
            $this->content['data'] = "";
            $status = 200;
            return response()->json($this->content, $status);
        }
    }

    public function resendOTP(Request $request)
    {

        if ($request->mobile_no != "")
            $otpInfo = $this->sendOTP($request->mobile_no);
        else
            return "mobile number not found";

        // return $request->user()->id;
        if ($otpInfo['type'] == 'success') {
            DB::table('users')
                ->where('id', $request->user()->id)
                ->update(['otp' => $otpInfo['otp']]);
            return $request->user()->id;
        } else
            return "fail";
    }

    private function sendMsg($mobile_no , $status, $time , $price)
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
        if($status == "accepted")
        {
            $message = urlencode("Your order has been confirmend by the vendor, and it would be dispatched shortly.");
        }
        elseif ($status == "dispatched") {
            $message = urldecode("Your order has been dispatched by the vendor, and would reach you within $time minutes");
        }
        elseif($status == "delivered")
        {
            $message = "Your Donalds order number " . $time . ", amounting Rs. " . $price . " has been successfully delivered.";
        }
        elseif($status == "cancelled")
        {
            $message = "Sorry  your no " . $time . " is cancelled by Merchant.";
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

    
     public function updateFCM(Request $request)
     {

        $user = User::where('id',$request->id)->first();

        if($user)
        {
            DB::table('users')
            ->where('id',$request->id)
            ->update(['fcm_id' => $request->fcm_id]);    

            $this->content['message'] = "fcm id update successfully";
            $this->content['status'] = true;
            $status = 200;
        }
        else
        {
            $this->content['message'] = "invalid id";
            $this->content['status'] = false;
            $status = 200;
        }
        return response()->json($this->content, $status);
     }


     private function sendNotification($title, $body,$id,$user_type)
     {
        $token = User::where('id',$id)->first(['fcm_id']);
        $token = $token->fcm_id;
        $url = "https://fcm.googleapis.com/fcm/send";
        $serverKey = "";
        if($user_type == "merchant")
            $serverKey = 'AIzaSyCYXXukCx30qm1l_4G5VzOGqbXy_yxeQls';
        else
            $serverKey = 'AIzaSyDGURJzdBGWSW2fHWchO6qDBPOHakK-y-E';

        $notification = array('title' =>$title , 'body' => $body, 'sound' => 'default', 'badge' => '1');
        $arrayToSend = array('to' => $token, 'notification' => $notification,'priority'=>'high');
        $json = json_encode($arrayToSend);
        $headers = array();
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: key='. $serverKey;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
        //Send the request
        $response = curl_exec($ch);
        //Close request
        if ($response === FALSE) {
        die('FCM Send Error: ' . curl_error($ch));
        }
        curl_close($ch);
     }


     public function getNotification(Request $request)
     {
        $user = User::where('id',$request->id)->first();
        // if($user->usertype == "User")
        // {
            $token = $user->fcm_id;
            $url = "https://fcm.googleapis.com/fcm/send";
            $serverKey = "";
            if($user_type == "merchant")
                $serverKey = 'AIzaSyCYXXukCx30qm1l_4G5VzOGqbXy_yxeQls';
            else
                $serverKey = 'AIzaSyDGURJzdBGWSW2fHWchO6qDBPOHakK-y-E';

            $title = "";

            $body = Notifications::where('user_id',$id)->orderBy('id',DESC)->first(['text']);


            $notification = array('title' =>$title , 'body' => $body, 'sound' => 'default', 'badge' => '1');
            $arrayToSend = array('to' => $token, 'notification' => $notification,'priority'=>'high');
            $json = json_encode($arrayToSend);
            $headers = array();
            $headers[] = 'Content-Type: application/json';
            $headers[] = 'Authorization: key='. $serverKey;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
            curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
            //Send the request
            $response = curl_exec($ch);
            //Close request
            if ($response === FALSE) {
            die('FCM Send Error: ' . curl_error($ch));
        // }
            curl_close($ch); 
            
        }

     }

      public function resetotp()
      {

              $email = $_POST['email'];
              $usertype = $_POST['usertype'];

               $userInfo = User::where(['email' => $email, 'usertype' => $usertype])->first();

                if ($userInfo) 
                 {
                    $this->content['status'] = true;
                    $this->content['message'] = "Email verification mail sent successfully.";
                    $status = 200;
                    $randomNum = substr(str_shuffle("0123456789"), 0,4);
                   
                     $userId = $userInfo->id;
                     $user = User::findOrFail($userId);
                     $user->otp = $randomNum;
                     $result =  $user->save();
                     if($result)
                     {
                        $finalUserInfo = User::where(['email' => $email, 'usertype' => $usertype])->first();
                        \Mail::to($userInfo->email)->send(new VerifyOtp($finalUserInfo));
                     }
                     

                }
              else
                {
                    $this->content['status'] = false;
                    $this->content['message'] = "Sorry:This Email is not registered with us";
                    $status = 400;
                }

          return response()->json($this->content, $status);
     }


    public function resetpassword()
      {

              $email = $_POST['email'];
              $usertype = $_POST['usertype'];
              $password = $_POST['password'];
              $otp = $_POST['otp'];

               $userInfo = User::where(['email' => $email, 'usertype' => $usertype,'otp'=>$otp])->first();

                if ($userInfo) 
                 {
                    $this->content['status'] = true;
                    $this->content['message'] = "Change password successfully.";
                    $status = 200;
                    
                     $pass = bcrypt($password);
                     $userId = $userInfo->id;
                     $user = User::findOrFail($userId);
                     $user->password = $pass;
                     $result =  $user->save();
                     if($result)
                     {
                       
                        \Mail::to($userInfo->email)->send(new ChangePassword($userInfo));
                     }
                     

                }
              else
                {
                    $this->content['status'] = false;
                    $this->content['message'] = "Sorry:This Email is not registered with us";
                    $status = 400;
                }

          return response()->json($this->content, $status);
     }



}