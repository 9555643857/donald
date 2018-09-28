<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\User;
use App\PromoCode;


use App\Http\Requests;
use Illuminate\Http\Request;
use Session;
use Intervention\Image\Facades\Image; 


class PromoController extends MainAdminController
{
	public function __construct()
    {
		 $this->middleware('auth');
		  
		parent::__construct(); 	
		  
    }
    public function promoCodes()    { 
        
              
        $promocodes = PromoCode::orderBy('id')->get();
        
        if(Auth::User()->usertype!="Admin"){

            \Session::flash('flash_message', 'Access denied!');

            return redirect('admin/dashboard');
            
        }
         
        return view('admin.pages.promocodes',compact('promocodes'));
    }
    
    public function addeditpromocode()    { 
         
        if(Auth::User()->usertype!="Admin"){

            \Session::flash('flash_message', 'Access denied!');

            return redirect('admin/dashboard');
            
        }

        $promotype='flat';  
        return view('admin.pages.addeditpromo',compact('promoDesc','promotype'));
    }
	
	public function editpromocode($id)    
    {     
    
    	  if(Auth::User()->usertype!="Admin"){

            \Session::flash('flash_message', 'Access denied!');

            return redirect('admin/dashboard');
            
        }

        	     
          $promo= PromoCode::findOrFail($id);
          
          return view('admin.pages.addeditpromo',compact('promo'));
        
    }
    
   public function store(Request $request){
		
		
        $this->validate($request, [
            
            'reward' => 'required',
        ]);
		$data['promoDesc']=$request->desc;
		$data['promotype']=$request->type;
		$now = time(); // or your date as well
		$your_date = strtotime($request->expires_at);
		$datediff =  $your_date-$now;
		\Promocodes::create($request->no_of_coupans,$request->reward, $data, ceil($datediff / (60 * 60 * 24)));
        \Session::flash('flash_message', 'Promo Code Added successfully');
		return redirect('admin/promocodes/add');
		
    }
	
	    public function update(Request $request, $id){
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
        ]);

        $promo = PromoCode::findOrFail($id);
		if($promo->count()){
			 $promo->update($request->all());
			 \Session::flash('flash_message', 'Promo Code updated successfully');
			
		}else{
			\Session::flash('flash_message', 'Something got wrong please, Try again!!');
		}
     
    }
    
    public function delete($id)
    {
    	if(Auth::User()->usertype!="Admin"){

            \Session::flash('flash_message', 'Access denied!');

            return redirect('admin/dashboard');
            
        }
        	
        $cat = Restaurants::findOrFail($id);
        $cat->delete();

        \Session::flash('flash_message', 'Deleted');

        return redirect()->back();

    }

    	
}
