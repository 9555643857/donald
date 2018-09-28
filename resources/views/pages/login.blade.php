@extends("inner")

@section('head_title', 'Login' .' | '.getcong('site_name') )

@section('head_url', Request::url())

@section("content")


<div class="white_for_login" style="margin-top:40px">
  <div class="container margin_60">
   
   <div class="row">

    <div class="col-md-3">

    </div>  
    <div class="col-md-6">
        <div class="box_style_2" id="order_process">
          <h2 class="inner">Login</h2>
			              {!! Form::open(array('url' => 'login','class'=>'','id'=>'login','role'=>'form')) !!} 
              <div class="message">
                         
                      @if (count($errors) > 0)
                          <div class="alert alert-danger">
                          
                              <ul>
                                  @foreach ($errors->all() as $error)
                                      <li>{{ $error }}</li>
                                  @endforeach
                              </ul>
                          </div>
                      @endif
                                    
        </div>
        @if(Session::has('flash_message'))

          <div class="alert alert-success fade in">
              
             {{ Session::get('flash_message') }}
           </div>

             
        @endif              
              <div class="form-group">
                <label>Email</label>
                <input type="email" placeholder="Your email" class="form-control" value="" name="email" id="email">
              </div>
              <div class="form-group">
                <label>Password</label>
                <input type="password" placeholder="Password" class="form-control" value="" name="password" id="password">
              </div>
              <button class="btn btn-submit" type="submit">Login</button>
            {!! Form::close() !!} 
        </div>
        <!-- End box_style_1 --> 
      </div>
      <!-- End col-md-6 -->

 
   </div>
   
  </div>
 </div> 
 
 

        

@endsection
