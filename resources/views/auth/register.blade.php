@extends('layouts.full-width')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-6 text-center col-md-8 ml-auto mr-auto">
            <div class="panel panel-default">
               <h2 class="title">Register</h2>
				<form method="POST" action="{{ route('register') }}">
				  {{ csrf_field() }}
                
                        <div class="input-group input-lg">
                            <span class="input-group-addon">
                                <i class="now-ui-icons users_circle-08"></i>
                            </span>
                            <input required type="text" class="form-control" name="name" placeholder="Your Name...">
							  @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                              @endif
                        </div>
                        <div class="input-group input-lg {{ $errors->has('name') ? ' has-error' : '' }}">
                            <span class="input-group-addon">
                                <i class="now-ui-icons ui-1_email-85"></i>
                            </span>
                            <input required type="text" class="form-control" placeholder="Email..." name="email">
							 @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                        </div>
					   <div class="input-group input-lg {{ $errors->has('email') ? ' has-error' : '' }}">
                            <span class="input-group-addon">
                                <i class="now-ui-icons ui-1_email-85"></i>
                            </span>
                            <input type="password" class="form-control" placeholder="your password..." name="password" required>
							@if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                        </div>
						<div class="input-group input-lg {{ $errors->has('email') ? ' has-error' : '' }}">
                            <span class="input-group-addon">
                                <i class="now-ui-icons ui-1_email-85"></i>
                            </span>
                            <input type="password" class="form-control" placeholder="comfirm password..." name="password_confirmation" required>
							@if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                        </div>
                     
                        <div class="send-button">
                            <button class="btn btn-primary btn-round btn-block btn-lg" type="submit">Join Now</button>
                        </div>
                 <div class="pull-left">
 <a class="btn btn-link" href="{{url('login')}}">
                                					Have a Account? Login Now
                         </a>
						</div>
			</form>
             

		   </div>
        </div>
    </div>
</div>
@endsection
