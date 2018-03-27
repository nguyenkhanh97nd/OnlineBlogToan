myApp.controller('SubCategoryController', ['$scope', '$http', '$routeParams', '$location',
	function($scope, $http, $routeParams, $location) {
	
	let url = baseUrl + 'api/client/subcategory/' + $routeParams.param

	$http.get(url).then(function(response) {
		$scope.subcategory = response.data.subcategory
		$scope.posts = response.data.posts
		$scope.top_posts = response.data.top_posts

		$scope.loadScroll()

	}, function(response) {
		$location.path('/')
	})

	$scope.loadScroll = function() {
		$(window).scroll(function() {
		    if($(window).scrollTop() == $(document).height() - $(window).height()) {

		        if($scope.posts.next_page_url != null) {
		        	$scope.loading_more_cate_post = true

		        	$http.get($scope.posts.next_page_url).then(function(response) {
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
					$scope.loading_more_cate_post = false
					}, function(response) {

					})
		        }       
		       
		    }
		});
	}

	
}])