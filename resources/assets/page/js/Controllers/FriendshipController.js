myApp.controller('FriendshipController', ['$scope', '$http', 'AuthJS', '$routeParams', '$route', '$location',
	function($scope, $http, AuthJS, $routeParams, $route, $location) {
		let token = AuthJS.getToken()

		let urlUser = baseUrl+ 'api/client/user'
		let urlFollowers = baseUrl + 'api/client/followers'



		let urlAddFollow = baseUrl + 'api/client/addFollow'
		let urlRemoveFollow = baseUrl + 'api/client/removeFollow'
		let urlFollowing = baseUrl + 'api/client/following'

		if(!token) {
			alert('Bạn cần đăng nhập để sử dụng tính năng này')
			$location.path('/login')
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
			$('#logout-click').click()
		})

		$http({
			headers: {
				'Content-Type': 'application/json',
				'Authorization': 'Bearer ' + token
			},
			method : 'POST',
			url : urlFollowing,
			data: {
				
			},
			}).then(function(response) {
				$scope.followings = response.data.followings
				$scope.followers = response.data.followers
				$scope.users = response.data.users
			}, function() {
				
			})


		$scope.doRemoveFollow = function(formRemoveFollow) {
			
			if($routeParams.param) {
				getUsername = $routeParams.param
			} else {
				getUsername = formRemoveFollow.inputUsername.$$attr.value
			}
			$http({
			headers: {
				'Content-Type': 'application/json',
				'Authorization': 'Bearer ' + token
			},
			method : 'POST',
			url : urlRemoveFollow,
			data: {
				username: getUsername,
			},
			}).then(function(response) {

				if(response.data.success) {

					$route.reload()
				} else {

				}

			}, function() {

			})
		}


		$scope.doAddFollow = function(formAddFollow) {

			if($routeParams.param) {
				getUsername = $routeParams.param
			} else {
				getUsername = formAddFollow.inputUsername.$$attr.value
			}

			$http({
			headers: {
				'Content-Type': 'application/json',
				'Authorization': 'Bearer ' + token
			},
			method : 'POST',
			url : urlAddFollow,
			data: {
				username: getUsername,
			},
			}).then(function(response) {

				if(response.data.success) {
					$route.reload()
				} else {

				}

			}, function() {

			})

		}




		$scope.doSearch = function(search) {
			$http({
			headers: {
				'Content-Type': 'application/json',
				'Authorization': 'Bearer ' + token
			},
			method : 'POST',
			url : urlFollowing,
			data: {
				search_user: search
			},
			}).then(function(response) {
				$scope.followers = response.data.followers
				$scope.followings = response.data.followings
				$scope.users = response.data.users
				$scope.show_followers_model = false

			}, function() {

			})
		}

		$scope.show_followers = function() {

			$scope.show_followers_model = true
			$scope.users = false

			$http({
				headers: {
					'Content-Type': 'application/json',
					'Authorization': 'Bearer ' + token
				},
				method: 'POST',
				url: urlFollowers,
				data: {

				}
			}).then(function(response) {
				$scope.show_followers_model = response.data.followers
			})

		}

}]).filter('check_following', function() {
	return function (list_following, current_user_id) {
		let status = false
		let going = true
		angular.forEach(list_following, function(friendship, key) {
			if(going) {
				if(friendship.id == current_user_id) {
					status = true
					going = false
				}
			}
		})
		return status
	}
})