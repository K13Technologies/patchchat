app.controller('directionsController', ['$scope',function($scope) {
    $scope.origin = null;

    $scope.getDirections = function() {
        directions.setOrigin( $scope.origin );
        
        var dest = directions.getDestination();
        
        var destLatLng = L.latLng([
            dest.geometry.coordinates[1],
            dest.geometry.coordinates[0]
        ]);
        directions.query({
            proximity: destLatLng
        });
        
    }
}]);
  