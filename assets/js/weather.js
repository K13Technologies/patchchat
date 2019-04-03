app.controller('weatherController', ['$scope', 'weatherService', function($scope, weatherService) {
     $scope.place = null;
     
     function fetchWeather(lat,lng) {
         weatherService.getWeather(lat,lng).then(function(data) {
             $scope.place = data;
         });
     }
     
     fetchWeather($("#facility-map").attr("data-lat"),$("#facility-map").attr("data-lng"));     
 }]);
  
app.factory('weatherService', ['$http', '$q','$locale', function($http, $q, $locale) {
    function getWeather(lat,lng) {
        var deferred = $q.defer();
        $http.get('http://api.openweathermap.org/data/2.5/forecast/daily?lat='+lat+'&lon='+lng+'&mode=json&units=' + ($locale.id=="en-us" ? "imperial" : "metric"))
            .success(function(data) {
                deferred.resolve(data);
            })
            .error(function(err) {
                 console.log('Error retrieving markets');
                 deferred.reject(err);
            });
        return deferred.promise;
    }
    return {
        getWeather: getWeather
    };
}]);
