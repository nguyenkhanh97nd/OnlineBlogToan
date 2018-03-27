myApp.controller('SearchPostController', ['$scope', '$http', '$route',
	function($scope, $http, $route) {

	let urlSearchPost = baseUrl + 'api/client/searchPost'


	$scope.doSearch = function(searchPost) {

		$http({
			headers: {
				'Content-Type': 'application/json',
			},
			method : 'POST',
			url : urlSearchPost,
			data: {
				keyword: $scope.searchPost
			},
			}).then(function(response) {
				
				$scope.posts = response.data.posts
				
				$scope.loadScroll()
			}, function() {

			})
	}

	$scope.loadScroll = function() {
		$(window).scroll(function() {
		    if($(window).scrollTop() == $(document).height() - $(window).height()) {

		        if($scope.posts.next_page_url != null) {
		        	$scope.loading_more_search_post = true

		        	$http({
						headers: {
							'Content-Type': 'application/json',
						},
						method : 'POST',
						url : $scope.posts.next_page_url,
						data: {
							keyword: $scope.searchPost
						},
						}).then(function(response) {
							let count = 0
			        		angular.forEach(response.data.posts.data, function(value, key) {
								angular.forEach($scope.posts.data, function(value_scope, key_scope) {
									if(value_scope.id == value.id) {
										count++
									}
								})
								if(count == 0) {
									$scope.posts.data.push(value)
								}
			
							})

							$scope.posts.next_page_url = response.data.posts.next_page_url
							$scope.loading_more_search_post = false
						}, function(response) {

						})

		        }     
		       
		    }
		});
	}

}])