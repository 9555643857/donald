@extends('layouts.full-width')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-6 text-center col-md-8 ml-auto mr-auto">
            <div class="panel panel-default">
                <h2 class="title">Reset Password</h2>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
                        {{ csrf_field() }}

						<div class="input-group input-lg {{ $errors->has('email') ? ' has-error' : '' }}">
                            <span class="input-group-addon">
                                <i class="now-ui-icons ui-1_email-85"></i>
                            </span>
                            <input id="email" type="email" class="form-control" placeholder="Email..." name="email" value="{{ old('email') }}" required autofocus>
							
							
                        </div>
						<div class="label-error"> @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                             @endif</div>
						<div class="send-button">
                            <button class="btn btn-primary btn-round btn-block btn-lg" type="submit">Send Password Reset Link</button>							
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
