@extends("admin.admin_app")

@section("content")

<div id="main">
	<div class="page-header">
		<h2> {{ isset($image->image) ? 'Edit: '. $image->image : 'Add Image' }}</h2>
		
		<a href="{{ URL::to('admin/restaurants/view/'.$restaurant_id.'/image') }}" class="btn btn-default-light btn-xs"><i class="md md-backspace"></i> Back</a>
	  
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
                {!! Form::open(array('url' => array('admin/restaurants/view/'.$restaurant_id.'/image/addimage'),'class'=>'form-horizontal padding-15','name'=>'image_form','id'=>'image_form','role'=>'form','enctype' => 'multipart/form-data')) !!} 
                
                <input type="hidden" name="restaurant_id" value="{{$restaurant_id}}">
                <input type="hidden" name="id" value="{{ isset($image->id) ? $image->id : null }}">

                <div class="form-group">
                    <label for="avatar" class="col-sm-3 control-label">Upload Image</label>
                    <div class="col-sm-9">
                        <div class="media">
                            <div class="media-left">
                                @if(isset($image->image))
                                 
                                    <img src="{{ URL::asset('upload/image/'.$image->image.'-s.jpg') }}" width="100" alt="image">
                                @endif
                                                                
                            </div>
                            <div class="media-body media-middle">
                                <input type="file" name="image" class="filestyle" required> 
                            </div>
                        </div>
    
                    </div>
                </div> 
                <hr>
                <div class="form-group">
                    <div class="col-md-offset-3 col-sm-9 ">
                    	<button type="submit" class="btn btn-primary">{{ isset($image->id) ? 'Edit Image ' : 'Add Image' }}</button>
                         
                    </div>
                </div>
                
                {!! Form::close() !!} 
            </div>
        </div>
   
    
</div>

@endsection