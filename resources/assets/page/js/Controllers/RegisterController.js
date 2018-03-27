myApp.controller('RegisterController', ['$scope', '$http', '$window', 'AuthJS', '$location',
	function($scope, $http, $window, AuthJS, $location) {

	if(AuthJS.getToken()) {
		$location.path('/')
	}

	$scope.doRegister = function(registerForm) {
		let url = baseUrl + 'api/client/register'
		$scope.wrong_form = false
		$scope.wrong_name = false
		$scope.wrong_username = false
		$scope.wrong_email = false
		$scope.wrong_password = false
		$scope.wrong_gender = false

		$http({
			
			method : 'POST',
			url : url,
			data: {
				name: $scope.name,
				username: $scope.username,
				email: $scope.email,
				password: $scope.password,
				repassword: $scope.repassword,
				gender: $scope.gender
			},
		}).then(function(response) {
			if(response.data.wrong_form) {
				$scope.wrong_form = response.data.wrong_form
			} else if(response.data.wrong_name) {
		    	$scope.wrong_name = response.data.wrong_name
		    } else if(response.data.wrong_username){
		    	$scope.wrong_username = response.data.wrong_username
		    } else if(response.data.wrong_email){
		    	$scope.wrong_email = response.data.wrong_email
		    } else if(response.data.wrong_password){
		    	$scope.wrong_password = response.data.wrong_password
		    } else if(response.data.wrong_gender){
		    	$scope.wrong_gender = response.data.wrong_gender
		    } else if(response.data.success){
		    	$window.alert(response.data.success)
		    	$window.location.href = '/login'
		    } else {
		    	$window.location.href = '/'
		    }
		}, function(response) {
				$window.location.href = '/'
		})
	}

}])