@extends('app')

@section('pagetitle')
{{  $industry->name }}
@endsection

@section('content')
<div class="jumbotron" id="{{ $industry->slug }}-jumbotron">
    <div class="container-fluid">
    	<h1>FIND YOUR {{  $industry->name }} FACILITY</h1>
    				
        <form id="frmSearch" method="GET" action="{{ route('search.industry',['industry'=>$industry->slug]) }}" class="form form-horizontal">
        
            <div class="form-group">
                <div class="col-sm-12">
                    {{ number_format($total) }} CAMPS, FACILITIES MAPPED WORLDWIDE AND GROWING DAILY.
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12">
                    <label class="sr-only" for="keywords">Keywords</label>
                    <input type="text" class="form-control" id="keywords" placeholder="Facility name" name="keywords">
                </div>
            </div>
            
            <div class="form-group">
                <div class="col-sm-9">
                <label class="sr-only" for="location">Location</label>
                    <input type="text" class="form-control" name="location" id="location" placeholder="Nearby city, lat/long">
                </div>
                <div class="col-sm-3">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>      
            </div> 
            
            <div class="form-group">
                <div class="col-sm-12">
                or <a href="{{ route('industry.search', ['industry' => $industry->slug]) }}">browse {{ number_format($count) }} @yield('facilities_names') in {{ trans("messages.locale") }}</a>
                </div>
            </div>
                       
          </div>
        </form>
    </div>        
</div>

<div class="section section-white section-padded bottom-border text-center section-large">
    <div class="container-fluid">
        <h1>{{  $industry->name }} Industry</h1>
        
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
            <p>Are you employed in the {{  $industry->name }} Industry? 
        Become a PatchChat map editor and help us map all the @yield('facilities_names') worldwide. 
        Mapping not your thing? Then join our PatchChat - {{  $industry->name }} Industry community
        forum and discuss the latest technology and business trends in the {{  $industry->name }} industry.</p>
            </div>
        </div>
        
        <p>
            <a href="{{ route('industry.register', ['industry' => $industry->slug]) }}" class="btn btn-lg btn-primary">Join Us</a>
        </p>
    </div>
</div>

<div class="callouts container-fluid">
    <div class="callouts-row">
		<div class="callouts-cell">
    		<div class="callout-icon">
                <i class="fa @yield('calout1_icon')"></i>                
            </div>
            <h3>@yield('calout1_title')</h3>
        </div>
        <div class="callouts-cell">
    		<div class="callout-icon">
                <i class="fa fa-globe"></i>
            </div>            
            <h3>COMMUNITY EDITED MAPPING</h3>                
        </div>
        <div class="callouts-cell">
    		<div class="callout-icon">
                <i class="fa fa-newspaper-o"></i>
            </div>            
            <h3>{{  $industry->name }} Industry Wiki</h3>                
        </div>               
	</div>
	
	<div class="callouts-row">
		<div class="callouts-cell">
    		<div class="callout">
                @yield('calout1_text')
            </div>
        </div>
        <div class="callouts-cell">
            <div class="callout">
                <p>Our map editors work constantly to improve and update PatchChat <a href="{{ route('map') }}">maps</a>.</p>                
            </div>
		</div>
		<div class="callouts-cell">
        	<div class="callout">
                <p>Share your knowledge and experience with others. Contribute to the {{ $industry->name }} industry Wiki.</p>
            </div>
        </div>        
	</div>
	
	<div class="callouts-row">
		<div class="callouts-cell">
    		<div class="callout-button">
                <a href="{{ route('community.industry', ['industry' => $industry->slug]) }}" class="btn btn-lg btn-primary">Join Community</a>
            </div>
        </div>
        <div class="callouts-cell">
            <div class="callout-button">
                <a href="{{ route('industry.facility.add', ['industry' => $industry->slug]) }}" class="btn btn-lg btn-primary">Start Mapping</a>
            </div>
		</div>
		<div class="callouts-cell">
            <div class="callout-button">
                <a href="{{ route('wiki.industry', ['industry' => $industry->slug]) }}" class="btn btn-lg btn-primary">Start Contributing</a>
            </div>		
        </div>        
	</div>
</div>
@endsection
