myApp.controller('SettingController', ['$scope', '$http', '$route', 'AuthJS', '$location',
	function($scope, $http, $route, AuthJS, $location) {

	let token = AuthJS.getToken()
	let urlUser = baseUrl+ 'api/client/user'

	let urlSettingName = baseUrl + 'api/client/settingName'
	let urlSettingInfo = baseUrl + 'api/client/settingInfo'
	let urlSettingAvatar = baseUrl + 'api/client/settingAvatar'
	let urlSettingPassword = baseUrl + 'api/client/settingPassword'

	if(!token) {
		$location.path('/')
	}

	$http({
			headers: {
				'Content-Type': 'application/json',
				'Authorization': 'Bearer ' + token
			},
			method : 'GET',
			url : urlUser,
			data: {
				
			},
		}).then(function(response) {
			$scope.user = response.data.user
		}, function() {
			$location.path('/')
		})

	$scope.doSettingName = function(formSettingName) {
		$http({
			headers: {
				'Content-Type': 'application/json',
				'Authorization': 'Bearer ' + token
			},
			method : 'POST',
			url : urlSettingName,
			data: {
				name: formSettingName.name.$viewValue
			},
		}).then(function(response) {

			if(response.data.success) {
				// $route.reload()
				$location.path('/setting')
			}

		}, function() {
			$location.path('/setting')
		})
	}

	$scope.doSettingInfo = function(formSettingInfo) {
		$http({
			headers: {
				'Content-Type': 'application/json',
				'Authorization': 'Bearer ' + token
			},
			method : 'POST',
			url : urlSettingInfo,
			data: {
				info: formSettingInfo.info.$viewValue
			},
		}).then(function(response) {

			if(response.data.success) {
				$location.path('/setting')
			}

		}, function() {

		})
	}

	$scope.doSettingPassword = function(formSettingPassword) {

		var pwd = $scope.password
		var re_pwd = $scope.password_confirmation

		if(pwd != re_pwd) {
			$scope.wrong_password = 'Xác nhận mật khẩu không đúng'
		} else {
			$http({
				headers: {
					'Content-Type': 'application/json',
					'Authorization': 'Bearer ' + token
				},
				method : 'POST',
				url : urlSettingPassword,
				data: {
					cur_pwd: $scope.old_password,
					new_pwd: pwd
				},
			}).then(function(response) {
				if(response.data.wrong_old_password) {
					$scope.wrong_old_password = 'Mật khẩu hiện tại không đúng'
				} else {
					$location.path('/setting')
				}

			}, function() {

			})
		}
	}

	$scope.doSettingAvatar = function(formSettingAvatar) {

		var fileReader = new FileReader()
        fileReader.readAsDataURL(document.getElementById('image').files[0])
        fileReader.onload = (e) => {
            var dataImage = e.target.result
            $http({
				headers: {
					'Content-Type': 'application/json',
					'Authorization': 'Bearer ' + token
				},
				method : 'POST',
				url : urlSettingAvatar,
				data: {
					avatar: dataImage
				},
			}).then(function(response) {
				if(response.data.success) {
					$location.path('/setting')
				}

			}, function() {

			})
        }
		
	}

}])