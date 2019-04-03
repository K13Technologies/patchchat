var directions = null;
var fmap = null;
$(function() {
	var innernav = $("#inner-nav");
	var innernavOffset = innernav.offset();
	var innerNavFixed = 0;
	
	if(innernav.size()>0) {
		$(window).scroll(function(){
			var scrollTop = $(window).scrollTop();
			if(scrollTop > innernavOffset.top && !innerNavFixed ) {
				innerNavFixed  = 1;
				innernav.addClass("nav-sticky");
			} else if(scrollTop <= innernavOffset.top && innerNavFixed) {			
				innerNavFixed  = 0;
				innernav.removeClass("nav-sticky");
			}   
	    });
	}
	
	$('.management-photos-link').on('click', function() {
		$('.gallery').magnificPopup('open');	
	});
	
	
	$("a.inner-link").on("click", function(e) {
		innerNavFixed  = 1;
		innernav.addClass("nav-sticky");
		document.location.hash = $(this).attr("href");
		e.preventDefault();
		var target = $($(this).attr("href"));
		var offset = target.offset();
		window.scrollTo(0, (parseInt(offset.top) - 90));		
	});

	$('.gallery').magnificPopup({
		delegate: 'a',
        type: 'image',
        gallery: {
            enabled: true,
            navigateByImgClick: true,
            preload: [0,2]			
        },
        fixedContentPos: false        
	});
	
	var facilitymap = $("#facility-map");
	if(facilitymap.size()>0) {
		L.mapbox.accessToken = 'pk.eyJ1Ijoic21hcnRmb3hlcyIsImEiOiJlMGM2MTEwOGYyYjBmZTZiMmQ5YjZjZjE1ZWEzNWY1MCJ9.8EBv0gylarBZLZE9AG1mgQ';
		fmap = L.mapbox.map('facility-map', 'mapbox.streets').setView([facilitymap.attr('data-lat'),facilitymap.attr('data-lng')], 14);
		var facilityLatLng = L.latLng([
           facilitymap.attr('data-lat'),
           facilitymap.attr('data-lng')
        ]);
        
		var geojson = [
           {
           "type": "FeatureCollection",
           "features": [
             {
               "type": "Feature",
               "geometry": {
                 "type": "Point",
                 "coordinates": [
                   facilitymap.attr('data-lng'),
                   facilitymap.attr('data-lat')
                ]
               },
               "properties": {
        	      "marker-color": "#1729b0",
        	      "marker-size": "large",
        	      "marker-symbol": "star",
        	      'title' : facilitymap.attr('data-title'),
        	      'description' : facilitymap.attr('data-description')
        	    }
        	    /*
        	    "icon": {
                        "iconSize": [33, 33],
                        "iconAnchor": [16, 16], 
                        "popupAnchor": [0, -16],
                        "className": "pcmi pcmi-" + facilitymap.attr('data-icon')
                    },*/
             }
           ]
         }

         ];
         
         var myLayer = L.mapbox.featureLayer().setGeoJSON(geojson).addTo(fmap);
         
        // create the initial directions object, from which the layer
        // and inputs will pull data.
        directions = L.mapbox.directions({
            profile: 'mapbox.driving',
        });
        
        directions.on('load', function() {
            var dest = directions.getDestination();
            var origin = directions.getOrigin();
            
            fmap.fitBounds([
                [dest.geometry.coordinates[1],dest.geometry.coordinates[0]],
                [origin.geometry.coordinates[1],origin.geometry.coordinates[0]]
            ]);
            console.log(dest.geometry.coordinates);
            console.log(origin.geometry.coordinates);    
        }); 
        
        var directionsLayer = L.mapbox.directions.layer(directions)
            .addTo(fmap);
        
        //var directionsInputControl = L.mapbox.directions.inputControl('inputs', directions)
        //    .addTo(fmap);
        
        var directionsErrorsControl = L.mapbox.directions.errorsControl('errors', directions)
            .addTo(fmap);
        
        var directionsRoutesControl = L.mapbox.directions.routesControl('routes', directions)
            .addTo(fmap);
        
        var directionsInstructionsControl = L.mapbox.directions.instructionsControl('instructions', directions)
            .addTo(fmap);
        
        directions.setDestination( facilityLatLng );
	}
	
    $('.form-control[data-toggle=popover]').popover({
		trigger: 'focus',
		html: true,
		placement: 'auto right'
	});
	
	if(typeof muutSignature !== 'undefined') {
    	$('.patchchat-community').muut({
            api: {
                key: 'mMif7OgLlK',
                message: muutMessage,
                signature: muutSignature,
                timestamp: muutTimestamp
            }
        });
    }

});

    
var app = angular.module('PatchChat', ['summernote','angularModalService'], function($interpolateProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');    
});

angular.module('PatchChat')
	.filter('to_trusted', ['$sce', function($sce){
	    return function(text) {
	        return $sce.trustAsHtml(text);
	    };
	}])
	.directive('stringToNumber', function() {
	  return {
	    require: 'ngModel',
	    link: function(scope, element, attrs, ngModel) {
	      ngModel.$parsers.push(function(value) {
	        return '' + value;
	      });
	      ngModel.$formatters.push(function(value) {
	        return parseFloat(value, 10);
	      });
	    }
	  };
	});
  
function goTo(target) {    
    $('html,body').animate({
        scrollTop: $(target).offset().top
    }, 1000);
}