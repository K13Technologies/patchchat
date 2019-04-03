@extends('app')

@section('title') 
	Login 
@stop

@section('content')
<div class="section section-padded">
    <div class="container-fluid">
        <div class="content">
            
            <div class="row">
                <div class="col-sm-8">
              		<form class="form-vertical" role="form" method="POST" action="{{ url('/auth/login') }}">
            			<input type="hidden" name="_token" value="{{ csrf_token() }}">
            
            			<div class="form-group">
            				<label class="control-label">E-Mail Address</label>
            				<div class="">
            					<input type="email" class="form-control" name="email" value="{{ old('email') }}">
            				</div>
            			</div>
            
            			<div class="form-group">
            				<label class="control-label">Password</label>
            				<div class="">
            					<input type="password" class="form-control" name="password">
            				</div>
            			</div>
            
            			<div class="form-group">
            				<div class="">
            					<div class="checkbox">
            						<label>
            							<input type="checkbox" name="remember"> Remember Me
            						</label>
            					</div>
            				</div>
            			</div>
            			
            			
                        <div class="form-group">
                            {!! Recaptcha::render() !!}
                        </div>
            
            			<div class="form-group">
            				<div class="">
            					<button type="submit" class="btn btn-lg btn-primary">Login</button>
            
            					<a class="btn btn-link" href="{{ url('/password/email') }}">Forgot Your Password?</a>
            				</div>
            			</div>
            		</form>
            	</div>
            </div>
        </div>
    </div>
</div>
@endsection
