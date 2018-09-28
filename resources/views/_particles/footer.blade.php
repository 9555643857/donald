
  <footer>
   <div class="footer-area">
      <div class="container">
         <div class="row xs-text-center">
            <div class="col-sm-5">
               <div class="footer-left">
            <ul class="social_icons">            
           
            <li class="facebook"><a href="{{getcong_widgets('social_facebook')}}" target="_blank"><i class="icofont icofont-social-facebook"></i></a></li>
            <li><a href="{{getcong_widgets('social_twitter')}}" target="_blank"><i class="icofont icofont-social-twitter"></i></a></li>
            <li><a href="{{getcong_widgets('social_google')}}" target="_blank"><i class="icofont icofont-social-google-plus"></i></a></li>
            <li><a href="{{getcong_widgets('social_instagram')}}" target="_blank"><i class="icofont icofont-social-instagram"></i></a></li>
            <li><a href="{{getcong_widgets('social_pinterest')}}" target="_blank"><i class="icofont icofont-social-pinterest"></i></a></li>
			<li>@if(getcong('site_copyright'))
						
				{{getcong('site_copyright')}}
			
			@else
			
				Copyright © {{date('Y')}} {{getcong('site_name')}}. All rights reserved.

			@endif</li>
          
            
          </ul>  
               </div>
            </div>
            <div class="col-sm-7">
               <div class="footer-right">
                  <ul class="pull-right footer-menu list-inline xs-no-float">
                     <li><a href="/">Home</a></li>
					 <li><a href="/#users">About Us</a></li>
                     <li><a href="/mission">Mission</a></li>
                     <li><a href="/vision">Vision</a></li>
                     <li><a href="/team">Our Team</a></li>
					 <li><a href="/legal">Legal</a></li>
					 <!-- <li><a href="/faq">FAQ'S</a></li>-->
                     <li><a href="/help">Help & Support</a></li>
					
                  </ul>
               </div>
            </div>
         </div>
      </div>
   </div>
</footer>

<style> .social_icons li {display:inline-block}</style>