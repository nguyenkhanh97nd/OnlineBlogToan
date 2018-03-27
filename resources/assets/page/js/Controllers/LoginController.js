myApp.controller('LoginController', ['$scope', '$http', '$window', 'AuthJS', '$location',
	function($scope, $http, $window, AuthJS, $location) {

	if(AuthJS.getToken()) {
		$location.path('/')
	}

	$scope.doLogin = function(loginForm) {

		let url = baseUrl + 'login'
		$scope.wrong_account = false
		$scope.wrong_info = false

		$http({
			headers: {
				'Content-Type': 'application/json'
			},
			method : 'POST',
			url : url,
			data: {
				login: $scope.login,
				password: $scope.password
			},
		}).then(function (response) {

			if(response.data.wrong_info) {
				$scope.wrong_info = response.data.wrong_info
			} else if(response.data.wrong_account) {
		    	$scope.wrong_account = response.data.wrong_account
		    } else if(response.data.token){
		    	localStorage.setItem('token', response.data.token)
		    	$window.location.href = '/'
		    } else {
		    	$window.location.href= '/login'
		    }

		  }, function errorCallback(response) {
		  		// $window.location.href= '/login'
		  })
	}

	$scope.goForgot = function() {
		$window.location.href = '/password/reset'
	}

}])