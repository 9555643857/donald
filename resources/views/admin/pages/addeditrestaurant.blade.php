<!-- @extends("admin.admin_app") -->

@section("content")

<div id="main">
	<div class="page-header">
		<h2> {{ isset($restaurant->restaurant_name) ? 'Edit: '. $restaurant->restaurant_name : 'Add Restaurant' }}</h2>
		
		<a href="{{ URL::to('admin/restaurants') }}" class="btn btn-default-light btn-xs"><i class="md md-backspace"></i> Back</a>
	  
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
                {!! Form::open(array('url' => array('admin/restaurants/addrestaurant'),'class'=>'form-horizontal padding-15','name'=>'category_form','id'=>'category_form','role'=>'form','enctype' => 'multipart/form-data')) !!} 
                <input type="hidden" name="id" value="{{ isset($restaurant->id) ? $restaurant->id : null }}">
                <div class="form-group">
                    <label for="" class="col-sm-3 control-label">Restaurant Type</label>
                    <div class="col-sm-9">
                        <select id="basic" name="restaurant_type[]" multiple class="selectpicker show-tick form-control">
                            <option value="">Select Type</option>
                            
                            @foreach($types as $i => $type)    
                                @if(isset($restaurant->restaurant_type) && in_array($type->id,explode(",",$restaurant->restaurant_type)))  
                                    <option value="{{$type->id}}" selected >{{$type->type}}</option>
                                     
                                @else
                                <option value="{{$type->id}}">{{$type->type}}</option> 
                                @endif                          
                            @endforeach
                        </select>
                    </div>
                </div>
				
				 <div class="form-group">
                    <label for="" class="col-sm-3 control-label">Veg/Non-Veg/Both</label>
                    <div class="col-sm-9">
					@php
						$types=['veg','non veg','both'];
					@endphp
                        <select id="basic" name="type"  class="selectpicker show-tick form-control">
                            <option value="">Please Select </option>
                            
                            @foreach($types as $i => $type)    
                                @if(isset($restaurant->type) && $restaurant->type==$type)  
                                    <option value="{{$type}}" selected >{{$type}}</option>    
                                @else
                                <option value="{{$type}}">{{$type}}</option> 
                                @endif                          
                            @endforeach
                        </select>
                    </div>
                </div>
				
				<div class="form-group">
                    <label for="" class="col-sm-3 control-label">Packages Available</label>
                    <div class="col-sm-9">
					@php
						$packages=['daily','weekly','monthly','quarterly'];
					@endphp
						<select id="basic" name="packages_available[]" multiple class="selectpicker show-tick form-control">
                            <option value="">Select Packages</option>
                            
                            @foreach($packages as $i => $package)    
                                @if(isset($restaurant->packages_available) && in_array($package,explode(",",$restaurant->packages_available)))  
                                    <option value="{{$package}}" selected >{{$package}}</option>
                                     
                                @else
                                <option value="{{$package}}">{{$package}}</option> 
                                @endif                          
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-3 control-label">Restaurant Name</label>
                      <div class="col-sm-9">
                        <input type="text" name="restaurant_name" value="{{ isset($restaurant->restaurant_name) ? $restaurant->restaurant_name : null }}" class="form-control">
                    </div>
                </div>
				<div class="form-group">
                    <label for="" class="col-sm-3 control-label">Restaurant Max delivery Distance</label>
                      <div class="col-sm-9">
                        <input type="text" name="max_delivery_distance" value="{{ isset($restaurant->max_delivery_distance) ? $restaurant->max_delivery_distance : null }}" class="form-control">
                    </div>
                </div>
				<div class="form-group">
                    <label for="" class="col-sm-3 control-label">Delivery charge</label>
                      <div class="col-sm-9">
                        <input type="text" name="delivery_charge" value="{{ isset($restaurant->delivery_charge) ? $restaurant->delivery_charge : null }}" class="form-control">
                    </div>
                </div>
				
				<div class="form-group">
                    <label for="" class="col-sm-3 control-label">Availablity</label>
                    <div class="col-sm-9">
                        <select id="basic" name="availablity[]" multiple class="selectpicker show-tick form-control">
                            <option value="">Select Availablity</option>
                            @php
							 $availablity=['Breakfast','Lunch','Dinner']
							@endphp
                            @foreach($availablity as $i => $type)    
                                @if(isset($restaurant->availablity) && in_array($type,explode(",",$restaurant->availablity)))  
                                    <option value="{{$type}}" selected >{{$type}}</option>
                                     
                                @else
                                <option value="{{$type}}">{{$type}}</option> 
                                @endif                          
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="" class="col-sm-3 control-label">Restaurant Slug</label>
                    <div class="col-sm-9">
                        <input type="text" name="restaurant_slug" value="{{ isset($restaurant->restaurant_slug) ? $restaurant->restaurant_slug : null }}" class="form-control">
                    </div>
                </div>

				<div class="form-group">
                    <label for="" class="col-sm-3 control-label">Restaurant Latitude</label>
                    <div class="col-sm-9">
                        <input type="text" name="lat" value="{{ isset($restaurant->lat) ? $restaurant->lat : null }}" class="form-control">
                    </div>
                </div>
				<div class="form-group">
                    <label for="" class="col-sm-3 control-label">Restaurant Longitude</label>
                    <div class="col-sm-9">
                        <input type="text" name="lng" value="{{ isset($restaurant->lng) ? $restaurant->lng : null }}" class="form-control">
                    </div>
                </div>
				<div class="form-group">
                    <label for="" class="col-sm-3 control-label">Restaurant GST Percentage</label>
                    <div class="col-sm-9">
                        <input type="text" name="gst_percentage" value="{{ isset($restaurant->gst_percentage) ? $restaurant->gst_percentage : null }}" class="form-control">
                    </div>
                </div>
				<div class="form-group">
                    <label for="" class="col-sm-3 control-label">Restaurant Delivery Time in mins</label>
                    <div class="col-sm-9">
                        <input type="text" name="delivery_time" value="{{ isset($restaurant->delivery_time) ? $restaurant->delivery_time : null }}" class="form-control">
                    </div>
                </div>
				<div class="form-group">
                    <label for="" class="col-sm-3 control-label">Is Trail Available</label>
                    <div class="col-sm-9">
					@php
						$is_trail_available=['no','yes'];
					@endphp
                        <select id="basic" name="is_trail_available"  class="selectpicker show-tick form-control">
                            <option value="">Please Select </option>
                            
                            @foreach($is_trail_available as $i => $trial)    
                                @if(isset($restaurant->is_trail_available) && $restaurant->is_trail_available==$trial)  
                                    <option value="{{$trial}}" selected >{{$trial}}</option>
                                     
                                @else
                                <option value="{{$trial}}">{{$trial}}</option> 
                                @endif                          
                            @endforeach
                        </select>
                    </div>
                </div>


                <div class="form-group">
                    <label for="" class="col-sm-3 control-label">Weekly Breakfast</label>
                      <div class="col-sm-9">
                         
                        <input id="touch-spin-2" data-toggle="touch-spin" data-min="-1000000" data-max="1000000" data-prefix="$" data-step="1" type="text" value="{{ isset($restaurant->weekly_breakfast) ? $restaurant->weekly_breakfast : null }}" name="weekly_breakfast" class="form-control"/>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-3 control-label">Weekly Lunch</label>
                      <div class="col-sm-9">
                         
                        <input id="touch-spin-2" data-toggle="touch-spin" data-min="-1000000" data-max="1000000" data-prefix="$" data-step="1" type="text" value="{{ isset($restaurant->weekly_lunch) ? $restaurant->weekly_lunch : null }}" name="weekly_lunch" class="form-control"/>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-3 control-label">Weekly Dinner</label>
                      <div class="col-sm-9">
                         
                        <input id="touch-spin-2" data-toggle="touch-spin" data-min="-1000000" data-max="1000000" data-prefix="$" data-step="1" type="text" value="{{ isset($restaurant->weekly_dinner) ? $restaurant->weekly_dinner : null }}" name="weekly_dinner" class="form-control"/>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-3 control-label">Monthly Breakfast</label>
                      <div class="col-sm-9">
                         
                        <input id="touch-spin-2" data-toggle="touch-spin" data-min="-1000000" data-max="1000000" data-prefix="$" data-step="1" type="text" value="{{ isset($restaurant->monthly_breakfast) ? $restaurant->monthly_breakfast : null }}" name="monthly_breakfast" class="form-control"/>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-3 control-label">Monthly Lunch</label>
                      <div class="col-sm-9">
                         
                        <input id="touch-spin-2" data-toggle="touch-spin" data-min="-1000000" data-max="1000000" data-prefix="$" data-step="1" type="text" value="{{ isset($restaurant->monthly_lunch) ? $restaurant->monthly_lunch : null }}" name="monthly_lunch" class="form-control"/>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-3 control-label">Monthly Dinner</label>
                      <div class="col-sm-9">
                         
                        <input id="touch-spin-2" data-toggle="touch-spin" data-min="-1000000" data-max="1000000" data-prefix="$" data-step="1" type="text" value="{{ isset($restaurant->monthly_dinner) ? $restaurant->monthly_dinner : null }}" name="monthly_dinner" class="form-control"/>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-3 control-label">Quarterly Breakfast</label>
                      <div class="col-sm-9">
                         
                        <input id="touch-spin-2" data-toggle="touch-spin" data-min="-1000000" data-max="1000000" data-prefix="$" data-step="1" type="text" value="{{ isset($restaurant->quarterly_breakfast) ? $restaurant->quarterly_breakfast : null }}" name="quarterly_breakfast" class="form-control"/>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-3 control-label">Quarterly Lunch</label>
                      <div class="col-sm-9">
                         
                        <input id="touch-spin-2" data-toggle="touch-spin" data-min="-1000000" data-max="1000000" data-prefix="$" data-step="1" type="text" value="{{ isset($restaurant->quarterly_lunch) ? $restaurant->quarterly_lunch : null }}" name="quarterly_lunch" class="form-control"/>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-3 control-label">Quarterly Dinner</label>
                      <div class="col-sm-9">
                         
                        <input id="touch-spin-2" data-toggle="touch-spin" data-min="-1000000" data-max="1000000" data-prefix="$" data-step="1" type="text" value="{{ isset($restaurant->quarterly_dinner) ? $restaurant->quarterly_dinner : null }}" name="quarterly_dinner" class="form-control"/>
                    </div>
                </div>






                <div class="form-group">
                    <label for="" class="col-sm-3 control-label">Address</label>
                    <div class="col-sm-9">
                        <textarea name="restaurant_address" id="restaurant_address" cols="60" rows="3" class="form-control">{{ isset($restaurant->restaurant_address) ? $restaurant->restaurant_address : null }}</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-3 control-label">Description</label>
                    <div class="col-sm-9">
                        <textarea name="restaurant_description" id="restaurant_description" cols="30" rows="8" class="summernote">{{ isset($restaurant->restaurant_description) ? $restaurant->restaurant_description : null }}</textarea>
                    </div>
                </div>
               
                 <div class="form-group">
                    <label for="avatar" class="col-sm-3 control-label">Restaurant Logo</label>
                    <div class="col-sm-9">
                        <div class="media">
                            <div class="media-left">
                                @if(isset($restaurant->restaurant_logo))
                                 
                                    <img src="{{ URL::asset('upload/restaurants/'.$restaurant->restaurant_logo.'-s.jpg') }}" width="100" alt="person">
                                @endif
                                                                
                            </div>
                            <div class="media-body media-middle">
                                <input type="file" name="restaurant_logo" class="filestyle"> 
                            </div>
                        </div>
    
                    </div>
                </div>
                
                <h4>Opening time</h4> 
                
                <div class="row">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-9">
                        <div class="col-sm-4"><center><label for="">Breakfast</label></center></div>
                        <div class="col-sm-4"><center><label for="">Lunch</label></center></div>
                        <div class="col-sm-4"><center><label for="">Dinner</label></center></div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-3"><label for="">Monday</label></div>
                    <div class="col-sm-9">
                        <div class="col-sm-4">
                                <div class="col-sm-6"><input type="text" name="monday_breakfast_open" id="monday_breakfast_open" placeholder="open" class="form-control" value="{{ isset($restaurant->monday_breakfast_open) ? $restaurant->monday_breakfast_open : null }}"></div>
                                <div class="col-sm-6"><input type="text" name="monday_breakfast_close" id="monday_breakfast_close"  placeholder="close" class="form-control" value="{{ isset($restaurant->monday_breakfast_close) ? $restaurant->monday_breakfast_close : null }}"></div>
                        </div>
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-sm-6"><input type="text" name="monday_lunch_open" id="monday_lunch_open" placeholder="open" class="form-control" value="{{ isset($restaurant->monday_lunch_open) ? $restaurant->monday_lunch_open : null }}"></div>
                                <div class="col-sm-6"><input type="text" name="monday_lunch_close" id="monday_lunch_close"  placeholder="close" class="form-control" value="{{ isset($restaurant->monday_lunch_close) ? $restaurant->monday_lunch_close : null }}"></div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-sm-6"><input type="text" name="monday_dinner_open" id="monday_dinner_open" placeholder="open" class="form-control" value="{{ isset($restaurant->monday_dinner_open) ? $restaurant->monday_dinner_open : null }}"></div>
                                <div class="col-sm-6"><input type="text" name="monday_dinner_close" id="monday_dinner_close"  placeholder="close" class="form-control" value="{{ isset($restaurant->monday_dinner_close) ? $restaurant->monday_dinner_close : null }}"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>

                <div class="form-group">
                    <div class="col-sm-3"><label for="">Tuesday</label></div>
                    <div class="col-sm-9">
                        <div class="col-sm-4">
                                <div class="col-sm-6"><input type="text" name="tuesday_breakfast_open" id="tuesday_breakfast_open" placeholder="open" class="form-control" value="{{ isset($restaurant->tuesday_breakfast_open) ? $restaurant->tuesday_breakfast_open : null }}"></div>
                                <div class="col-sm-6"><input type="text" name="tuesday_breakfast_close" id="tuesday_breakfast_close"  placeholder="close" class="form-control" value="{{ isset($restaurant->tuesday_breakfast_close) ? $restaurant->tuesday_breakfast_close : null }}"></div>
                        </div>
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-sm-6"><input type="text" name="tuesday_lunch_open" id="tuesday_lunch_open" placeholder="open" class="form-control" value="{{ isset($restaurant->tuesday_lunch_open) ? $restaurant->tuesday_lunch_open : null }}"></div>
                                <div class="col-sm-6"><input type="text" name="tuesday_lunch_close" id="tuesday_lunch_close"  placeholder="close" class="form-control" value="{{ isset($restaurant->tuesday_lunch_close) ? $restaurant->tuesday_lunch_close : null }}"></div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-sm-6"><input type="text" name="tuesday_dinner_open" id="tuesday_dinner_open" placeholder="open" class="form-control" value="{{ isset($restaurant->tuesday_dinner_open) ? $restaurant->tuesday_dinner_open : null }}"></div>
                                <div class="col-sm-6"><input type="text" name="tuesday_dinner_close" id="tuesday_dinner_close"  placeholder="close" class="form-control" value="{{ isset($restaurant->tuesday_dinner_close) ? $restaurant->tuesday_dinner_close : null }}"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>

                <div class="form-group">
                    <div class="col-sm-3"><label for="">Wednesday</label></div>
                    <div class="col-sm-9">
                        <div class="col-sm-4">
                                <div class="col-sm-6"><input type="text" name="wednesday_breakfast_open" id="wednesday_breakfast_open" placeholder="open" class="form-control" value="{{ isset($restaurant->wednesday_breakfast_open) ? $restaurant->wednesday_breakfast_open : null }}"></div>
                                <div class="col-sm-6"><input type="text" name="wednesday_breakfast_close" id="wednesday_breakfast_close"  placeholder="close" class="form-control" value="{{ isset($restaurant->wednesday_breakfast_close) ? $restaurant->wednesday_breakfast_close : null }}"></div>
                        </div>
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-sm-6"><input type="text" name="wednesday_lunch_open" id="wednesday_lunch_open" placeholder="open" class="form-control" value="{{ isset($restaurant->wednesday_lunch_open) ? $restaurant->wednesday_lunch_open : null }}"></div>
                                <div class="col-sm-6"><input type="text" name="wednesday_lunch_close" id="wednesday_lunch_close"  placeholder="close" class="form-control" value="{{ isset($restaurant->wednesday_lunch_close) ? $restaurant->wednesday_lunch_close : null }}"></div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-sm-6"><input type="text" name="wednesday_dinner_open" id="wednesday_dinner_open" placeholder="open" class="form-control" value="{{ isset($restaurant->wednesday_dinner_open) ? $restaurant->wednesday_dinner_open : null }}"></div>
                                <div class="col-sm-6"><input type="text" name="wednesday_dinner_close" id="wednesday_dinner_close"  placeholder="close" class="form-control" value="{{ isset($restaurant->wednesday_dinner_close) ? $restaurant->wednesday_dinner_close : null }}"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>

                <div class="form-group">
                    <div class="col-sm-3"><label for="">Thursday</label></div>
                    <div class="col-sm-9">
                        <div class="col-sm-4">
                                <div class="col-sm-6"><input type="text" name="thursday_breakfast_open" id="thursday_breakfast_open" placeholder="open" class="form-control" value="{{ isset($restaurant->thursday_breakfast_open) ? $restaurant->thursday_breakfast_open : null }}"></div>
                                <div class="col-sm-6"><input type="text" name="thursday_breakfast_close" id="thursday_breakfast_close"  placeholder="close" class="form-control" value="{{ isset($restaurant->thursday_breakfast_close) ? $restaurant->thursday_breakfast_close : null }}"></div>
                        </div>
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-sm-6"><input type="text" name="thursday_lunch_open" id="thursday_lunch_open" placeholder="open" class="form-control" value="{{ isset($restaurant->thursday_lunch_open) ? $restaurant->thursday_lunch_open : null }}"></div>
                                <div class="col-sm-6"><input type="text" name="thursday_lunch_close" id="thursday_lunch_close"  placeholder="close" class="form-control" value="{{ isset($restaurant->thursday_lunch_close) ? $restaurant->thursday_lunch_close : null }}"></div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-sm-6"><input type="text" name="thursday_dinner_open" id="thursday_dinner_open" placeholder="open" class="form-control" value="{{ isset($restaurant->thursday_dinner_open) ? $restaurant->thursday_dinner_open : null }}"></div>
                                <div class="col-sm-6"><input type="text" name="thursday_dinner_close" id="thursday_dinner_close"  placeholder="close" class="form-control" value="{{ isset($restaurant->thursday_dinner_close) ? $restaurant->thursday_dinner_close : null }}"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>

                <div class="form-group">
                    <div class="col-sm-3"><label for="">Friday</label></div>
                    <div class="col-sm-9">
                        <div class="col-sm-4">
                                <div class="col-sm-6"><input type="text" name="friday_breakfast_open" id="friday_breakfast_open" placeholder="open" class="form-control" value="{{ isset($restaurant->friday_breakfast_open) ? $restaurant->friday_breakfast_open : null }}"></div>
                                <div class="col-sm-6"><input type="text" name="friday_breakfast_close" id="friday_breakfast_close"  placeholder="close" class="form-control" value="{{ isset($restaurant->friday_breakfast_close) ? $restaurant->friday_breakfast_close : null }}"></div>
                        </div>
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-sm-6"><input type="text" name="friday_lunch_open" id="friday_lunch_open" placeholder="open" class="form-control" value="{{ isset($restaurant->friday_lunch_open) ? $restaurant->friday_lunch_open : null }}"></div>
                                <div class="col-sm-6"><input type="text" name="friday_lunch_close" id="friday_lunch_close"  placeholder="close" class="form-control" value="{{ isset($restaurant->friday_lunch_close) ? $restaurant->friday_lunch_close : null }}"></div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-sm-6"><input type="text" name="friday_dinner_open" id="friday_dinner_open" placeholder="open" class="form-control" value="{{ isset($restaurant->friday_dinner_open) ? $restaurant->friday_dinner_open : null }}"></div>
                                <div class="col-sm-6"><input type="text" name="friday_dinner_close" id="friday_dinner_close"  placeholder="close" class="form-control" value="{{ isset($restaurant->friday_dinner_close) ? $restaurant->friday_dinner_close : null }}"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>

                <div class="form-group">
                    <div class="col-sm-3"><label for="">Saturday</label></div>
                    <div class="col-sm-9">
                        <div class="col-sm-4">
                                <div class="col-sm-6"><input type="text" name="saturday_breakfast_open" id="saturday_breakfast_open" placeholder="open" class="form-control" value="{{ isset($restaurant->saturday_breakfast_open) ? $restaurant->saturday_breakfast_open : null }}"></div>
                                <div class="col-sm-6"><input type="text" name="saturday_breakfast_close" id="saturday_breakfast_close"  placeholder="close" class="form-control" value="{{ isset($restaurant->saturday_breakfast_close) ? $restaurant->saturday_breakfast_close : null }}"></div>
                        </div>
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-sm-6"><input type="text" name="saturday_lunch_open" id="saturday_lunch_open" placeholder="open" class="form-control" value="{{ isset($restaurant->saturday_lunch_open) ? $restaurant->saturday_lunch_open : null }}"></div>
                                <div class="col-sm-6"><input type="text" name="saturday_lunch_close" id="saturday_lunch_close"  placeholder="close" class="form-control" value="{{ isset($restaurant->saturday_lunch_close) ? $restaurant->saturday_lunch_close : null }}"></div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-sm-6"><input type="text" name="saturday_dinner_open" id="saturday_dinner_open" placeholder="open" class="form-control" value="{{ isset($restaurant->saturday_dinner_open) ? $restaurant->saturday_dinner_open : null }}"></div>
                                <div class="col-sm-6"><input type="text" name="saturday_dinner_close" id="saturday_dinner_close"  placeholder="close" class="form-control" value="{{ isset($restaurant->saturday_dinner_close) ? $restaurant->saturday_dinner_close : null }}"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>


                <div class="form-group">
                    <div class="col-sm-3"><label for="">Sunday</label></div>
                    <div class="col-sm-9">
                        <div class="col-sm-4">
                                <div class="col-sm-6"><input type="text" name="sunday_breakfast_open" id="sunday_breakfast_open" placeholder="open" class="form-control" value="{{ isset($restaurant->sunday_breakfast_open) ? $restaurant->sunday_breakfast_open : null }}"></div>
                                <div class="col-sm-6"><input type="text" name="sunday_breakfast_close" id="sunday_breakfast_close"  placeholder="close" class="form-control" value="{{ isset($restaurant->sunday_breakfast_close) ? $restaurant->sunday_breakfast_close : null }}"></div>
                        </div>
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-sm-6"><input type="text" name="sunday_lunch_open" id="sunday_lunch_open" placeholder="open" class="form-control" value="{{ isset($restaurant->sunday_lunch_open) ? $restaurant->sunday_lunch_open : null }}"></div>
                                <div class="col-sm-6"><input type="text" name="sunday_lunch_close" id="sunday_lunch_close"  placeholder="close" class="form-control" value="{{ isset($restaurant->sunday_lunch_close) ? $restaurant->sunday_lunch_close : null }}"></div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-sm-6"><input type="text" name="sunday_dinner_open" id="sunday_dinner_open" placeholder="open" class="form-control" value="{{ isset($restaurant->sunday_dinner_open) ? $restaurant->sunday_dinner_open : null }}"></div>
                                <div class="col-sm-6"><input type="text" name="sunday_dinner_close" id="sunday_dinner_close"  placeholder="close" class="form-control" value="{{ isset($restaurant->sunday_dinner_close) ? $restaurant->sunday_dinner_close : null }}"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <!-- <div class="form-group">
                    <label for="" class="col-sm-3 control-label">Monday</label>
                    <div class="col-sm-9">
                        <input type="text" name="open_monday" value="{{ isset($restaurant->open_monday) ? $restaurant->open_monday : null }}" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-3 control-label">Tuesday</label>
                    <div class="col-sm-9">
                        <input type="text" name="open_tuesday" value="{{ isset($restaurant->open_tuesday) ? $restaurant->open_tuesday : null }}" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-3 control-label">Wednesday</label>
                    <div class="col-sm-9">
                        <input type="text" name="open_wednesday" value="{{ isset($restaurant->open_wednesday) ? $restaurant->open_wednesday : null }}" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-3 control-label">Thursday</label>
                    <div class="col-sm-9">
                        <input type="text" name="open_thursday" value="{{ isset($restaurant->open_thursday) ? $restaurant->open_thursday : null }}" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-3 control-label">Friday</label>
                    <div class="col-sm-9">
                        <input type="text" name="open_friday" value="{{ isset($restaurant->open_friday) ? $restaurant->open_friday : null }}" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-3 control-label">Saturday</label>
                    <div class="col-sm-9">
                        <input type="text" name="open_saturday" value="{{ isset($restaurant->open_saturday) ? $restaurant->open_saturday : null }}" class="form-control">
                    </div>
                </div>  
                <div class="form-group">
                    <label for="" class="col-sm-3 control-label">Sunday</label>
                    <div class="col-sm-9">
                        <input type="text" name="open_sunday" value="{{ isset($restaurant->open_sunday) ? $restaurant->open_sunday : null }}" class="form-control">
                    </div>
                </div>  -->
				<div class="form-group">
                    <label for="avatar" class="col-sm-3 control-label">Status</label>
                    <div class="col-sm-9">
							<select id="basic" name="status" class="selectpicker show-tick form-control">
                               @if(isset($restaurant->status))  
                                    <option value="1" @if($restaurant->status==1) selected @endif >Active</option>
                                    <option value="0" @if($restaurant->status==0) selected @endif >Inactive</option>
                                     
                                @else

                                    
                                    <option value="0">Inactive</option> 
									<option value="1">Active</option>
                                
                                @endif                          
                            
                        </select>
                    </div>
                </div>	
                <hr>
                <div class="form-group">
                    <div class="col-md-offset-3 col-sm-9 ">
                    	<button type="submit" class="btn btn-primary">{{ isset($restaurant->id) ? 'Edit Restaurant ' : 'Add Restaurant' }}</button>
                         
                    </div>
                </div>
                
                {!! Form::close() !!} 
            </div>
        </div>
   
    
</div>

@endsection