myApp.controller('SocialLearningController', ['$scope', '$http', '$routeParams', '$location', '$route', '$window', 'AuthJS', '$mdDialog',
	function($scope, $http, $routeParams, $location, $route, $window, AuthJS, $mdDialog) {
	
	let urlCateQuestion = baseUrl + 'api/client/catequestion'
	let urlSubCateQuestion = baseUrl + 'api/client/subcatequestion'
	let urlGetFeeds = baseUrl + 'api/client/comment_feed'
	let urlPostFeed = baseUrl + 'api/client/postFeed'

	let token = AuthJS.getToken()
	let urlUser = baseUrl+ 'api/client/user'

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
	}

	$http.get(urlCateQuestion).then(function(response) {
		$scope.catequestion = response.data

		angular.forEach($scope.catequestion, function(value, key) {

			value['color'] = $scope.getColor()

		})
	}, function(response) {
		$location.path('/')
	})


	if(!$routeParams.param1) {

		// load full
		
		$http.get(urlGetFeeds, {params: { sort_key: $location.search().sort }}).then(function(response) {
			$scope.feeds = response.data.feeds
		}, function(response) {
			// $location.path('/')
		})
		

	} else {

		if(!$routeParams.param2) {
			// load cate
			let urlCateGetFeeds = urlCateQuestion + '/' + $routeParams.param1
			$http.get(urlCateGetFeeds, {params: { sort_key: $location.search().sort }}).then(function(response) {
				$scope.feeds = response.data.feeds
				$('#belong-cate-'+$routeParams.param1).css('display', 'block')
			}, function(response) {
				// $location.path('/')
			})

		} else {

			// load subcate

			let urlSubCateGetFeeds = urlSubCateQuestion + '/' + $routeParams.param2
			$http.get(urlSubCateGetFeeds, {params: { sort_key: $location.search().sort }}).then(function(response) {
				$scope.feeds = response.data.feeds
				$('#belong-cate-'+$routeParams.param1).css('display', 'block')
			}, function(response) {
				// $location.path('/')
			})

		}

	}

	$scope.addQuestion = function() {
		if($scope.user) {
			$('.showQuestionForm').css('display', 'inline-block')
		} else {
			alert('Bạn cần đăng nhập')
		}
	}

	if($location.search().sort) {
		$scope.sort_by = $location.search().sort
	}

	$scope.sort_custom = function() {
		$window.location.href = $location.path()+'?sort='+$scope.sort_by
	}


	$scope.doRefresh = function() {
		$route.reload()
	}

	$scope.getColor = function() {

		return '#' + Math.random().toString(16).slice(2, 8)

	}
	$scope.color1 = $scope.getColor()
	$scope.color2 = $scope.getColor()


	$scope.select_cate_fun = function() {
		$scope.subcatequestion = null
		let urlCateGetFeeds = urlCateQuestion + '/' + $scope.select_cate
		$http.get(urlCateGetFeeds).then(function(response) {
			$scope.subcatequestion = response.data.subcatequestion
			$('.div_select_subcate').css('display', 'inline')
		}, function(response) {
			$location.path('/')
		})
	}

	$scope.cancel_form_add = function() {
		$('.showQuestionForm').css('display', 'none')
	}

	$scope.zoom = true
	$scope.cancel_resize_add = function() {
		if($scope.zoom) {
			$('.showQuestionForm').css('top', '20%')
			$scope.zoom = false
		} else {
			$('.showQuestionForm').css('top', "")
			$scope.zoom = true
		}
	}
	$scope.minify = true
	$scope.cancel_minify_add = function() {
		if($scope.minify) {
			$('.showQuestionForm').css('top', '90%')
			$scope.minify = false
		} else {
			$('.showQuestionForm').css('top', "")
			$scope.minify = true
		}
	}

	var fileInput  = $( ".input-file" ),  
	    button     = document.querySelector( ".input-file-trigger" ),
	    the_return = document.querySelector(".file-return");
	
	button.addEventListener( "keydown", function( event ) {  
	    if ( event.keyCode == 13 || event.keyCode == 32 ) {  
	        fileInput.focus();  
	    }  
	});


	button.addEventListener( "click", function( event ) {
	   fileInput.focus();
	   return false;
	});

	$scope.dataImageQuestion = null

	fileInput.change(function(event) {
		the_return.innerHTML = this.value;
	    if(this.files[0]) {
	    	let fileReader = new FileReader()
	        fileReader.readAsDataURL(this.files[0])
	        fileReader.onload = (e) => {
	            let dataImage = e.target.result

	            let newImage = document.createElement('img');
		        newImage.src = dataImage;

		        document.getElementById("imgQuestion").innerHTML = newImage.outerHTML;

		        $('#imgQuestion img').css('max-width', '200px')
		        $('.remove-add-image').css('display', 'inline')

		        $scope.dataImageQuestion = dataImage
	        }
	    } else {
	    	$scope.dataImageQuestion = null
	    	$('#imgQuestion img').remove()
	    }
	})


	$scope.removeImageData = function() {
		$scope.dataImageQuestion = null
    	$('#imgQuestion img').remove()
    	$('.file-return').html('')
		$('.remove-add-image').css('display', 'none')
	}

	$scope.addQuestionFun = function() {

		if($scope.select_cate && $scope.select_subcate && $scope.title_question && $scope.content_question && $scope.point_set) {
			$http({
				headers: {
					'Content-Type': 'application/json',
					'Authorization': 'Bearer ' + token
				},
				method : 'POST',
				url : urlPostFeed,
				data: {
					cate: $scope.select_cate,
					subcate: $scope.select_subcate,
					title: $scope.title_question,
					content: $scope.content_question,
					imageData: $scope.dataImageQuestion,
					point_set: $scope.point_set
				},
			}).then(function(response) {
				
				if(response.data.error) {
					alert(response.data.error)
				} else {
					alert(response.data.success)
					$route.reload()
				}

			}, function() {

				alert('Lỗi')

			})
		} else {
			alert('Cần điền đủ thông tin')
		}		

	}

	$scope.goTo = function(e) {

		if(e.currentTarget.value > 0 && e.currentTarget.value <= $scope.feeds.last_page) {
			let urlGoTo = $scope.feeds.path + "?page=" + e.currentTarget.value

			$http.get(urlGoTo, {params: { sort_key: $location.search().sort }}).then(function(response) {
				$scope.feeds = response.data.feeds
			}, function(response) {
				
			})
		}

	}
	$scope.goPrev = function() {

		if($scope.feeds.prev_page_url) {
			let urlGoPrev = $scope.feeds.prev_page_url

			$http.get(urlGoPrev, {params: { sort_key: $location.search().sort }}).then(function(response) {
				$scope.feeds = response.data.feeds
			}, function(response) {
				
			})
		}

	}

	$scope.goNext = function() {

		if($scope.feeds.next_page_url) {
			let urlGoNext = $scope.feeds.next_page_url

			$http.get(urlGoNext, {params: { sort_key: $location.search().sort }}).then(function(response) {
				$scope.feeds = response.data.feeds
			}, function(response) {
				
			})
		}

	}

}])