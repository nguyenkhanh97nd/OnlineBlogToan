myApp.controller('PostController', ['$scope', '$http', '$routeParams', '$sce', 'AuthJS', '$route', '$location',
	function($scope, $http, $routeParams, $sce, AuthJS, $route, $location) {
	
	let urlPost = baseUrl + 'api/client/' + $routeParams.param1 + '/' + $routeParams.param2
	let urlComment = baseUrl + 'api/client/comment/' + $routeParams.param2
	let urlUser = baseUrl + 'api/client/user'

	$http.get(urlPost).then(function(response) {

		$scope.post = response.data.post
		$scope.testonline = response.data.testonline
		$scope.same_posts = response.data.same_posts
		$scope.content = $sce.trustAsHtml(response.data.post.content)
	}, function(response) {
		$location.path('/')
	})

	let token = AuthJS.getToken()

	if(token) {
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
			url : urlComment,
			data: {
				
			},
		}).then(function(response) {
			$scope.comments = response.data.comments
			
			$scope.loadScroll()

		}, function() {

		})

		$scope.loadScroll = function() {
			
			$(window).scroll(function() {
			    if($(window).scrollTop() == $(document).height() - $(window).height()) {

			        if($scope.comments.next_page_url != null) {
			        	$scope.loading_more_comment = true

			        	$http({
							headers: {
								'Content-Type': 'application/json',
								'Authorization': 'Bearer ' + token
							},
							method : 'GET',
							url : $scope.comments.next_page_url,
							data: {
								
							},
						}).then(function(response) {

							let count = 0

							angular.forEach(response.data.comments.data, function(value, key) {
								angular.forEach($scope.comments.data, function(value_scope, key_scope) {
									if(value_scope.id == value.id) {
										count++
									}
								})
								if(count == 0) {
									$scope.comments.data.push(value)
								}
			
							})
							$scope.comments.next_page_url = response.data.comments.next_page_url

							$scope.loading_more_comment = false
						}, function() {

						})
			        }
			       
			    }
			   
			})
		}

		

		$scope.wrong_comment = false
		$scope.doComment = function(commentForm) {
			$http({
			headers: {
				'Content-Type': 'application/json',
				'Authorization': 'Bearer ' + token
			},
			method : 'POST',
			url : urlComment,
			data: {
				comment_content: $scope.comment_content
			},
			}).then(function(response) {
				if(response.data.success) {
					$route.reload()
				} else if (response.data.wrong_comment){
					$scope.wrong_comment = response.data.wrong_comment
				} else {
					$route.reload()
				}
			}, function() {

			})
		}
	}

	

}])