@extends('app')

@section('title2')
Dashboard
@endsection

@section('content')
<div class="jumbotron" id="home-jumbotron">
    <div class="container-fluid">
    	<h1>FIND YOUR CAMP OR FACILITY</h1>
    				
        <form id="frmSearch" method="GET" action="{{ url('/search') }}" class="form form-horizontal">
        
            <div class="form-group">
                <div class="col-sm-12">
                {{ number_format($total) }} CAMPS, FACILITIES MAPPED WORLDWIDE AND GROWING DAILY.
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12">
                    <label class="sr-only" for="keywords">Keywords</label>
                    <input type="text" class="form-control" id="keywords" placeholder="Camp or facility name" name="keywords">
                </div>
            </div>
            
            <div class="form-group">
                <div class="col-sm-9">
                <label class="sr-only" for="location">Location</label>
                    <input type="text" name="location" class="form-control" id="location" placeholder="Nearby city, lat/long">
                </div>
                <div class="col-sm-3">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>      
            </div>
          </div>
        </form>
    </div>        
</div>

<div class="callouts container-fluid">
    <div class="callouts-row">
		<div class="callouts-cell">    		
            <div class="callout-icon"><i class="fa fa-users"></i></div>
            <h3>RESOURCE INDUSTRY FOCUSED</h3>                           
        </div>
        <div class="callouts-cell">
            <div class="callout-icon"><i class="fa fa-comments-o"></i></div>
            <h3>WORK CAMP COMMUNITIES</h3>
        </div>
        <div class="callouts-cell">
            <div class="callout-icon"><i class="fa fa-globe"></i></div>
            <h3>COMMUNITY EDITED MAPPING</h3>
		</div>
	</div>
    <div class="callouts-row">
		<div class="callouts-cell">
    		<div class="callout">
                <p>For personnel working in the
<a href="{{ route('industry',['industry'=>'mining']) }}">mining</a>, 
<a href="{{ route('industry',['industry'=>'energy']) }}">energy</a>, 
<a href="{{ route('industry',['industry'=>'solar']) }}">solar</a>, 
<a href="{{ route('industry',['industry'=>'wind']) }}">wind farm</a>,
<a href="{{ route('industry',['industry'=>'hydro']) }}">hydro</a>, and <a href="{{ route('industry',['industry'=>'forestry']) }}">forestry</a> industries.</p>
            </div>
        </div>
        <div class="callouts-cell">
        	<div class="callout">
                <p>PatchChat hosts the world’s largest <a href="{{ route('community.camp') }}">work camp</a> community.</p>
            </div>
        </div>
        <div class="callouts-cell">
            <div class="callout">
                <p>An active community of PatchChat
map editors work constantly to
improve and update PatchChat
<a href="{{ route('map') }}">maps</a>.</p>
            </div>
		</div>
	</div>
	<div class="callouts-row">
		<div class="callouts-cell">
    		<div class="callout-button">
    		    <div class="btn-group">
                    <button type="button" class="btn btn-lg btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Select Industry 
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">                    
                        <li><a href="{{ route('industry',['industry'=>'mining']) }}">Mining</a></li> 
                        <li><a href="{{ route('industry',['industry'=>'energy']) }}">Energy</a></li> 
                        <li><a href="{{ route('industry',['industry'=>'solar']) }}">Solar</a></li> 
                        <li><a href="{{ route('industry',['industry'=>'wind']) }}">Wind farm</a></li> 
                        <li><a href="{{ route('industry',['industry'=>'hydro']) }}">Hydro</a>
                        <li><a href="{{ route('industry',['industry'=>'forestry']) }}">Forestry</a></li> 
                    </ul>
                </div>
                
            </div>
        </div>
        <div class="callouts-cell">
            <div class="callout-button">
                <a href="{{ route('community') }}" class="btn btn-lg btn-primary">Join Community</a>
            </div>
		</div>
		<div class="callouts-cell">
            <div class="callout-button">
                <a href="{{ route('map') }}" class="btn btn-lg btn-primary">View Map</a>
            </div>		
        </div>        
	</div>
	
</div>
@endsection
