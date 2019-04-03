app.controller('MapController', function($scope, $http) {
    $scope.application = {};
    $scope.map = null;
    $scope.livemap = null;
    $scope.layers = [];
    $scope.filters = null;
    $scope.overlays = null;
    $scope.categoryFilters = [];
    $scope.all = true;
    
    $scope.categories = [];
    
    $scope.init = function() {
    	$scope.livemap = $("#live-map");
    	
    	if($scope.livemap.size()>0) {
    		$scope.initMap();
    	}
    }
    
    $scope.initMap = function() {
    	var height = parseInt($(window).height()) - parseInt($("#footer").outerHeight())  - parseInt($(".navbar-default").outerHeight());
		if(height < 600) { height = 600; }
		
		$scope.livemap.height(height + 'px');
		
		L.mapbox.accessToken = 'pk.eyJ1Ijoic21hcnRmb3hlcyIsImEiOiJlMGM2MTEwOGYyYjBmZTZiMmQ5YjZjZjE1ZWEzNWY1MCJ9.8EBv0gylarBZLZE9AG1mgQ';
		
		var centerLatLng = [
		    parseFloat($("#live-map").attr("data-center-lat")), 
		    parseFloat($("#live-map").attr("data-center-lng"))
		];
		$scope.map = L.mapbox.map('live-map', 'mapbox.streets').setView(centerLatLng, $("#live-map").attr("data-zoom"));
		
		$scope.overlays = L.layerGroup().addTo($scope.map);

		L.mapbox.featureLayer()
		    .loadURL('/map/search')
		    .on('ready', function(e) {		        
		    	$scope.layers = e.target;
		    	
		    	$scope.categories = $scope.layers._geojson.categories;
		    	$scope.layers.eachLayer(function(layer) {
		    		layer.setIcon(L.divIcon(layer.feature.properties.icon));
		    		layer.bindPopup("<h4><a href=\""
			    			+ layer.feature.properties.slug + "\">"
			    			+ layer.feature.properties.name 
			    			+ "</a><br><small>"
			    			+ layer.feature.properties.category
			    			+ "</small></h4>"
			    			+ layer.feature.properties.company );
		    	});
		    	$scope.showMarkers();
		    });
		
		$scope.filters = jQuery('#legend').find("input[name=filters]");
		
		var geolocate = document.getElementById('geolocate');
		var myLayer = L.mapbox.featureLayer().addTo($scope.map);
		// This uses the HTML5 geolocation API, which is available on
		// most mobile browsers and modern browsers, but not in Internet Explorer
		//
		// See this chart of compatibility for details:
		// http://caniuse.com/#feat=geolocation
		if (!navigator.geolocation) {
		    geolocate.innerHTML = 'Geolocation is not available';
		} else {
		    geolocate.onclick = function (e) {
		        e.preventDefault();
		        e.stopPropagation();
		        $scope.map.locate();
		    };
		}


		
		// Once we've got a position, zoom and center the map
		// on it, and add a single marker.
		$scope.map.on('locationfound', function(e) {
		    //map.fitBounds(e.bounds);
			var myLocation = e.latlng;
			$scope.map.setView(myLocation, 7);
	
		    myLayer.setGeoJSON({
		        type: 'Feature',
		        geometry: {
		            type: 'Point',
		            coordinates: [e.latlng.lng, e.latlng.lat]
		        },
		        properties: {
		            'title': 'Your Location',
		            'marker-color': '#1729b0',
		            'marker-symbol': 'star'
		        }
		    });
	
		    // And hide the geolocation button
		    //geolocate.parentNode.removeChild(geolocate);
		});
	
		// If the user chooses not to allow their location
		// to be shared, display an error message.
		$scope.map.on('locationerror', function() {
		    geolocate.innerHTML = 'Position could not be found';
		});		
    }
    
    $scope.checkAllFilters = function(e) {
        if($scope.all) {
            $scope.all = false;
        } else {
            $scope.all = true;
        }
        for (var i = 0; i < $scope.filters.length; i++) {
            $scope.filters[i].checked = $scope.all ? true : null;            
        }   
    	
    	$scope.showMarkers();
    }
    
    $scope.showMarkers = function($event) {
        /*if($event) {
            $event.preventDefault();
            $event.stopPropagation();
        }*/
        
        // first collect all of the checked boxes and create an array of strings
        // like ['green', 'blue']
        var list = [];
        for (var i = 0; i < $scope.filters.length; i++) {
            if ($scope.filters[i].checked) list.push(parseInt($scope.filters[i].value));
        }
        
        // then remove any previously-displayed marker groups
        $scope.overlays.clearLayers();
        // create a new marker group
        var clusterGroup = new L.MarkerClusterGroup({
			maxClusterRadius: 40,
			disableClusteringAtZoom: 15
		}).addTo($scope.overlays);

        // and add any markers that fit the filtered criteria to that group.
        $scope.layers.eachLayer(function(layer) {
            if (list.indexOf(parseInt(layer.feature.properties.category_id)) !== -1) {
                clusterGroup.addLayer(layer);
            }
        });
    }
    
});

$(function() {
    $("#legend .dropdown-toggle").on("click",function() {
        var myMenu = $(this).parents(".btn-group").find(".dropdown-menu");
        if(myMenu.is(":visible")) {
            $("#legend .dropdown-menu:visible").hide();
        } else {
            $("#legend .dropdown-menu:visible").hide();
            myMenu.show();
        }        
    });
});
