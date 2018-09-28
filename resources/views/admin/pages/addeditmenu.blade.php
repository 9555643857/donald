@extends("admin.admin_app")

@section("content")

<div id="main">
	<div class="page-header">
		<h2> {{ isset($menu->menu_name) ? 'Edit: '. $menu->menu_name : 'Add Menu' }}</h2>
		
		<a href="{{ URL::to('admin/restaurants/view/'.$restaurant_id.'/menu') }}" class="btn btn-default-light btn-xs"><i class="md md-backspace"></i> Back</a>
	  
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
                {!! Form::open(array('url' => array('admin/restaurants/view/'.$restaurant_id.'/menu/addmenu'),'class'=>'form-horizontal padding-15','name'=>'menu_form','id'=>'menu_form','role'=>'form','enctype' => 'multipart/form-data')) !!} 
                
                <input type="hidden" name="restaurant_id" value="{{$restaurant_id}}">
                <input type="hidden" name="id" value="{{ isset($menu->id) ? $menu->id : null }}">
                
                <div class="form-group">
                    <label for="" class="col-sm-3 control-label">Menu category</label>
                    <div class="col-sm-4">
                        <select id="basic" name="menu_cat" class="selectpicker show-tick form-control">
                            <option value="">Select Type</option>
                            
                            @foreach($categories as $i => $category)    
                                @if(isset($menu->menu_cat) && $menu->menu_cat==$category->id)  
                                    <option value="{{$category->id}}" selected >{{$category->category_name}}</option>
                                     
                                @else
                                <option value="{{$category->id}}">{{$category->category_name}}</option> 
                                @endif                          
                            @endforeach
                        </select>
                    </div>
                </div>
				@php
					$menuType=[0=>'veg',1=>'non-veg'];
				@endphp
				<div class="form-group">
                    <label for="" class="col-sm-3 control-label">Menu Type</label>
                    <div class="col-sm-4">
                        <select id="basic" name="menu_type" class="selectpicker show-tick form-control">
                            <option value="">Select Type</option>
                            
                            @foreach($menuType as $i => $category)    
                                @if(isset($menu->menu_type) && $menu->menu_type==$i)  
                                    <option value="{{$i}}" selected >{{$category}}</option>
                                     
                                @else
                                <option value="{{$i}}">{{$category}}</option> 
                                @endif                          
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="" class="col-sm-3 control-label">Menu Name</label>
                      <div class="col-sm-9">
                        <input type="text" name="menu_name" value="{{ isset($menu->menu_name) ? $menu->menu_name : null }}" class="form-control">
                    </div>
                </div>
				
				<!-- <div class="form-group">
                    <label for="" class="col-sm-3 control-label">Opening Time</label>
                      <div class="col-sm-9">
                        <input type="text" name="opening_time" value="{{ isset($menu->opening_time) ? $menu->opening_time : null }}" class="form-control">
                    </div>
                </div>
				<div class="form-group">
                    <label for="" class="col-sm-3 control-label">Closing Time</label>
                      <div class="col-sm-9">
                        <input type="text" name="closing_time" value="{{ isset($menu->closing_time) ? $menu->closing_time : null }}" class="form-control">
                    </div>
                </div> -->
				
				
				<div class="form-group">
                    <label for="" class="col-sm-3 control-label">Delivery charge</label>
                      <div class="col-sm-9">
                        <input type="text" name="delivery_charge" value="{{ isset($menu->delivery_charge) ? $menu->delivery_charge : null }}" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-3 control-label">Sort Description</label>
                      <div class="col-sm-9">
                        <input type="text" name="description" value="{{ isset($menu->description) ? $menu->description : null }}" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-3 control-label">Price</label>
                      <div class="col-sm-9">
                         
                        <input id="touch-spin-2" data-toggle="touch-spin" data-min="-1000000" data-max="1000000" data-prefix="$" data-step="1" type="text" value="{{ isset($menu->price) ? $menu->price : null }}" name="price" class="form-control"/>
                    </div>
                </div>
				<div class="form-group">
                    <label for="" class="col-sm-3 control-label">Is Trail Available</label>
                    <div class="col-sm-9">
					@php
						$is_trail=[0=>'No',1=>'Yes'];
					@endphp
                        <select id="basic" name="is_trail"  class="selectpicker show-tick form-control">
                            <option value="">Please Select </option>
                            
                            @foreach($is_trail as $i => $trial)    
                                @if(isset($menu->is_trail) && $menu->is_trail==$i)  
                                    <option value="{{$i}}" selected >{{$trial}}</option>
                                     
                                @else
                                <option value="{{$i}}">{{$trial}}</option> 
                                @endif                          
                            @endforeach
                        </select>
                    </div>
                </div>
				 <div class="form-group">
                    <label for="" class="col-sm-3 control-label">Trail Price</label>
                      <div class="col-sm-9">
                         
                        <input id="touch-spin-2" data-toggle="touch-spin" data-min="-1000000" data-max="1000000" data-prefix="$" data-step="1" type="text" value="{{ isset($menu->trail_price) ? $menu->trail_price : null }}" name="trail_price" class="form-control"/>
                    </div>
                </div>
				<!-- <div class="form-group">
                    <label for="" class="col-sm-3 control-label">Weekly Price</label>
                      <div class="col-sm-9">
                         
                        <input id="touch-spin-2" data-toggle="touch-spin" data-min="-1000000" data-max="1000000" data-prefix="$" data-step="1" type="text" value="{{ isset($menu->weekly) ? $menu->weekly : null }}" name="weekly" class="form-control"/>
                    </div>
                </div>
				 <div class="form-group">
                    <label for="" class="col-sm-3 control-label">Monthly Price</label>
                      <div class="col-sm-9">
                         
                        <input id="touch-spin-2" data-toggle="touch-spin" data-min="-1000000" data-max="1000000" data-prefix="$" data-step="1" type="text" value="{{ isset($menu->monthly) ? $menu->monthly : null }}" name="monthly" class="form-control"/>
                    </div>
                </div>
				 <div class="form-group">
                    <label for="" class="col-sm-3 control-label">Quartely Price</label>
                      <div class="col-sm-9">
                         
                        <input id="touch-spin-2" data-toggle="touch-spin" data-min="-1000000" data-max="1000000" data-prefix="$" data-step="1" type="text" value="{{ isset($menu->quarterly) ? $menu->quarterly : null }}" name="quarterly" class="form-control"/>
                    </div>
                </div> -->
				<div class="form-group">
                    <label for="" class="col-sm-3 control-label">Order min count</label>
                      <div class="col-sm-9">
                         
                        <input id="touch-spin-2" data-toggle="touch-spin" data-min="-1000000" data-max="1000000" data-prefix="" data-step="1" type="text" value="{{ isset($menu->order_min_count) ? $menu->order_min_count : null }}" name="order_min_count" class="form-control"/>
                    </div>
                </div>
				<div class="form-group">
                    <label for="" class="col-sm-3 control-label">Order max count</label>
                      <div class="col-sm-9">
                         
                        <input id="touch-spin-2" data-toggle="touch-spin" data-min="-1000000" data-max="1000000" data-prefix="" data-step="1" type="text" value="{{ isset($menu->order_max_count) ? $menu->order_max_count : null }}" name="order_max_count" class="form-control"/>
                    </div>
                </div>
				<div class="form-group">
                    <label for="" class="col-sm-3 control-label">Available in</label>
                    <div class="col-sm-9">
                        <select id="basic" name="availablity[]"  class="selectpicker show-tick form-control">
                            <option value="">Select Availablity</option>
                            @php
							 $availablity=['Breakfast','Lunch','Dinner']
							@endphp
                            @foreach($availablity as $i => $type)    
                                @if(isset($menu->availablity) && in_array($type,explode(",",$menu->availablity)))  
                                    <option value="{{$type}}" selected >{{$type}}</option>
                                     
                                @else
                                <option value="{{$type}}">{{$type}}</option> 
                                @endif                          
                            @endforeach
                        </select>
                    </div>
                </div>
				
				<div class="form-group">
                    <label for="" class="col-sm-3 control-label">Available on</label>
                    <div class="col-sm-9">
                        <select id="basic" name="days_avail[]"  class="selectpicker show-tick form-control">
                            <option value="">Select Availablity</option>
                            @php
							 $days=['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday']
							@endphp
                            @foreach($days as $i => $day)    
                                @if(isset($menu->days_avail) && in_array($day,explode(",",$menu->days_avail)))  
                                    <option value="{{$day}}" selected >{{$day}}</option>
                                     
                                @else
                                <option value="{{$day}}">{{$day}}</option> 
                                @endif                          
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="avatar" class="col-sm-3 control-label">Menu Image</label>
                    <div class="col-sm-9">
                        <div class="media">
                            <div class="media-left">
                                @if(isset($menu->menu_image))
                                 
                                    <img src="{{ URL::asset('upload/menu/'.$menu->menu_image.'-s.jpg') }}" width="100" alt="person">
                                @endif
                                                                
                            </div>
                            <div class="media-body media-middle">
                                <input type="file" name="menu_image" class="filestyle"> 
                            </div>
                        </div>
    
                    </div>
                </div> 
				<div class="form-group">
                    <label for="avatar" class="col-sm-3 control-label">Status</label>
                    <div class="col-sm-9">
							<select id="basic" name="status" class="selectpicker show-tick form-control">
                               @if(isset($menu->status))  
                                    <option value="1" @if($menu->status==1) selected @endif >Active</option>
                                    <option value="0" @if($menu->status==0) selected @endif >Inactive</option>
                                     
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
                    	<button type="submit" class="btn btn-primary">{{ isset($menu->id) ? 'Edit Menu ' : 'Add Menu' }}</button>
                         
                    </div>
                </div>
                
                {!! Form::close() !!} 
            </div>
        </div>
   
    
</div>

@endsection