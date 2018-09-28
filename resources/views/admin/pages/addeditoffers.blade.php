@extends("admin.admin_app")

@section("content")

<div id="main">
	<div class="page-header">
		<h2> {{ isset($offer->image) ? 'Edit: '. $offer->image : 'Add Image' }}</h2>
		
		<a href="{{ URL::to('admin/offers') }}" class="btn btn-default-light btn-xs"><i class="md md-backspace"></i> Back</a>
	  
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
                {!! Form::open(array('url' => array('admin/offers'),'class'=>'form-horizontal padding-15','name'=>'image_form','id'=>'image_form','role'=>'form','enctype' => 'multipart/form-data')) !!} 
                
               
                <input type="hidden" name="id" value="{{ isset($offer->id) ? $offer->id : null }}">

                <div class="form-group">
                    <label for="avatar" class="col-sm-3 control-label">Upload Image</label>
                    <div class="col-sm-9">
                        <div class="media">
                            <div class="media-left">
                                @if(isset($offer->image))
                                 
                                    <img src="{{ URL::asset('upload/image/'.$offer->image.'-s.jpg') }}" width="100" alt="image">
                                @endif
                                                                
                            </div>
                            <div class="media-body media-middle">
                                <input type="file" name="image" class="filestyle"> 
                            </div>
                        </div>
    
                    </div>
                </div> 
				
				<div class="form-group">
                    <label for="avatar" class="col-sm-3 control-label">Status</label>
                    <div class="col-sm-9">
							<select id="basic" name="status" class="selectpicker show-tick form-control">
                               @if(isset($offer->status))  
                                    <option value="1" @if($offer->status==1) selected @endif >Active</option>
                                    <option value="0" @if($offer->status==0) selected @endif >Inactive</option>
                                     
                                @else

                                    
                                    <option value="0">Inactive</option> 
									<option value="1">Active</option>
                                
                                @endif                          
                            
                        </select>
                    </div>
                </div> 
                <div class="form-group">
                    <label class="col-sm-3 control-label">Offer Description</label>
                    <div class="col-sm-9">
                        @if(isset($offer->description))
                            <input type="text" name="description" id="description" value="{{ $offer->description }}" class="form-control" required="required">
                        @else
                            <input type="text" name="description" id="description" class="form-control" required="required">
                        @endif
                                                  
                    </div>
                </div> 

                <div class="form-group">
                    <label class="col-sm-3 control-label">Offer Message</label>
                    <div class="col-sm-9">
                        @if(isset($offer->message))
                            <input type="text" name="message" id="message" value="{{ $offer->message }}" class="form-control" required="required">
                        @else
                            <input type="text" name="message" id="message" class="form-control" required="required">                          
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-offset-3 col-sm-9 ">
                        <button type="submit" class="btn btn-primary">{{ isset($offer->id) ? 'Edit Image ' : 'Add Image' }}</button>
                         
                    </div>
                </div>
                {!! Form::close() !!} 
            </div>
        </div>
   
    
</div>

@endsection