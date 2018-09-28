@extends("inner")

@section('head_title', 'Verify Email' .' | '.getcong('site_name') )

@section('head_url', Request::url())

@section("content")


<div class="white_for_login" style="    margin-top: 150px; height: 300px;">
  <div class="container margin_60">
   
   <div class="row">

    <div class="col-md-3">

    </div>  
    <div class="col-md-6">
        <div class="box_style_2" id="order_process">
		<p style="    text-align: center;
    font-size: 22px;
    font-weight: bold;">	{{$status}}</p>
        </div>
        <!-- End box_style_1 --> 
      </div>
      <!-- End col-md-6 -->

 
   </div>
   
  </div>
 </div> 
 
 

        

@endsection
