@extends('app')


@section('breadcrumb')
    <li><a href="{{ route('industry',['industry'=>$facility->industry->slug]) }}">{{ $facility->industry->name }}</a></li>
    <li>{{ $facility->name }}</li>    
@endsection

@section('scripts')
<script src='https://api.mapbox.com/mapbox.js/plugins/mapbox-directions.js/v0.3.0/mapbox.directions.js'></script>
@endsection

@section('headerscripts')
<link rel='stylesheet' href='https://api.mapbox.com/mapbox.js/plugins/mapbox-directions.js/v0.3.0/mapbox.directions.css' type='text/css' />
@endsection

@section('pageheader')
        <div class="pull-right facility-icon facility-icon-{{ $facility->category->icon }}" title="{{ $facility->category->name }}"></div>
        <h1>{{ $facility->name }} - {{ $facility->category->name }}</h1>
                <div class="facility-location">                    
                    <i class="fa fa-map-marker"></i>
                    @if ($facility->address)
                        {{ $facility->address }}, 
                    @endif
                    @if($facility->cityObj)
                    {{ $facility->cityObj->name }}, 
                    @endif 
                    {{ $facility->state->name }}, {{ $facility->country->name }}
                    
                    @if ($facility->phone_emergency or $facility->phone_reservations or $facility->phone_main or $facility->phone_cell )
                        <i class="separator">|</i> <i class="fa fa-phone"></i>
                        @if ($facility->phone_main) 
                        <a rel="nofollow"  href="tel:{{ $facility->phone_main }}">{{ $facility->phone_main }}</a>
                        @elseif ($facility->phone_emergency)
                        <a rel="nofollow"  href="tel:{{ $facility->phone_emergency }}">{{ $facility->phone_emergency }}</a>                        
                        @elseif ($facility->phone_reservations)
                        <a rel="nofollow"  href="tel:{{ $facility->phone_reservations }}">{{ $facility->phone_reservations }}</a>
                        @elseif ($facility->phone_cell)
                        <a rel="nofollow"  href="tel:{{ $facility->phone_cell }}">{{ $facility->phone_cell }}</a>                     
                        @endif
                    @endif     
                    
                    @if ($facility->website)
                        <i class="separator">|</i> <i class="fa fa-desktop"></i>
                        <a rel="nofollow" href="{{ $facility->website }}" target=_blank>website</a>
                    @endif      
                    
                    @if ($facility->email)
                        <i class="separator">|</i> <i class="fa fa-envelope"></i>
                        <a rel="nofollow"  href="mailto:{{ $facility->email }}">{{ $facility->email }}</a>
                    @endif            
                        
                </div>
@endsection


@section('content')
<div class="container">
    <div class="tab-pane" id="featured-photo">
        @if($facility->featuredPhoto)
        <div class="facility-featured-photo-wrap">
            <img class="facility-featured-photo" src="/media/{{ $facility->featuredPhoto->path }}" title="{{ $facility->featuredPhoto->caption }}" alt="{{ $facility->name }} featured photo"/>
            @if(sizeOf($facility->photo)>1)
            <a class="management-photos-link inner-link" href="#">
                <i class="fa fa-camera"></i>
                <span>More Protos</span>
            </a>          
            @endif
        </div>    
        @endif
        <!-- Nav tabs -->
        <div id="inner-nav">
          <ul class="nav nav-pills">
            <li role="presentation" class="active"><a class="inner-link" href="#overview">Overview</a></li>    
            <li role="presentation"><a class="inner-link" href="#contacts">Contacts</a></li>
            <li role="presentation"><a class="inner-link" href="#directions">Journey Management</a></li>
            {{--<li role="presentation"><a class="inner-link" href="#reviews">Reviews</a></li>
            <li role="presentation"><a class="inner-link" href="#faq">FAQ</a></li>
            <li role="presentation"><a class="inner-link" href="#forums">Forums</a></li>--}}        
          </ul>
        </div>
    </div>

    <div class="tab-pane active" id="overview">
        <div class="row">
            <div class="col-sm-12">
                <h3>Overview</h3>             
                <?php echo nl2br(htmlspecialchars($facility->description)); ?>    
                @if(!$facility->description)
                <div class="alert alert-info">
                
                <h4>Do you have any info about {{ $facility->name }}?</h4>
                <p>As you can see, we don't have a description :( If you have some information about {{ $facility->name }}, please send us a message.</p>
                <p>
                <a class="btn btn-primary" href="/contact">Yes, I have some info</a></p>
                </div>
                @endif   
            </div>    
            
        </div>        
    </div>
    @if(sizeOf($facility->photo)>1)
    <div class="tab-pane" id="photos">
        <h3>Photos</h3>             
        <div class="gallery">
            <div class="row">
                @foreach($facility->photo as $photo)
                <div class="col-xs-6 col-md-3">
                    <a href="/media/{{ $photo->path }}" class="thumbnail" title="{{ $photo->caption }}">
                        <img src="/media/{{ $photo->path }}" title="{{ $photo->caption }}">
                    </a>
                </div>
                @endforeach                
            </div>   
            @if(sizeOf($facility->photo)<=0)
            <div class="alert alert-info">
            
            <h4>Do you have photos of {{ $facility->name }}?</h4>
            <p>We don't yet have any photos of this facility, please share you photos with community if you worked there.</p>
            <p>
            <a class="btn btn-primary" href="/contact">Sure, I can help</a></p>
            </div>
            @endif
        </div>
    </div>            
    @endif
    
    <div class="tab-pane" id="contacts">
        <h3>Contacts</h3> 
        <dl class="dl-horizontal">
            @if ($facility->companyObj)
            <dt>Owner</dt><dd>{{ $facility->companyObj->name }}</dd>
            @endif            
            @if ($facility->website)
            <dt>Website</dt><dd><a  rel="nofollow" href="{{ $facility->website }}" target=_blank>{{ $facility->website }}</a></dd>
            @endif         
            @if ($facility->email)
            <dt>Email</dt><dd><a rel="nofollow"  href="mailto:{{ $facility->email }}">{{ $facility->email }}</a></dd>
            @endif            
            @if ($facility->phone_reservations)
            <dt>Reservations</dt><dd><a rel="nofollow"  href="tel:{{ $facility->phone_reservations }}">{{ $facility->phone_reservations }}</a></dd>
            @endif            
            @if ($facility->phone_main)
            <dt>Main Phone</dt><dd><a rel="nofollow"  href="tel:{{ $facility->phone_main }}">{{ $facility->phone_main }}</a></dd>
            @endif            
            @if ($facility->phone_cell)
            <dt>Cell Phone</dt><dd><a rel="nofollow"  href="tel:{{ $facility->phone_cell }}">{{ $facility->phone_cell }}</a></dd>
            @endif            
            @if ($facility->fax)
            <dt>Fax</dt><dd><a rel="nofollow"  href="fax:{{ $facility->fax }}">{{ $facility->fax }}</a></dd>
            @endif            
            @if ($facility->beds)
            <dt>Beds</dt><dd>{{ $facility->beds }}</dd>
            @endif                        
        </dl>    
        
    </div>
    
    <div class="tab-pane" id="directions"  data-ng-controller="directionsController">
        <h3>Journey Management</h3>    
            <dl class="dl-horizontal">
                @if($facility->address)
                <dt>Address</dt>
                <dd>
                    {{ $facility->address }}                    
                </dd>
                @endif
                <dt>Location</dt>
                <dd>
                    {{ $facility->state->name }}, {{ $facility->country->name }}            
                </dd>                
                @if ($facility->latitude)    
                <dt>Coordinates</dt>
                <dd>
                    {{ $facility->latitude }}, {{ $facility->longitude }}                    
                </dd>                
                @endif
            </dl>
            
        @if ($facility->latitude)    
        
            <div id='facility-map' class='map' data-lat="{{$facility->latitude}}" data-lng="{{$facility->longitude}}" data-title="{{ $facility->name }}" data-description="{{ $facility->address }}" data-icon="{{ $facility->category->icon }}"></div>
            <div id='inputs'></div>
            
            <div class="row">
                <div class="col-sm-6" >
                    <h4>Directions</h4>
                    
                    @if($facility->directions)
                    {!! $facility->directions !!}
                    <hr>
                    @endif
                    
                    <form id="frmDirections" method="POST" data-ng-submit="getDirections()" class="form form-inline">
                        <div class="form-group">
                            <label class="sr-only" for="address">Your Address</label>
                            <input type="text" class="form-control" placeholder="Your Address" name="address" data-ng-model="origin">
                        </div>
                        <button type="submit" class="btn btn-primary">Get Directions</button>            
                    </form>
                    
                    <div id='errors'></div>
                    <div id='directions'>
                      <div id='routes'></div>
                      <div id='instructions'></div>
                    </div>
                </div>
                <div class="col-sm-6" data-ng-controller="weatherController">
                    <div class="ng-hide" data-ng-show="place">
                        <h4>Weather Forecast For <% place.city.name %>, <% place.city.country %></h4>
                        
                        <ul class="list-group">
                            <li data-ng-repeat="item in place.list" class="list-group-item">
                               <h5><% (item.dt * 1000) | date:'longDate' %></h5>
                               
                               <img class="pull-left" data-ng-src="http://openweathermap.org/img/w/<% item.weather[0].icon %>.png" />
                               @if(App::getLocale() == "en_us")
                               High: <% item.temp.day %>° F / Low: <% item.temp.night %>° F<br>
                               Wind: <% item.speed %> ft/s
                               @else
                               High: <% item.temp.day %>° C / Low: <% item.temp.night %>° C<br>
                               Wind: <% item.speed %> m/s
                               @endif
                            </li>                      
                        </ul>
                        
                    </div>
                </div>
            </div>
        @else 
        <div class="alert alert-danger">
            We don't have a location of this facility. Can you help is with this information?            
        </div>
        @endif
        
    </div>
    {{--
    <div class="tab-pane" id="reviews">
        <h3>Reviews from PatchChat Community</h3>
        <hr>
        <div class="your-rating">
            <span class="your-star-rating">
                <h4>Your overall rating of {{ $facility->name }}</h4>
                
                <a href="{{ route('facility.review.create', ['facility'=>$facility->id, 'rating'=>1]) }}"><i class="fa fa-star-o"></i></a>
                <a href="{{ route('facility.review.create', ['facility'=>$facility->id, 'rating'=>2]) }}"><i class="fa fa-star-o"></i></a>
                <a href="{{ route('facility.review.create', ['facility'=>$facility->id, 'rating'=>3]) }}"><i class="fa fa-star-o"></i></a>
                <a href="{{ route('facility.review.create', ['facility'=>$facility->id, 'rating'=>4]) }}"><i class="fa fa-star-o"></i></a>
                <a href="{{ route('facility.review.create', ['facility'=>$facility->id, 'rating'=>5]) }}"><i class="fa fa-star-o"></i></a>
                <span class="label label-info"> <i class="fa fa-arrow-left"></i> Click to rate</span>
            </span>
        </div>            
    
        <hr>
        community reviews coming here
        
    </div>
    
    <div class="tab-pane" id="faq">
        <h3>Questions and Answers</h3>
        QA section (Quora like)
    </div>
    <div class="tab-pane" id="chat">
        <h3>Forums</h3>        
    </div>--}}
  
</div> 
@endsection
