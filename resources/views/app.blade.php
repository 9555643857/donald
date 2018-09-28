<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>@yield('head_title', getcong('site_name'))</title>
<meta name="viewport"content="width=device-width, initial-scale=1.0">
<meta name="description" content="@yield('head_description', getcong('site_description'))" />

<meta property="og:type" content="article" />
<meta property="og:title" content="@yield('head_title',  getcong('site_name'))" />
<meta property="og:description" content="@yield('head_description', getcong('site_description'))" />
<meta property="og:image" content="@yield('head_image', url('/upload/logo.png'))" />
<meta property="og:url" content="@yield('head_url', url('/'))" />
<!-- Favicons-->
	<link rel="shortcut icon" href="{{ URL::asset('upload/'.getcong('site_favicon')) }}" type="image/x-icon">
<!--MAIN STYLE-->
            <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700"rel="stylesheet">
			<link href="{{ URL::asset('front/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
            <link href="{{ URL::asset('front/css/icofont.css') }}" rel="stylesheet">
            <link href="{{ URL::asset('front/css/animate.css') }}" rel="stylesheet">
            <link href="{{ URL::asset('front/css/owl.carousel.min.css') }}" rel="stylesheet">
			<link href="{{ URL::asset('front/css/common.css') }}" rel="stylesheet">
			<link href="{{ URL::asset('front/css/style-1.css') }}" rel="stylesheet">
			<link href="{{ URL::asset('front/css/responsive-1.css') }}" rel="stylesheet">
			<link href="{{ URL::asset('front/css/style.css') }}" rel="stylesheet">           
            <script src="{{ URL::asset('front/js/modernizr-2.8.3-respond-1.4.2.min.js') }}"></script>
          

{!!getcong('site_header_code')!!}

</head>
<body> 
	
	 	@include("_particles.header")  
	 	
	 	@yield("content")
	 	
	 	@include("_particles.footer")
	 	
	 

<script src="{{ URL::asset('front/js/jquery.2.1.1.min.js') }}"></script>
<script src="{{ URL::asset('front/js/bootstrap.min.js') }}"></script> 
<script src="{{ URL::asset('front/js/particles.min.js') }}"></script> 
<script src="{{ URL::asset('front/js/owl.carousel.min.js') }}"></script>
<script src="{{ URL::asset('front/js/jquery.magnific-popup.min.js') }}"></script> 
<script src="{{ URL::asset('front/js/jquery.easypiechart.min.js') }}"></script> 
<script src="{{ URL::asset('front/js/wow.min.js') }}"></script> 
<script src="{{ URL::asset('front/js/common.js') }}"></script> 
<script src="{{ URL::asset('front/js/own-menu.js') }}"></script>  
<script src="{{ URL::asset('front/js/main-1.js') }}"></script> 


<script>
if(window.location.href === 'http://donalds.in/legal')
{
$( ".about_block:first-child" ).removeClass().addClass( "col-md-12" );
}
</script>

 @if(Session::has('flash_message_subscribe'))
				 
			 <script>
				$(document).ready(function(){
					 $('html, body').animate({
						scrollTop: $("#msg-subscribe").offset().top
					}, 2000);
					
				})


				</script>
@endif

@if(Session::has('flash_message_contact'))
<script>
$(document).ready(function(){
	 $('html, body').animate({
        scrollTop: $("#msg-contact").offset().top
    }, 2000);
	
})


</script>

@endif
</body>
</html>