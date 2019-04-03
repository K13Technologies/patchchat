@extends('app')

@section('content')
<div class="container">
    <div class="row">
		<div class="col-md-9">
    		@yield('main')
        </div>
        <div class="col-md-3">
        	<div class="panel panel-default">
            	<div class="panel-body">
            	   Ad placement area
            	</div>
        	</div>
        </div>        
        
	</div>
</div>
@endsection