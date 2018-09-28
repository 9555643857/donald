@extends("admin.admin_app")

@section("content")

<div id="main">
	<div class="page-header">
		<h2> {{ isset($page->title) ? 'Edit: '. $page->title : 'Add Blog' }}</h2>
		
		<a href="{{ URL::to('admin/blog') }}" class="btn btn-default-light btn-xs"><i class="md md-backspace"></i> Back</a>
	  
	</div>
	@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
	@endif
	 @if(Session::has('flash_message'))
				    <div class="alert alert-success">
				    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        
<span aria-hidden="true">&times;</span></button>
				        {{ Session::get('flash_message') }}
				    </div>
	@endif
   
   	<div class="panel panel-default">
            <div class="panel-body">
                {!! Form::open(array('url' => array('admin/blog/addpage'),'class'=>'form-horizontal padding-15','name'=>'page_form','id'=>'page_form','role'=>'form','enctype' => 'multipart/form-data')) !!} 
                <input type="hidden" name="id" value="{{ isset($page->id) ? $page->id : null }}">
                <div class="form-group">
                    <label for="" class="col-sm-3 control-label">Blog Title</label>
                      <div class="col-sm-9">
                        <input type="text" name="title" value="{{ isset($page->title) ? $page->title : null }}" class="form-control">
                    </div>
                </div> 
                <div class="form-group">
                    <label for="" class="col-sm-3 control-label">Blog URL</label>
                    <div class="col-sm-9">
                        <input type="text" name="slug" value="{{ isset($page->slug) ? $page->slug : null }}" class="form-control">
						<input type="hidden" name="type" value="blog" class="form-control">
                    </div>
                </div>
                 <div class="form-group">
                    <label for="" class="col-sm-3 control-label">Content</label>
                    <div class="col-sm-9">
                        <textarea name="description" id="description" cols="30" rows="8" class="summernote">{{ isset($page->description) ? $page->description : null }}</textarea>
                    </div>
                </div>
				<div class="form-group">
                    <label for="" class="col-sm-3 control-label">Meta title</label>
                    <div class="col-sm-9">
                        <input type="text" name="meta_title" value="{{ isset($page->meta_title) ? $page->meta_title : null }}" class="form-control">
                    </div>
                </div>
				<div class="form-group">
                    <label for="" class="col-sm-3 control-label">Meta description</label>
                    <div class="col-sm-9">
                        <textarea name="meta_description" id="meta_description" cols="30" rows="4" class="form-control">{{ isset($page->meta_description) ? $page->meta_description : null }}</textarea>
                    </div>
                </div>
                <hr>
                <div class="form-group">
                    <div class="col-md-offset-3 col-sm-9 ">
                    	<button type="submit" class="btn btn-primary">{{ isset($page->id) ? 'Edit Page ' : 'Add Page' }}</button>
                         
                    </div>
                </div>
                
                {!! Form::close() !!} 
            </div>
        </div>
   
    
</div>

@endsection