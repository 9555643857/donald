<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\User;
use App\Restaurants;
use App\Categories;
use App\Menu;
use App\Order;
use App\Types;
use App\Review;
use App\RestaurantImages;

use App\Http\Requests;
use Illuminate\Http\Request;
use Session;
use Intervention\Image\Facades\Image; 


class RestaurantsController extends MainAdminController
{
	public function __construct()
    {
		 $this->middleware('auth');
		  
		parent::__construct(); 	
		  
    }
    public function restaurants()    { 
        
              
        $restaurants = Restaurants::orderBy('restaurant_name')->get();
        
        if(Auth::User()->usertype!="Admin"){

            \Session::flash('flash_message', 'Access denied!');

            return redirect('admin/dashboard');
            
        }
         
        return view('admin.pages.restaurants',compact('restaurants'));
    }
    
    public function addeditrestaurant()    { 
         
        if(Auth::User()->usertype!="Admin"){

            \Session::flash('flash_message', 'Access denied!');

            return redirect('admin/dashboard');
            
        }

        $types = Types::orderBy('type')->get();

        
        return view('admin.pages.addeditrestaurant',compact('types'));
    }
    
    public function addnew(Request $request)
    { 
    	
    	$data =  \Input::except(array('_token')) ;
	    
	    $rule=array(
		        'restaurant_type' => 'required',
                'restaurant_name' => 'required',
                'restaurant_address' => 'required',
                'restaurant_logo' => 'mimes:jpg,jpeg,gif,png' 		         
		   		 );
	    
	   	 $validator = \Validator::make($data,$rule);
 
        if ($validator->fails())
        {
                return redirect()->back()->withErrors($validator->messages());
        } 
	    $inputs = $request->all();
		
		if(!empty($inputs['id'])){
           
            $restaurant_obj = Restaurants::findOrFail($inputs['id']);

        }else{

            $restaurant_obj = new Restaurants;

        }


        //Slug

        if($inputs['restaurant_slug']=="")
        {
            $restaurant_slug = str_slug($inputs['restaurant_name'], "-");
        }
        else
        {
            $restaurant_slug =str_slug($inputs['restaurant_slug'], "-"); 
        }

        //Logo image
        $restaurant_logo = $request->file('restaurant_logo');
         
        if($restaurant_logo){
            
             \File::delete(public_path() .'/upload/restaurants/'.$restaurant_obj->restaurant_logo.'-b.jpg');
            \File::delete(public_path() .'/upload/restaurants/'.$restaurant_obj->restaurant_logo.'-s.jpg');
            
            $tmpFilePath = 'upload/restaurants/';          
             
            $hardPath = substr($restaurant_slug,0,100).'_'.time();
            
            $img = Image::make($restaurant_logo);

            $img->fit(120, 120)->save($tmpFilePath.$hardPath.'-b.jpg');
            $img->fit(98, 98)->save($tmpFilePath.$hardPath. '-s.jpg');

            $restaurant_obj->restaurant_logo = $hardPath;
             
        }
		if(!$inputs['id']){
			$user_id=Auth::User()->id;
			// dd($inputs['restaurant_type']);
			$restaurant_obj->user_id = $user_id;
		}


		
        $restaurant_obj->restaurant_type = implode(",",$inputs['restaurant_type']);
        $restaurant_obj->restaurant_id = "res" . substr($inputs['restaurant_name'], 0,3) . rand(100000,999999) . substr($inputs['restaurant_name'], 0,3); 
        $restaurant_obj->restaurant_name = $inputs['restaurant_name']; 
		$restaurant_obj->restaurant_slug = $restaurant_slug;
        $restaurant_obj->restaurant_address = $inputs['restaurant_address']; 
        $restaurant_obj->restaurant_description = $inputs['restaurant_description']; 
        $restaurant_obj->lat = $inputs['lat'];
		$restaurant_obj->delivery_charge = $inputs['delivery_charge'];
		$restaurant_obj->lng = $inputs['lng'];
		$restaurant_obj->max_delivery_distance = $inputs['max_delivery_distance'];
		$restaurant_obj->status = $inputs['status'];
		
		$restaurant_obj->gst_percentage = $inputs['gst_percentage'];
		$restaurant_obj->is_trail_available = $inputs['is_trail_available'];
		$restaurant_obj->delivery_time = $inputs['delivery_time'];
		$restaurant_obj->type = $inputs['type'];
		$restaurant_obj->packages_available = implode(",",$inputs['packages_available']);
		$restaurant_obj->availablity = implode(",",$inputs['availablity']);

        // echo "<pre>";
        // print_r($inputs);
        // die();
        $restaurant_obj->weekly_breakfast = $inputs["weekly_breakfast"];
        $restaurant_obj->weekly_lunch = $inputs["weekly_lunch"];
        $restaurant_obj->weekly_dinner = $inputs["weekly_dinner"];
        $restaurant_obj->monthly_breakfast = $inputs["monthly_breakfast"];
        $restaurant_obj->monthly_lunch = $inputs["monthly_lunch"];
        $restaurant_obj->monthly_dinner = $inputs["monthly_dinner"];
        $restaurant_obj->quarterly_breakfast = $inputs["quarterly_breakfast"];
        $restaurant_obj->quarterly_lunch = $inputs["quarterly_lunch"];
        $restaurant_obj->quarterly_dinner = $inputs["quarterly_dinner"];
        
        $restaurant_obj->monday_breakfast_open = $inputs["monday_breakfast_open"];
        $restaurant_obj->monday_breakfast_close = $inputs["monday_breakfast_close"];
        $restaurant_obj->monday_lunch_open = $inputs["monday_lunch_open"];
        $restaurant_obj->monday_lunch_close = $inputs["monday_lunch_close"];
        $restaurant_obj->monday_dinner_open = $inputs["monday_dinner_open"];
        $restaurant_obj->monday_dinner_close = $inputs["monday_dinner_close"];
        $restaurant_obj->tuesday_breakfast_open = $inputs["tuesday_breakfast_open"];
        $restaurant_obj->tuesday_breakfast_close = $inputs["tuesday_breakfast_close"];
        $restaurant_obj->tuesday_lunch_open = $inputs["tuesday_lunch_open"];
        $restaurant_obj->tuesday_lunch_close = $inputs["tuesday_lunch_close"];
        $restaurant_obj->tuesday_dinner_open = $inputs["tuesday_dinner_open"];
        $restaurant_obj->tuesday_dinner_close = $inputs["tuesday_dinner_close"];
        $restaurant_obj->wednesday_breakfast_open = $inputs["wednesday_breakfast_open"];
        $restaurant_obj->wednesday_breakfast_close = $inputs["wednesday_breakfast_close"];
        $restaurant_obj->wednesday_lunch_open = $inputs["wednesday_lunch_open"];
        $restaurant_obj->wednesday_lunch_close = $inputs["wednesday_lunch_close"];
        $restaurant_obj->wednesday_dinner_open = $inputs["wednesday_dinner_open"];
        $restaurant_obj->wednesday_dinner_close = $inputs["wednesday_dinner_close"];
        $restaurant_obj->thursday_breakfast_open = $inputs["thursday_breakfast_open"];
        $restaurant_obj->thursday_breakfast_close = $inputs["thursday_breakfast_close"];
        $restaurant_obj->thursday_lunch_open = $inputs["thursday_lunch_open"];
        $restaurant_obj->thursday_lunch_close = $inputs["thursday_lunch_close"];
        $restaurant_obj->thursday_dinner_open = $inputs["thursday_dinner_open"];
        $restaurant_obj->thursday_dinner_close = $inputs["thursday_dinner_close"];
        $restaurant_obj->friday_breakfast_open = $inputs["friday_breakfast_open"];
        $restaurant_obj->friday_breakfast_close = $inputs["friday_breakfast_close"];
        $restaurant_obj->friday_lunch_open = $inputs["friday_lunch_open"];
        $restaurant_obj->friday_lunch_close = $inputs["friday_lunch_close"];
        $restaurant_obj->friday_dinner_open = $inputs["friday_dinner_open"];
        $restaurant_obj->friday_dinner_close = $inputs["friday_dinner_close"];
        $restaurant_obj->saturday_breakfast_open = $inputs["saturday_breakfast_open"];
        $restaurant_obj->saturday_breakfast_close = $inputs["saturday_breakfast_close"];
        $restaurant_obj->saturday_lunch_open = $inputs["saturday_lunch_open"];
        $restaurant_obj->saturday_lunch_close = $inputs["saturday_lunch_close"];
        $restaurant_obj->saturday_dinner_open = $inputs["saturday_dinner_open"];
        $restaurant_obj->saturday_dinner_close = $inputs["saturday_dinner_close"];
        $restaurant_obj->sunday_breakfast_open = $inputs["sunday_breakfast_open"];
        $restaurant_obj->sunday_breakfast_close = $inputs["sunday_breakfast_close"];
        $restaurant_obj->sunday_lunch_open = $inputs["sunday_lunch_open"];
        $restaurant_obj->sunday_lunch_close = $inputs["sunday_lunch_close"];
        $restaurant_obj->sunday_dinner_open = $inputs["sunday_dinner_open"];
        $restaurant_obj->sunday_dinner_close = $inputs["sunday_dinner_close"];		 
		
		 
	    $restaurant_obj->save();
		
		if(!empty($inputs['id'])){

            \Session::flash('flash_message', 'Changes Saved');

            return \Redirect::back();
        }else{

            \Session::flash('flash_message', 'Added');

            return \Redirect::back();

        }		     
        
         
    }     
    
    public function editrestaurant($id)    
    {     
    
    	  if(Auth::User()->usertype!="Admin"){

            \Session::flash('flash_message', 'Access denied!');

            return redirect('admin/dashboard');
            
        }

          $types = Types::orderBy('type')->get();   	     
          $restaurant= Restaurants::findOrFail($id);
          
          // echo "<pre>";
          // print_r($restaurant);
          // die();

          return view('admin.pages.addeditrestaurant',compact('restaurant','types'));
        
    }	 
    
    public function delete($id)
    {
    	if(Auth::User()->usertype!="Admin"){

            \Session::flash('flash_message', 'Access denied!');

            return redirect('admin/dashboard');
            
        }
        	
        $cat = Restaurants::findOrFail($id);
        $user = User::where('id',$cat->user_id)->delete();
        $cat->delete();

        \Session::flash('flash_message', 'Deleted');

        return redirect()->back();

    }

    public function restaurantview($id)    
    {     
    
          if(Auth::User()->usertype!="Admin"){

            \Session::flash('flash_message', 'Access denied!');

            return redirect('admin/dashboard');
            
        }

           
          $restaurant= Restaurants::findOrFail($id);
          
          $categories_count = Categories::where(['restaurant_id' => $id])->count();

          $menu_count = Menu::where(['restaurant_id' => $id , 'status'=>1])->count();

          $order_count = Order::where(['restaurant_id' => $id])->count();

          $review_count = Review::where(['restaurant_id' => $id])->count();
		  
		  $image_count = RestaurantImages::where(['restaurant_id' => $id])->count();

          return view('admin.pages.restaurantview',compact('restaurant','categories_count','menu_count','order_count','review_count','image_count'));
        
    }   
    
    public function reviewlist($id)    { 
        
              
        $review_list = Review::where("restaurant_id", $id)->orderBy('date')->get();
        
        if(Auth::User()->usertype!="Admin"){

            \Session::flash('flash_message', 'Access denied!');

            return redirect('admin/dashboard');
            
        }
        
        $restaurant_id=$id; 
 

        return view('admin.pages.review_list',compact('review_list','restaurant_id'));
    } 

    public function imagelist($id)    { 
        
              
        $image_list = RestaurantImages::where("restaurant_id", $id)->orderBy('created_at')->get();
        
        if(Auth::User()->usertype!="Admin"){

            \Session::flash('flash_message', 'Access denied!');

            return redirect('admin/dashboard');
            
        }
        
        $restaurant_id=$id; 
 

        return view('admin.pages.image_list',compact('image_list','restaurant_id'));
    } 
    public function my_restaurants()    
    {     
    
          if(Auth::User()->usertype!="Merchant"){

            \Session::flash('flash_message', 'Access denied!');

            return redirect('admin/dashboard');
            
         }

         $user_id=Auth::User()->id;

         $restaurant= Restaurants::where('user_id',$user_id)->first();
         
          $types = Types::orderBy('type')->get();

         /* $restaurant= Restaurants::findOrFail($id);
          
          $categories_count = Categories::where(['restaurant_id' => $id])->count();

          $menu_count = Menu::where(['restaurant_id' => $id])->count();

          $order_count = Order::where(['restaurant_id' => $id])->count();

          $review_count = Review::where(['restaurant_id' => $id])->count();

          return view('admin.pages.restaurantview',compact('restaurant','categories_count','menu_count','order_count','review_count'));*/

          return view('admin.pages.owner_restaurantview',compact('restaurant','types'));
        
    } 

    public function owner_reviewlist()    { 
        
        
        if(Auth::User()->usertype!="Merchant"){

            \Session::flash('flash_message', 'Access denied!');

            return redirect('admin/dashboard');
            
        }
        

        $user_id=Auth::User()->id;

        $restaurant= Restaurants::where('user_id',$user_id)->first();

        $restaurant_id=$restaurant['id'];

        $review_list = Review::where("restaurant_id", $restaurant_id)->orderBy('date')->get();
       

        return view('admin.pages.owner.review_list',compact('review_list','restaurant_id'));
    }   
    	
}
