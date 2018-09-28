<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\User;
use App\Menu;
use App\Categories;
use App\Restaurants;
use App\RestaurantImages;
use App\Http\Requests;
use Illuminate\Http\Request;
use Session;
use Intervention\Image\Facades\Image; 


class ImageController extends MainAdminController
{
	public function __construct()
    {
		 $this->middleware('auth');
		  
		parent::__construct(); 	
		  
    }
    public function imagelist($id)    { 
        
              
        $image = RestaurantImages::where("restaurant_id", $id)->orderBy('created_at')->get();
        
        if(Auth::User()->usertype!="Admin"){

            \Session::flash('flash_message', 'Access denied!');

            return redirect('admin/dashboard');
            
        }

        $restaurant_id=$id;
         
        return view('admin.pages.image',compact('image','restaurant_id'));
    }
    
    public function addeditmenu($id)    { 
         
        if(Auth::User()->usertype!="Admin"){

            \Session::flash('flash_message', 'Access denied!');

            return redirect('admin/dashboard');
            
        }

        
        $restaurant_id=$id;

        return view('admin.pages.addeditimage',compact('restaurant_id'));
    }
    
    public function addnew(Request $request)
    { 
    	
    	$data =  \Input::except(array('_token')) ;
	    
	    $inputs = $request->all();
		
		if(!empty($inputs['id'])){
           
            $image = RestaurantImages::findOrFail($inputs['id']);

        }else{

            $image = new RestaurantImages;

        }
		
        //Logo image
        $r_image = $request->file('image');
         
        if($r_image){
            
            \File::delete(public_path() .'/upload/image/'.$image->image.'-b.jpg');
            \File::delete(public_path() .'/upload/image/'.$image->image.'-s.jpg');
            
            $tmpFilePath = 'upload/image/';          
             
            $hardPath = rand(0,10).'_'.time();
            
            $img = Image::make($r_image);

            $img->save($tmpFilePath.$hardPath.'-b.jpg');
            $img->fit(100, 100)->save($tmpFilePath.$hardPath. '-s.jpg');

            $image->image = $hardPath;
             
        }
		 
		$image->restaurant_id = $inputs['restaurant_id'];
      
		 
		
		 
	    $image->save();
		
		if(!empty($inputs['id'])){

            \Session::flash('flash_message', 'Changes Saved');

            return \Redirect::back();
        }else{

            \Session::flash('flash_message', 'Added');

            return \Redirect::back();

        }		     
        
         
    }     
    
    public function editmenu($id,$menu_id)    
    {     
    
    	  if(Auth::User()->usertype!="Admin"){

            \Session::flash('flash_message', 'Access denied!');

            return redirect('admin/dashboard');
            
        }
          


          $image = RestaurantImages::findOrFail($menu_id);
          
         
          $restaurant_id=$id;

          return view('admin.pages.addeditimage',compact('image','restaurant_id'));
        
    }	 
    
    public function delete($rest_id,$image_id)
    {
        
    	if(Auth::User()->usertype=="Admin" or Auth::User()->usertype=="Merchant")
        {
 
            $image = RestaurantImages::findOrFail($image_id);
            $image->delete();

            \Session::flash('flash_message', 'Deleted');

            return redirect()->back();
        }
        else
        {
            \Session::flash('flash_message', 'Access denied!');

            return redirect('admin/dashboard');
            
        
        }

    }

    public function owner_image()    
    { 
        
        
        $user_id=Auth::User()->id;

        $restaurant= Restaurants::where('user_id',$user_id)->first();

        $restaurant_id=$restaurant['id'];

        $image = RestaurantImages::where("restaurant_id", $restaurant_id)->orderBy('created_at')->get();
        
        if(Auth::User()->usertype!="Merchant"){

            \Session::flash('flash_message', 'Access denied!');

            return redirect('admin/dashboard');
            
        }

 
        return view('admin.pages.owner.image',compact('image','restaurant_id'));
   
    }

    public function owner_addeditimage(){ 

        if(Auth::User()->usertype!="Merchant"){

            \Session::flash('flash_message', 'Access denied!');

            return redirect('admin/dashboard');
            
        }

        $user_id=Auth::User()->id;

        $restaurant= Restaurants::where('user_id',$user_id)->first();

        $restaurant_id=$restaurant['id'];

               

        return view('admin.pages.owner.addeditimage',compact('restaurant_id'));
    }
    
    public function owner_editimage($menu_id)    
    {     
    
          if(Auth::User()->usertype!="Merchant"){

            \Session::flash('flash_message', 'Access denied!');

            return redirect('admin/dashboard');
            
        }
          
        $user_id=Auth::User()->id;

        $restaurant= Restaurants::where('user_id',$user_id)->first();

        $restaurant_id=$restaurant->id;

          $image = RestaurantImages::findOrFail($menu_id);
          
           

          return view('admin.pages.owner.addeditimage',compact('menu','restaurant_id'));
        
    } 
    	
}
