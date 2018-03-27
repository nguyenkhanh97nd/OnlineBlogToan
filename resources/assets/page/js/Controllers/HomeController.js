myApp.controller('HomeController', ['$scope', '$http', 'AuthJS', function($scope, $http, AuthJS) {
	let url = baseUrl + 'api/client/posts';
	let urlGetRank = baseUrl + 'api/client/getRank';

	$http.get(url).then(function(response) {
		$scope.featurePosts = response.data.featurePosts
		$scope.posts = response.data.posts

		$scope.loadScroll()

	}, function(response) {

	});

	let token = AuthJS.getToken()

	if(token) {
		$http({
			headers: {
				'Content-Type': 'application/json',
				'Authorization': 'Bearer ' + token
			},
			method : 'GET',
			url : urlGetRank,
			data: {

			},
		}).then(function(response) {
			
			$scope.users_sort = response.data.users_sort
			if(response.data.current_rank) {
				$scope.current_rank = response.data.current_rank
			} else if(response.data.current_rank_status) {
				$scope.current_rank_status = response.data.current_rank_status
			}

		})
	}

	$scope.loadScroll = function() {
		$(window).scroll(function() {
		    if($(window).scrollTop() == $(document).height() - $(window).height()) {

		        if($scope.posts.next_page_url != null) {
		        	$scope.loading_more_home = true;

		        	$http({
						headers: {
							'Content-Type': 'application/json',
						},
						method : 'GET',
						url : $scope.posts.next_page_url,
						data: {
							
						},
					}).then(function(response) {
						let count = 0
						angular.forEach(response.data.posts.data, function(value, key) {
							angular.forEach($scope.posts.data, function(value_scope, key_scope) {
								if(value_scope.slug == value.slug) {
									count++
								}
							});
							if(count == 0) {
								$scope.posts.data.push(value)
							}
		
						})
						$scope.posts.next_page_url = response.data.posts.next_page_url;
						$scope.loading_more_home = false
					}, function() {

					})
		        }
		        
		    }
		})
	}

	

}]);