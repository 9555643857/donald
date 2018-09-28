@extends("inner")

@section('head_title', ucfirst($page->meta_title) .' | '.getcong('site_name') )
@section('head_description', ucfirst($page->meta_description)  )

@section('head_url', Request::url())

@section("content")
<style>
.home-banner .container{
	background:#fff;
}
.container.about_block {
   
    text-align: center;
}

div#home{
 margin-top: 170px;	
 min-height: 400px;
}
.home-banner{
	background-image:none;
	background-color:#fff;
}
h1.inner{
	margin-bottom:20px;
}
</style>

                  <section>
                     <div  id="home">
                        <div class="container">
                           <div class="row">
                             <div class="container about_block">
  
								<div class="col-md-8 col-md-offset-2" style="margin-bottom:10px">
								  <h1 class="inner">{{$page->title}}</h1>

									{!!$page->description!!}
								   
								 
								</div>
								
								
								@foreach($blogs as $blog)
								<div class="col-md-12" style="margin-bottom:20px">
									<div class="posts" style="border:1px solid #ccc;text-align:left;padding:20px">
									 <h2 class="inner" >{{$blog->title}}</h1>
										{!!$blog->description!!}
									</div>								 							 
								</div>
								@endforeach
							   
							  </div>
                           </div>
                        </div>
                     </div>
                  </section>
               </header>
 

@endsection
