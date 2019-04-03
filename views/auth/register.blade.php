@extends('app')

@section('title') 
	Registration
@stop

@section('content')
<div class="section section-padded">
    <div class="container-fluid">
        <div class="content">
            
            <div class="row">
                <div class="col-sm-8">
                	<form class="form-vertical" role="form" method="POST" action="">
                		<input type="hidden" name="_token" value="{{ csrf_token() }}">
                
                		<div class="form-group">
                			<label class="control-label">Name</label>
                			<div class="">
                				<input type="text" class="form-control" name="name" value="{{ old('name') }}" data-toggle="popover" title="Your Name" data-content="Please use your real name to register. You can pick up different display name or nickname to display to public in your profile.">        				     
                			</div>
                		</div>
                
                		<div class="form-group">
                			<label class="control-label">E-Mail Address</label>
                			<div class="">
                				<input type="email" class="form-control" name="email" value="{{ old('email') }}" data-toggle="popover" title="Email Address" data-content="Email address is used for sending account related information.">
                			</div>
                		</div>
                
                		<div class="form-group">
                			<label class="control-label">Password</label>
                			<div class="">
                				<input type="password" class="form-control" name="password" data-toggle="popover" title="Password" data-content="It's important to keep your information secure, so choose password wisely!">
                			</div>
                		</div>
                    	
                        <div class="form-group">
                            {!! Recaptcha::render() !!}
                        </div>
                        
                		<div class="form-group">
                			<div class="">
                				<button type="submit" class="btn btn-lg btn-primary">
                					Register with PatchChat
                				</button>
                			</div>
                		</div>
                		
                		<p class="help-block">By clicking &ldquo;Register with PatchChat&rdquo; you agree to our <a href="{{ route("terms") }}">terms of service</a> and <a href="{{ route("privacy") }}">privacy policy</a>. We will send you account related emails occasionally.</p>
                	</form>
            	</div>
            </div>
        </div>
    </div>
</div>
@endsection
