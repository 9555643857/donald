<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\User;
use App\Pages;
use App\Http\Requests;
use Illuminate\Http\Request;
use Session;
use Intervention\Image\Facades\Image; 


class PagesController extends MainAdminController
{
	public function __construct()
    {
		// $this->middleware('auth');
		  
		parent::__construct(); 	
		  
    }
	public function show($slug){
		
		 $page = Pages::where(['slug'=>$slug])->first();
		 if(!$page){
			 abort('404');
		 }else{
			 if($slug=='blog'){
			    $blogs=	 Pages::where(['type'=>'blog'])->get();
				return view('blog.list',compact('page','blogs'));  
				
			 }else{
				return view('pages.master',compact('page')); 				 
			 }
			 
		 }
		
	}
	
    public function pages()    { 
        
              
        $pages = Pages::orderBy('title')->get();
        
        if(Auth::User()->usertype!="Admin"){

            \Session::flash('flash_message', 'Access denied!');

            return redirect('admin/dashboard');
            
        }
         
        return view('admin.pages.index',compact('pages'));
    }
    
    public function addeditPage()    { 
         
        if(Auth::User()->usertype!="Admin"){

            \Session::flash('flash_message', 'Access denied!');

            return redirect('admin/dashboard');
            
        }
        
        return view('admin.pages.addeditPage');
    }
    
    public function addnew(Request $request)
    { 
    	
    	$data =  \Input::except(array('_token')) ;
	    
	    $rule=array(
		        'title' => 'required'		         
		   		 );
	    
	   	 $validator = \Validator::make($data,$rule);
 
        if ($validator->fails())
        {
                return redirect()->back()->withErrors($validator->messages());
        } 
	    $inputs = $request->all();
		
		if(!empty($inputs['id'])){
           
            $type_obj = Pages::findOrFail($inputs['id']);

        }else{

            $type_obj = new Pages;

        }


		
		$type_obj->title = $inputs['title']; 
		$type_obj->description = $inputs['description']; 
		$type_obj->slug = $inputs['slug']; 
		$type_obj->meta_title = $inputs['meta_title']; 
		$type_obj->meta_description = $inputs['meta_description']; 
		 
		//dd($type_obj);
		 
	    $type_obj->save();
		
		if(!empty($inputs['id'])){

            \Session::flash('flash_message', 'Changes Saved');

            return \Redirect::back();
        }else{

            \Session::flash('flash_message', 'Added');

            return \Redirect::back();

        }		     
        
         
    }     
    
    public function editPage($id)    
    {     
    
    	  if(Auth::User()->usertype!="Admin"){

            \Session::flash('flash_message', 'Access denied!');

            return redirect('admin/dashboard');
            
        }
        	     
          $page = Pages::findOrFail($id);
          
          return view('admin.pages.addeditPage',compact('page'));
        
    }	 
    
    public function delete($id)
    {
    	if(Auth::User()->usertype!="Admin"){

            \Session::flash('flash_message', 'Access denied!');

            return redirect('admin/dashboard');
            
        }
        	
        $type = Pages::findOrFail($id);
        $type->delete();

        \Session::flash('flash_message', 'Deleted');

        return redirect()->back();

    }
     
    	
}
