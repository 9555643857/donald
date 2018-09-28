<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\User;
use App\Menu;
use App\Categories;
use App\Restaurants;
use App\Offers;
use App\RestaurantImages;
use App\Http\Requests;
use Illuminate\Http\Request;
use Session;
use Intervention\Image\Facades\Image; 


class OffersController extends MainAdminController
{
	public function __construct()
    {
		 $this->middleware('auth');
		  
		parent::__construct(); 	
		  
    }
    public function index()    { 
        
              
        $offers = Offers::all();
        
        if(Auth::User()->usertype!="Admin"){

            \Session::flash('flash_message', 'Access denied!');

            return redirect('admin/dashboard');
            
        }

                
        return view('admin.pages.offers',compact('offers'));
    }
    
	public function addOffers()    { 
         
        if(Auth::User()->usertype!="Admin"){

            \Session::flash('flash_message', 'Access denied!');

            return redirect('admin/dashboard');
            
        }

        
      

        return view('admin.pages.addeditoffers');
    }
	
    public function editOffers($id)    { 
         
        if(Auth::User()->usertype!="Admin"){

            \Session::flash('flash_message', 'Access denied!');

            return redirect('admin/dashboard');
            
        }

        
        $offer = Offers::findOrFail($id);

        return view('admin.pages.addeditoffers',compact('id','offer'));
    }
    
    public function addEditOffers(Request $request)
    { 
    	
    	$data =  \Input::except(array('_token')) ;
	    
	    $inputs = $request->all();
		
		if(!empty($inputs['id'])){
           
            $offer = Offers::findOrFail($inputs['id']);

        }else{

            $offer = new Offers;

        }
		
        //Logo image
        $r_image = $request->file('image');
         
        if($r_image){
            
            \File::delete(public_path() .'/upload/image/'.$offer->image.'-b.jpg');
            \File::delete(public_path() .'/upload/image/'.$offer->image.'-s.jpg');
            
            $tmpFilePath = 'upload/image/';          
             
            $hardPath = rand(0,10).'_'.time();
            
            $img = Image::make($r_image);

            $img->save($tmpFilePath.$hardPath.'-b.jpg');
            $img->fit(100, 100)->save($tmpFilePath.$hardPath. '-s.jpg');

            $offer->image = $hardPath;
             
        }
		 
		$offer->status = $inputs['status'];
        $offer->description = $inputs['description'];
        $offer->message = $inputs['message']; 
	    $offer->save();
		
		if(!empty($inputs['id'])){

            \Session::flash('flash_message', 'Changes Saved');

            return \Redirect::back();
        }else{

            \Session::flash('flash_message', 'Added');

            return \Redirect::back();

        }		     
        
         
    }     
    
    
    public function delete($image_id)
    {
        
    	if(Auth::User()->usertype=="Admin" or Auth::User()->usertype=="Merchant")
        {
 
            $image = Offers::findOrFail($image_id);
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
}
