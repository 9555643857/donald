@extends("app")
@section("content")
 <style>
 
 .featured-item h3{
	 font-size:16px
 }
 </style>

<section>
   <div class="padding-big light-bg" id="users">
      <div class="container" style="background:#fff" >
         <div class="row text-center">
            <div class="col-sm-8 col-sm-offset-2">
               <div class="section-heading mb-50">
                  <h2 class="section-title title-border">{{getcong_widgets('about_title')}} </h2>
                    {!!getcong_widgets('about_desc')!!}
               </div>
            </div>
         </div>
		        
      </div>
      </div>
   </div>
</section>          
<section>
   <div class="padding-big app-overview-area" id="overview" >
      <div class="container" >
         <div class="row text-center">
            <div class="col-sm-8 col-sm-offset-2">
               <div class="section-heading">
                  <h2 class="section-title title-border">How it works</h2>
                  <p>We keep it SHORT & SIMPLE!</p>
				  <p><b>Now homemade food is just a tap away!</b></p>
				  

               </div>
            </div>
         </div>
         <div class="row flexbox-center xs-no-flexbox">
            <div class="col-md-4">
               <div class="app-overview-lists app-lists-left text-right">
                  <ul>
                     <li class="clearfix">
                        <div class="pull-right app-overview-icon"><i class="icofont circled-icon icofont-search"></i></div>
                        <div class="pull-left app-overview-content">
                           <h3>SEARCH WITHIN THE RANGE OF 3 KMS FROM YOUR LOCATION </h3>
                          
                        </div>
                     </li>
                     <li class="clearfix">
                        <div class="pull-right app-restaurant-menu"><i class="icofont circled-icon icofont-restaurant-menu"></i></div>
                        <div class="pull-left app-overview-content">
                           <h3>CHOOSE FROM THE BEST GIVEN OPTIONS 
</h3>
                         
                        </div>
                     </li>
                     <li class="clearfix">
                        <div class="pull-right app-overview-icon"><i class="icofont circled-icon icofont-cur-rupee-true"></i></div>
                        <div class="pull-left app-overview-content">
                           <h3>PAY AS PER YOUR CONVENIENCE </h3>
                          
                        </div>
                     </li>
                  </ul>
               </div>
            </div>
            <div class="col-md-4">
               <div class="text-center app-overiew-photo pb-45 pt-45"><img alt="iPhone" src="upload/{{getcong('home_slide_image2')}}" class="center-block img-responsive"></div>
            </div>
            <div class="col-md-4">
               <div class="app-overview-lists app-lists-right">
                  <ul>
                     <li class="clearfix">
                        <div class="pull-left app-overview-icon"><i class="icofont circled-icon icofont-soup-bowl"></i></div>
                        <div class="pull-right app-overview-content">
                           <h3>ENJOY THE FOOD 
</h3>
                         
                        </div>
                     </li>
                     <li class="clearfix">
                        <div class="pull-left app-overview-icon"><i class="icofont circled-icon icofont-cycling"></i></div>
                        <div class="pull-right app-overview-content">
                           <h3>REPEAT OR SUBSCRIBE THE PLAN!</h3>
                          
                        </div>
                     </li>

                  </ul>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>

<section>
   <div class="padding-big screenshots-area" id="screenshort" >
      <div class="container" >
         <div class="row text-center">
            <div class="col-sm-12 ">
               <div class="section-heading">
                  <h2 class="section-title title-border">Partner With Us</h2>
                   <div class="text-center featured-area" id="feature" >
      <div class="container" >
         <div class="row">
            <div class="col-md-3 col-sm-6 gray-border red-hover white-bg">
               <div class="featured-item">
                  <i class="icofont circled-icon icofont-user-alt-5"></i>
                  <h3>Register Online</h3>
                  <p></p>
               </div>
            </div>
            <div class="col-md-3 col-sm-6 gray-border red-hover white-bg">
               <div class="featured-item">
                  <i class="icofont circled-icon icofont-holding-hands"></i>
                  <h3>Sign Agreement</h3>
                  <p></p>
               </div>
            </div>
            <div class="col-md-3 col-sm-6 gray-border red-hover white-bg">
               <div class="featured-item">
                  <i class="icofont circled-icon icofont-diamond"></i>
                  <h3>Get account credentials from us</h3>
                  <p></p>
               </div>
            </div>
            <div class="col-md-3 col-sm-6 gray-border red-hover white-bg">
               <div class="featured-item">
                  <i class="icofont circled-icon icofont-space-shuttle"></i>
                  <h3>Get started with the orders!</h3>
                  <p></p>
               </div>
            </div>
         </div>
      </div>
   </div>
				 <div class="text-center" style='margin-top:20px'><a href="{{url('register')}}" class="btn-round btn btn-red btn-submit" type="submit">Partner With Us</a></div>
               </div>
            </div>
         </div>
    
	 </div>
   </div>
</section>	
<section>
   <div class="contact-area" id="contact">
      <div class="container">
         <div class="row text-center">
            <div class="col-sm-8 col-sm-offset-2">
               <div class="mb-50 section-heading">
                  <h2 class="section-title">Need Help ? <strong class="primary-color">Contact with Us</strong></h2>
                  <p></p>
               </div>
            </div>
         </div>
<div class="row">
            <div class="col-lg-6 border-right">
		@if(Session::has('flash_message_contact'))
          <div class="alert alert-success fade in" id="msg-contact">
              
             {{ Session::get('flash_message_contact') }}
           </div>

             
        @endif
               <div class="contact-form clearfix">
                  <form action="http://donalds.in/contact_send" method="post">
                     <div class="contact-field field-one-second pull-left"><label class="sr-only" for="name">Name:</label><input class="form-control" id="name" name="name" placeholder="Full Name" required=""></div>
					 {{ csrf_field() }} 
                     <div class="contact-field field-one-second pull-right"><label class="sr-only" for="email">Email</label><input name="email" class="form-control" id="email" placeholder="Email" required="" type="email"></div>
                     <div class="contact-field field-one-second  pull-left"><label class="sr-only" for="sub">Contact No</label><input class="form-control" name="phone" id="sub" placeholder="Contact No" ></div>
<div class="contact-field field-one-second pull-right"><label class="sr-only" for="sub">Subject</label><input class="form-control" id="sub" name="subject" placeholder="Subject" required=""></div>
                     <div class="contact-field"><label class="sr-only" for="message">Message</label><textarea name="message" class="form-control" id="message" placeholder="Your Message" ></textarea></div>
                     <div class="text-center"><button class="btn-round btn btn-red btn-submit" type="submit">Submit</button></div>
                  </form>
               </div>
            </div>

<div class="col-lg-6">
<ul class="cn-policy">
<li>24-48 hours revert policy</li>
<li>Contact:- 1234567890</li>
<li>Write us at:<a href="mailto:donaldslunchdelivery@gmail.com">donaldslunchdelivery@gmail.com</a></li>
<li>
Registered Office- B-201, Goel Tower, Anaura Chinhat, Faizabad Road, Lucknow, Uttar Pradesh- 227105
</li>
</ul>
</div>
</div>
      </div>
   </div>
</section>

<section>
   <div class="contact-area" id="subscribe" style="margin-top:30px">
      <div class="container">
	  
 
         <div class="row text-center">
            <div class="col-sm-8 col-sm-offset-2">
               <div class="mb-50 section-heading">
                  <h2 class="section-title">Subscribe <strong class="primary-color">Us</strong></h2>
                  <p>Subscribe to get all recent updates from us.</p>
			 @if(Session::has('flash_message_subscribe'))
				 

          <div class="alert alert-success fade in" id="msg-subscribe">
              
             {{ Session::get('flash_message_subscribe') }}
           </div>

             
        @endif  
               </div>
            </div>
         </div>
<div class="row">
            <div class="col-lg-12">
               <div class="contact-form clearfix">
                  <form action="http://donalds.in/subscribe" method="post">
                     
					 {{ csrf_field() }} 
					 <div class="contact-field col-lg-4"><label class="sr-only" for="name">City:</label><select class="form-control" name="city">
					 <option>Select City</option>
					 <option value="delhi">Delhi</option>
					 <option value="noida">Noida</option>
					 <option value="gurugram">Gurugram</option>
					 </select>
					 </div>
                     
					 
					 <div class="contact-field col-lg-4"><label class="sr-only" for="email">Email</label><input name="email" class="form-control" id="email" placeholder="Email" required="" type="email"></div>
                     
                     <div class="text-center col-lg-4"><button class="btn-round btn btn-red btn-submit" type="submit">Subscribe</button></div>
                  </form>
               </div>
            </div>


</div>
      </div>
   </div>
</section>

<section>
   <div class="app-download-area light-bg" id="download" >
      <div class="container" >
         <div class="row">
            <div class="col-md-6 col-md-offset-1 col-sm-7">
               <div class="xs-text-center app-download-content sm-no-margin">
                  <h2>Get <strong class="primary-color">Application</strong> Now!</h2>
                  <h5>It is <strong class="primary-color">free</strong> and you will love it.</h5>
                  <p>It is simple and you will love it.</p>
				  <p>Now get your everyday meals on a TAP, just download our iOS and Android App and order from the best options available!</p>
                  
                  <div class="clearfix btn-set download-btn"><a href="#"><img alt="Apple Store" src="front/img/demo-1/apple-store.png"> </a><a href="#"><img alt="Apple Store" src="front/img/demo-1/play-store.png"></a></div>
               </div>
            </div>
            <div class="col-sm-5 hidden-xs">
               <div class="app-download-photo"><img alt="iPhone" src="upload/{{getcong('home_slide_image3')}}"></div>
            </div>
         </div>
      </div>
   </div>
</section>  
	
		  
@endsection
