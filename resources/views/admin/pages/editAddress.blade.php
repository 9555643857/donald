@extends("admin.admin_app")

@section("content")

<div id="main">
	<div class="page-header">
		<h2> {{ isset($user->id) ? 'Edit: User' : 'Add User' }}</h2>
		
		<a href="{{ URL::to('admin/users') }}" class="btn btn-default-light btn-xs"><i class="md md-backspace"></i> Back</a>
	  
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
                {!! Form::open(array('url' => array('admin/users/address'),'class'=>'padding-15','name'=>'user_form','id'=>'user_form','role'=>'form','enctype' => 'multipart/form-data')) !!} 

                @foreach($addresses as $address)
                    <div class="address-div">
                        <input type="hidden" name="id[]" value="{{ isset($address->id) ? $address->id : null }}">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="" control-label">Flat No</label>
                                <input type="text" name="flat_no[]" value="{{ isset($address->flat_no) ? $address->flat_no : null }}" class="form-control" readonly required>
                            </div>
                            <div class="form-group">
                                <label for="" control-label">Colony</label>
                                <input type="text" name="colony[]" value="{{ isset($address->colony) ? $address->colony : null }}" class="form-control" readonly required>
                            </div>
                            <div class="form-group">
                                <label for="" control-label">Your Area</label>
                                <input type="text" name="area[]" value="{{ isset($address->area) ? $address->area : null }}" class="form-control" readonly required>
                            </div>

                            <div class="form-group">
                                <label for="" control-label">Landmark</label>
                                <input type="text" name="landmark[]" value="{{ isset($address->lanmark) ? $address->lanmark : null }}" class="form-control" readonly>
                            </div>

                            <div class="form-group">
                                <label for="" control-label">Your Ciry</label>
                                <input type="text" name="city[]" value="{{ isset($address->city) ? $address->city : null }}" class="form-control" readonly required>
                            </div>

                            <div class="form-group">
                                <label for="" control-label">Pincode</label>
                                <input type="text" name="pincode[]" value="{{ isset($address->pincode) ? $address->pincode : null }}" class="form-control" readonly required>
                            </div>

                            <div class="form-group">
                                <label for="" control-label">Your State</label>
                                <input type="text" name="state[]" value="{{ isset($address->state) ? $address->state : null }}" class="form-control" readonly required>
                            </div>

                            <button type="button" class="btn btn-primary btn-edit" >Edit</button>
                            <input type="submit" type="submit" class="btn btn-success" disabled value="Save">
                            <button type="button" class="btn btn-warning btn-cancel" disabled>Cancel</button>
                        </div>
                    </div>
                @endforeach
                <input type="hidden" name="size" value="{{ sizeof($addresses) }}">
                {!! Form::close() !!} 
            </div>
        </div>
   
    
</div>

@endsection

@section('javascript')
    <script type="text/javascript">
        $('.btn-edit').click(function(){
            var elem = $(this).parent();

           $(elem).find('input').removeAttr('readonly');
           $(elem).find('button , input').removeAttr('disabled');

        });

        $('.btn-cancel').click(function(){
            location.reload(true);
        });
    </script>
@endsection('javascript')