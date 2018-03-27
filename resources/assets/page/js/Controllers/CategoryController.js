myApp.controller('CategoryController', ['$scope', '$http', '$routeParams', '$location',
	function($scope, $http, $routeParams, $location) {
	
	let url = baseUrl + 'api/client/category/' + $routeParams.param

	$http.get(url).then(function(response) {
		$scope.category = response.data
	}, function(response) {
		$location.path('/')
	})
}])