@extends('layouts.full-width')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-6 text-center col-md-8 ml-auto mr-auto">
            <div class="panel panel-default">
                <h2 class="title">Login</h2>
                    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

						 @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                         @endif
						 @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                          @endif
						<div class="input-group input-lg {{ $errors->has('email') ? ' has-error' : '' }}">
                            <span class="input-group-addon">
                                <i class="now-ui-icons ui-1_email-85"></i>
                            </span>
                            <input id="email" type="email" class="form-control" placeholder="Email..." name="email" value="{{ old('email') }}" required autofocus>
							
                        </div>
						
						<div class="input-group input-lg {{ $errors->has('password') ? ' has-error' : '' }}">
                            <span class="input-group-addon">
                                <i class="fa fa-key"></i>
                            </span>
                            <input id="password" type="password" class="form-control" placeholder="your password..." name="password" required />
							 
                        </div>
						 


                        <div class="input-group">
                            
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                    </label>
                                </div>
                          
                        </div>
						<div class="send-button">
                            <button class="btn btn-primary btn-round btn-block btn-lg" type="submit">Login</button>							
                        </div>
						<div class="pull-left">
						<a class="btn btn-link" href="{{ route('register') }}">
                                    Create an Account
                         </a>
						</div>
						<div class="pull-right">
						<a class="btn btn-link" href="{{ route('password.request') }}">
                                    Forgot Your Password?
                         </a>
						 </div>
                    
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
