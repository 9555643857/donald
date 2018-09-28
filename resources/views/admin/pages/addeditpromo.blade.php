@extends("admin.admin_app")

@section("content")

<div id="main">
	<div class="page-header">
		<h2> {{ isset($promo->code) ? 'Edit: '. $promo->code : 'Add PromoCode' }}</h2>
		
		<a href="{{ URL::to('admin/promocodes') }}" class="btn btn-default-light btn-xs"><i class="md md-backspace"></i> Back</a>
	  
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
			@php $promo_id=isset($promo->code) ? $promo->id : '';
			@endphp
                {!! Form::open(array('url' => array('admin/promocodes/'.$promo_id),'class'=>'form-horizontal padding-15','name'=>'menu_form','id'=>'menu_form','role'=>'form','method'=>'post')) !!} 
                
                
                <input type="hidden" name="id" value="{{ isset($promo->id) ? $promo->id : null }}">
                
                <div class="form-group">
                    <label for="" class="col-sm-3 control-label">No of Promo Code</label>
                      <div class="col-sm-9">
                        <input type="number" name="no_of_coupans" value="{{ isset($promo->code) ? $promo->code : null }}" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-3 control-label">Reward or discount amt.</label>
                      <div class="col-sm-9">
                        <input type="number" name="reward" value="{{ isset($promo->reward) ? $promo->reward : null }}" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-3 control-label">Description</label>
                      <div class="col-sm-9">
                         
                      <textarea placeholder="Description" class="form-control" name="desc" rows="3">
					  @if(isset($promoDesc)){{$promoDesc}}@endif
					  </textarea>
                    </div>
                </div>
				<div class="form-group">
                    <label for="" class="col-sm-3 control-label">Type</label>
                      <div class="col-sm-9">
                         
                      <input type="radio" name="type" value="flat" @if(isset($promotype)){{($promotype=='flat'
) ? "checked" : null }} @endif  />
					  Flat.
					  <input type="radio" name="type" value="percentage" @if(isset($promotype)) {{($promotype=='percentage'
) ? "checked" : null }} @endif  />
					  Percentage.
                    </div>
				 </div>
				<div class="form-group">
                    <label for="" class="col-sm-3 control-label">Is Disposable</label>
                      <div class="col-sm-9">
                         
                      <input type="checkbox" name="is_disposable"  {{isset($promo->is_disposable
) ? "checked" : null }} />
					  *Check if code is allowed to be used once.
                    </div>
                </div>
     			<div class="form-group">
                    <label for="" class="col-sm-3 control-label">Expire at</label>
                      <div class="col-sm-9">
                        <input type="text" name="expires_at" value="{{ isset($promo->expires_at
) ? $promo->expires_at
 : null }}" class="form-control datepicker"> 
                  
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-offset-3 col-sm-9 ">
                    	<button type="submit" class="btn btn-primary">{{ isset($promo->id) ? 'Edit PromoCode ' : 'Add Promocode' }}</button>
                         
                    </div>
                </div>
                
                {!! Form::close() !!} 
            </div>
        </div>
   
    
</div>

@endsection