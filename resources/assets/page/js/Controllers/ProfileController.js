myApp.controller('ProfileController', ['$scope', '$http', '$routeParams', 'AuthJS', '$route', '$window', '$location',

	function($scope, $http, $routeParams, AuthJS, $route, $window, $location) {
	
	let urlUser = baseUrl + 'api/client/user'

	let urlGetUser = baseUrl + 'api/client/getUser/' + $routeParams.param

	let urlDoLike = baseUrl + 'api/client/like'

	let urlDoDislike = baseUrl + 'api/client/dislike'

	let urlDoComment = baseUrl + 'api/client/comment'

	let token = AuthJS.getToken()

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
		method : 'GET',
		url : urlGetUser,
		data: {
			
		},
	}).then(function(response) {
		$scope.getUser = response.data.getUser
		$scope.max_points = response.data.max_points
		$scope.feeds = response.data.feeds
		console.log($scope.getUser)
		$scope.loadScroll()
	}, function() {
		$location.path('/')
	})

	
	$scope.loadScroll = function() {
		$(window).scroll(function() {
		    if($(window).scrollTop() == $(document).height() - $(window).height()) {
		        
		        if($scope.feeds.next_page_url != null) {
		        	$scope.loading_more_status = true
		        	$http({
						headers: {
							'Content-Type': 'application/json',
							'Authorization': 'Bearer ' + token
						},
						method : 'GET',
						url : $scope.feeds.next_page_url,
						data: {
							
						},
					}).then(function(response) {

						let count = 0
						angular.forEach(response.data.feeds.data, function(value, key) {
							angular.forEach($scope.feeds.data, function(value_scope, key_scope) {
								if(value_scope.slug == value.slug) {
									count++
								}
							});
							if(count == 0) {
								$scope.feeds.data.push(value)
							}
		
						})
						$scope.feeds.next_page_url = response.data.feeds.next_page_url
						$scope.loading_more_status = false
					}, function() {

					})
		        }	       
		    }
		})
	}


	$scope.doLike = function(status) {
		$http({
		headers: {
			'Content-Type': 'application/json',
			'Authorization': 'Bearer ' + token
		},
		method : 'POST',
		url : urlDoLike,
		data: {
			slug_feed: status.slug.$$attr.value
		},
		}).then(function(response) {
			$route.reload()
		}, function() {

		})
	}

	$scope.doDislike = function(status) {
		$http({
		headers: {
			'Content-Type': 'application/json',
			'Authorization': 'Bearer ' + token
		},
		method : 'POST',
		url : urlDoDislike,
		data: {
			slug_feed: status.slug.$$attr.value
		},
		}).then(function(response) {
			$route.reload()
		}, function() {

		})
	}

	$scope.doComment = function(status) {

		$http({
		headers: {
			'Content-Type': 'application/json',
			'Authorization': 'Bearer ' + token
		},
		method : 'POST',
		url : urlDoComment,
		data: {
			slug_feed: status.slug.$$attr.value,
			comment_content: status.comment.$viewValue
		},
		}).then(function(response) {

			$window.location.href = '/comment_feed/' + status.slug.$$attr.value

		}, function() {

		})
	}

	$scope.doShare = function(status) {
		alert('Chức năng chưa được cập nhật!')
	}

}]).filter('check_like_feed', function() {
	return function (list_like_feed, current_user_id) {
		let status = false
		let going = true
		angular.forEach(list_like_feed, function(like_feed, key) {
			if(going) {
				if(like_feed.id_user == current_user_id) {
					status = true
					going = false
				}
			}
		})
		return status
	}
})