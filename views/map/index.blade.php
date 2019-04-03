@extends('app')

@section('title2')
Live Global Map
@endsection

@section('content')

<div class="maps" data-ng-controller="MapController" > 
    
    <div id="legend">
        <a href='#' id='geolocate' title="My Location" class='btn btn-default float-left'><span class="fa fa-location-arrow "></span> My Location</a>    
        
        <div class="btn-group">
            <button type="button" class="btn btn-default" data-ng-click="checkAllFilters($event)">
                <span data-ng-show="all">Hide</span>
                <span data-ng-show="!all">Show</span>
                All
            </button>            
        </div>
        
        @foreach($industries as $industry)
        <div class="btn-group">
            <button type="button" class="btn btn-default btn-industry-{{ $industry->slug }} dropdown-toggle" aria-haspopup="true" aria-expanded="false">
                {{ $industry->name }} <span class="caret"></span>
            </button>
            
            <ul class="dropdown-menu">
                @foreach($industry->category as $category)
                <li><label class="checkbox-inline"><input checked type='checkbox' name='filters' data-ng-click="showMarkers($event)" value='{{$category->id}}' > {{$category->name}}</label>
                </li>
                @endforeach            
            </ul>
        </div>
        @endforeach       
    </div>
    
    <div id="map-wrapper" data-ng-init="init()">
        <div id='live-map' class='map' {!! trans("settings.map_center") !!}></div>       
    </div>
    <div class="map-sp">
        <div class="container-fluid">
            <h3 class="text-center">Map Sponsored By</h3>
            @include('ads/_sponsors', ['limit' => '5'])
        </div>
    </div>
</div>
@endsection

@section('headerscripts')
<link href='//api.tiles.mapbox.com/mapbox.js/plugins/leaflet-markercluster/v0.4.0/MarkerCluster.css' rel='stylesheet' />
<link href='//api.tiles.mapbox.com/mapbox.js/plugins/leaflet-markercluster/v0.4.0/MarkerCluster.Default.css' rel='stylesheet' />
@endsection

@section('scripts')
<script type="text/javascript" src="{{ URL::asset('js/map.js') }}"></script>
<script src='//api.tiles.mapbox.com/mapbox.js/plugins/leaflet-markercluster/v0.4.0/leaflet.markercluster.js'></script>
@endsection
