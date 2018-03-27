myApp.controller('CommentFeedController', ['$scope', '$http', 'AuthJS', '$routeParams', '$route', '$location',
	function($scope, $http, AuthJS, $routeParams, $route, $location) {
	
	let urlUser = baseUrl + 'api/client/user'

	let urlCommentFeed = 'api/client/comment_feed/' + $routeParams.param

	let urlDoLike = baseUrl + 'api/client/like'

	let urlDoDislike = baseUrl + 'api/client/dislike'

	let urlDoComment = baseUrl + 'api/client/comment'

	let urlAddFollow = baseUrl + 'api/client/addFollow'
	let urlRemoveFollow = baseUrl + 'api/client/removeFollow'

	let urlAcceptAnswerFeed = baseUrl + 'api/client/accept_answer_feed'
	let urlRemoveAcceptAnswerFeed = baseUrl + 'api/client/remove_accept_answer_feed'

	let urlLockFeed = baseUrl + 'api/client/lock_feed'
	let urlRemoveFeed = baseUrl + 'api/client/remove_feed'
	let urlEditFeed = baseUrl + 'api/client/edit_feed'

	let urlCateQuestion = baseUrl + 'api/client/catequestion'
	let urlSubCateQuestion = baseUrl + 'api/client/subcatequestion'

	let token = AuthJS.getToken()

	if(!token) {
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

	})

	$http({
		headers: {
			'Content-Type': 'application/json',
			'Authorization': 'Bearer ' + token
		},
		method : 'GET',
		url : urlCommentFeed,
		data: {
			
		},
	}).then(function(response) {
		$scope.getUser = response.data.getUser
		$scope.feed = response.data.feed
		$scope.subcatequestion = response.data.feed.sub_cate_question.cate_question.sub_cate_question
		$scope.title_question = response.data.feed.name
		$scope.content_question = response.data.feed.content
		$scope.comment_feeds = response.data.comment_feeds
		$scope.total_comments = response.data.total_comments

		if($scope.feed.status != 1) {
			$('.hidden_status').css('display', 'none')
		}

		$scope.loadScroll()
	}, function() {

	})

	$scope.doRemoveFollow = function(formRemoveFollow) {

			getUsername = formRemoveFollow.inputUsername.$$attr.value

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

			getUsername = formAddFollow.inputUsername.$$attr.value

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
			comment_content: status.comment.$viewValue,
			comment_image: $scope.dataImageComment
		},
		}).then(function(response) {
			$route.reload()
		}, function() {

		})
	}

	$scope.focus_comment = function() {
		$('.focus-comment').focus()
	}
	$scope.doShare = function() {
		alert('Chức năng đang được cập nhật')
	}

	$scope.loadScroll = function() {
		$(window).scroll(function() {
		    if($(window).scrollTop() == $(document).height() - $(window).height()) {
		        
		        if($scope.comment_feeds.next_page_url != null) {
		        	$scope.load_more_comment_feeds = true
		        	$http({
						headers: {
							'Content-Type': 'application/json',
							'Authorization': 'Bearer ' + token
						},
						method : 'GET',
						url : $scope.comment_feeds.next_page_url,
						data: {
							
						},
					}).then(function(response) {

						let count = 0
						angular.forEach(response.data.comment_feeds.data, function(value, key) {
							angular.forEach($scope.comment_feeds.data, function(value_scope, key_scope) {
								if(value_scope.id == value.id) {
									count++
								}
							});
							if(count == 0) {
								$scope.comment_feeds.data.push(value)
							}
		
						})
						$scope.comment_feeds.next_page_url = response.data.comment_feeds.next_page_url
						$scope.load_more_comment_feeds = false
					}, function() {

					})
		        }	       
		    }
		})
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



	$scope.dataImageComment = null

	fileInput.change(function(event) {
		the_return.innerHTML = this.value;
	    if(this.files[0]) {
	    	let fileReader = new FileReader()
	        fileReader.readAsDataURL(this.files[0])
	        fileReader.onload = (e) => {
	            let dataImage = e.target.result

	            let newImage = document.createElement('img');
		        newImage.src = dataImage;

		        document.getElementById("imgComment").innerHTML = newImage.outerHTML;

		        $('#imgComment img').css('max-width', '200px')
		        $('.remove-add-image').css('display', 'inline')

		        $scope.dataImageComment = dataImage
	        }
	    } else {
	    	$scope.dataImageComment = null
	    	$('#imgComment img').remove()
	    }
	})


	$scope.removeImageData = function() {
		$scope.dataImageComment = null
    	$('#imgComment img').remove()
    	$('.file-return').html('')
		$('.remove-add-image').css('display', 'none')
	}

	$scope.edit_comment_feed = function(event) {
		$('.showQuestionForm').css('display', 'inline-block')
	}

	$http.get(urlCateQuestion).then(function(response) {
		$scope.catequestion = response.data
	}, function(response) {

	})

	$scope.select_cate_fun = function() {
		$scope.subcatequestion = null
		$scope.select_subcate = null
		let urlCateGetFeeds = urlCateQuestion + '/' + $scope.select_cate
		$http.get(urlCateGetFeeds).then(function(response) {
			$scope.subcatequestion = response.data.subcatequestion
		}, function(response) {

		})
	}

	$scope.editQuestionFun = function(event) {
		console.log($scope.select_subcate)
		let slug = $routeParams.param
		$http({
			headers: {
				'Content-Type': 'application/json',
				'Authorization': 'Bearer ' + token
			},
			method : 'POST',
			url : urlEditFeed,
			data: {
				feed_slug: slug,
				cate: $scope.select_cate,
				subcate: $scope.select_subcate,
				title: $scope.title_question,
				content: $scope.content_question,
				imageData: $scope.dataImageQuestion,
			},
			}).then(function(response) {
				console.log(response)

				if(response.data.success) {
					$route.reload()
				} else {
					alert(response.data.error)
				}
			}, function() {
				// alert("Lỗi")
			})

	}


	$scope.remove_comment_feed = function(event) {
		
		let slug = event
		$http({
			headers: {
				'Content-Type': 'application/json',
				'Authorization': 'Bearer ' + token
			},
			method : 'POST',
			url : urlRemoveFeed,
			data: {
				feed_slug: slug,
			},
			}).then(function(response) {
				if(response.data.success) {
					$location.path('/social-learning')
				} else {
					alert(response.data.error)
				}
			}, function() {
				alert("Lỗi")
			})

	}

	$scope.lock_feed = function(event) {
		let slug = event.currentTarget.name
		$http({
			headers: {
				'Content-Type': 'application/json',
				'Authorization': 'Bearer ' + token
			},
			method : 'POST',
			url : urlLockFeed,
			data: {
				feed_slug: slug,
			},
			}).then(function(response) {
				if(response.data.success) {
					$route.reload()
				} else {
					alert(response.data.error)
				}
			}, function() {
				alert("Lỗi")
			})
	}

	$scope.accept_ans =function(event) {
		let id = event.currentTarget.id
		$http({
			headers: {
				'Content-Type': 'application/json',
				'Authorization': 'Bearer ' + token
			},
			method : 'POST',
			url : urlAcceptAnswerFeed,
			data: {
				comment_id: id,
			},
			}).then(function(response) {
				if(response.data.success) {
					$route.reload()
				} else {
					alert(response.data.error)
				}
			}, function() {
				alert("Lỗi")
			})

	}

	$scope.remove_accept_ans = function(event) {
		let id = event.currentTarget.id
		$http({
			headers: {
				'Content-Type': 'application/json',
				'Authorization': 'Bearer ' + token
			},
			method : 'POST',
			url : urlRemoveAcceptAnswerFeed,
			data: {
				comment_id: id,
			},
			}).then(function(response) {
				if(response.data.success) {
					$route.reload()
				} else {
					alert(response.data.error)
				}
			}, function() {
				alert("Lỗi")
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

}])