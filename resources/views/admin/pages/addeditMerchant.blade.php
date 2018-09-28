@extends("admin.admin_app")

@section("content")

<div id="main">
	<div class="page-header">
		<h2> {{ isset($user->id) ? 'Edit: Merchant' : 'Add Merchant' }}</h2>

		<a href="{{ URL::to('admin/merchants') }}" class="btn btn-default-light btn-xs"><i class="md md-backspace"></i> Back</a>

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
                {!! Form::open(array('url' => array('admin/merchant/adduser'),'class'=>'form-horizontal padding-15','name'=>'user_form','id'=>'user_form','role'=>'form','enctype' => 'multipart/form-data')) !!}
                <input type="hidden" name="id" value="{{ isset($user->id) ? $user->id : null }}">
                <input type="hidden" name="restaurant_id" value="{{ isset($restaurant->id) ?: null }}">

                <div class="form-group">
                    <label for="" class="col-sm-3 control-label">Restaurant name</label>
                    <div class="col-sm-9">
                        <input type="text" name="restaurant_name" value="{{ isset($restaurant->restaurant_name) ?: null }}" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label for="" class="col-sm-3 control-label">Merchant Full Name</label>
                    <div class="col-sm-9">
                        <input type="text" name="name" value="{{ isset($user->name) ? $user->name : null }}" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label for="" class="col-sm-3 control-label">Email</label>
                    <div class="col-sm-9">
                        <input type="text" name="email" value="{{ isset($user->email) ? $user->email : null }}" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label for="" class="col-sm-3 control-label">Restaurant Mobile</label>
                    <div class="col-sm-9">
                        <input type="text" name="mobile" value="{{ isset($user->mobile) ? $user->mobile : null }}" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label for="" class="col-sm-3 control-label">Owner Phone</label>
                    <div class="col-sm-9">
                        <input type="text" name="owner_mobile" value="{{ isset($user->mobile_no) ? $user->mobile_no : null }}" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-3 control-label">City</label>
                    <div class="col-sm-9">
                        <div class="input-group">

                            <select id="cityList" name="city" class="form-control">
                                @foreach($cities as $city)
                                <option value="{{ $city->city_name }}">{{ $city->city_name }}</option>
                                @endforeach
                            </select>


                            <div class="input-group-addon">
                                <a href="javascript:void(0)" data-toggle="modal" data-target="#addCityModal">+ Add New</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="form-group">
                    <label for="" class="col-sm-3 control-label">Postal Code</label>
                    <div class="col-sm-9">
                        <input type="text" name="postal_code" value="{{ isset($user->postal_code) ? $user->postal_code : null }}" class="form-control">
                    </div>
                </div> -->
                 <div class="form-group">
                    <label for="" class="col-sm-3 control-label">Address</label>
                    <div class="col-sm-9">

                        <textarea name="address" cols="30" rows="5" class="form-control">{{ isset($user->address) ? $user->address : null }}</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <input type="hidden" value="Merchant" name="usertype" />
                </div>
              <div class="form-group">
                    <label for="" class="col-sm-3 control-label">User Status</label>
                    <div class="col-sm-4">
                        @if($user->status == 1)
                        <div class="text-success">Active</div>
                        @else
                        <div class="text-danger">Inactive</div>
                        @endif
                        <!-- old code for select active and inactive user -->
                        <!-- <select id="basic" name="status" class="selectpicker show-tick form-control">
                               @if(isset($user->status))
                                    <option value="1" @if($user->status==1) selected @endif >Active</option>
                                    <option value="0" @if($user->status==0) selected @endif >Inactive</option>

                                @else


                                    <option value="0">Inactive</option>
									<option value="1">Active</option>

                                @endif

                        </select> -->
                    </div>
              </div>

              <div class="form-group">
                <label for="" class="control-label col-sm-3">Email Verified</label>
                <div class="col-sm-4">
                    @if($user->email_verified == 1)
                    <div class="text-success">Verified</div>
                    @else
                    <div class="text-danger">Not Verified</div>
                    @endif

                </div>
              </div>
                <hr>
                <div class="form-group">
                    <div class="col-md-offset-3 col-sm-9 ">
                    	<button type="submit" class="btn btn-primary">{{ isset($user->name) ? 'Edit User ' : 'Add Merchant' }}</button>

                    </div>
                </div>

                {!! Form::close() !!}
            </div>
        </div>


</div>


<!-- Modal -->
<div class="modal fade" id="addCityModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add City</h4>
      </div>
        <form action="{{ route('addCity') }}" id="addCityForm" class="form">
            <div class="modal-body">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="cityName">City Name</label>
                    <input type="text" required="required" class="form-control" id="cityName" placeholder="Delhi" name="city_name">
                </div>
                <span class="text-danger" id="cityNameErr"></span>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
              </div>
      </form>
    </div>
  </div>
</div>

<script>

    $("#addCityForm").on('submit',function(e){
        e.preventDefault();
        $this = $(this);
        $.ajax({
            url:$this.attr('action'),
            type:'POST',
            data:$this.serialize(),
            success:function(data){
                if(data == 0){
                    $("#cityNameErr").text('Invalid city name or city already exist.');
                    return false;
                }
                $("#addCityModal").modal('hide');
                $("#cityNameErr").text('');
                $("#cityList").append('<option value="'+data+'">'+data+'</option');
                alert('New city added successfully.');
            },
        })
    });
</script>

@endsection