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
  
								<div class="col-md-8 col-md-offset-2">
								  <h1 class="inner">{{$page->title}}</h1>

									{!!$page->description!!}
								   
								 
								</div>
							   
							  </div>
                           </div>
                        </div>
                     </div>
                  </section>
               </header>
 

@endsection
