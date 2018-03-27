/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId])
/******/ 			return installedModules[moduleId].exports;
/******/
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// identity function for calling harmony imports with the correct context
/******/ 	__webpack_require__.i = function(value) { return value; };
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 314);
/******/ })
/************************************************************************/
/******/ ({

/***/ 153:
/***/ (function(module, exports, __webpack_require__) {

$("div.alert").delay(3000).slideUp();

window.baseUrl = 'http://127.0.0.1:8000/';
window.myApp = angular.module('myApp', ['ngRoute', 'ngSanitize', 'ngMaterial'], function ($interpolateProvider) {
	$interpolateProvider.startSymbol('<%kh');
	$interpolateProvider.endSymbol('hk%>');
}).filter('myDateFormat', function myDateFormat($filter) {
	return function (text) {
		var tempdate = new Date(text.replace(/-/g, "/"));
		return $filter('date')(tempdate, "dd-MM-yyyy");
	};
});

__webpack_require__(236);

__webpack_require__(227);
__webpack_require__(230);
__webpack_require__(226);
__webpack_require__(223);
__webpack_require__(234);
__webpack_require__(228);
__webpack_require__(235);
__webpack_require__(229);
__webpack_require__(225);
__webpack_require__(231);
__webpack_require__(232);
__webpack_require__(224);

__webpack_require__(233);

myApp.config(['$routeProvider', '$locationProvider', function ($routeProvider, $locationProvider) {
	$routeProvider.when('/register', {
		templateUrl: 'template/auth/register.html',
		controller: 'RegisterController'
	}).when('/login', {
		templateUrl: 'template/auth/login.html',
		controller: 'LoginController'
	}).when('/search', {
		templateUrl: 'template/search/search.html',
		controller: 'SearchPostController'
	}).when('/social-learning', {
		templateUrl: 'template/social-learning/index.html',
		controller: 'SocialLearningController'
	}).when('/follow', {
		templateUrl: 'template/friend/friend.html',
		controller: 'FriendshipController'
	}).when('/setting', {
		templateUrl: 'template/setting/setting.html',
		controller: 'SettingController'
	}).when('/setting/name', {
		templateUrl: 'template/setting/name.html',
		controller: 'SettingController'
	}).when('/setting/password', {
		templateUrl: 'template/setting/password.html',
		controller: 'SettingController'
	}).when('/setting/avatar', {
		templateUrl: 'template/setting/avatar.html',
		controller: 'SettingController'
	}).when('/setting/info', {
		templateUrl: 'template/setting/info.html',
		controller: 'SettingController'
	}).when('/social-learning/:param1', {
		templateUrl: 'template/social-learning/index.html',
		controller: 'SocialLearningController'
	}).when('/social-learning/:param1/:param2', {
		templateUrl: 'template/social-learning/index.html',
		controller: 'SocialLearningController'
	}).when('/profile/:param', {
		templateUrl: 'template/profile/user.html',
		controller: 'ProfileController'
	}).when('/comment_feed/:param', {
		templateUrl: 'template/comment_feed/comment.html',
		controller: 'CommentFeedController'
	}).when('/testonline/:param', {
		templateUrl: 'template/testonline/test.html',
		controller: 'TestOnlineController'
	}).when('/:param.html', {
		templateUrl: 'template/category/category.html',
		controller: 'CategoryController'
	}).when('/:param', {
		templateUrl: 'template/category/subcategory.html',
		controller: 'SubCategoryController'
	}).when('/:param1/:param2', {
		templateUrl: 'template/single/post.html',
		controller: 'PostController'
	}).when('/', {
		templateUrl: 'template/index.html',
		controller: 'HomeController'
	});

	$locationProvider.html5Mode(true);
	$locationProvider.hashPrefix('');
}]);

/***/ }),

/***/ 154:
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ 155:
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ 156:
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ 223:
/***/ (function(module, exports) {

myApp.controller('CategoryController', ['$scope', '$http', '$routeParams', '$location', function ($scope, $http, $routeParams, $location) {

	var url = baseUrl + 'api/client/category/' + $routeParams.param;

	$http.get(url).then(function (response) {
		$scope.category = response.data;
	}, function (response) {
		$location.path('/');
	});
}]);

/***/ }),

/***/ 224:
/***/ (function(module, exports) {

myApp.controller('CommentFeedController', ['$scope', '$http', 'AuthJS', '$routeParams', '$route', '$location', function ($scope, $http, AuthJS, $routeParams, $route, $location) {

	var urlUser = baseUrl + 'api/client/user';

	var urlCommentFeed = 'api/client/comment_feed/' + $routeParams.param;

	var urlDoLike = baseUrl + 'api/client/like';

	var urlDoDislike = baseUrl + 'api/client/dislike';

	var urlDoComment = baseUrl + 'api/client/comment';

	var urlAddFollow = baseUrl + 'api/client/addFollow';
	var urlRemoveFollow = baseUrl + 'api/client/removeFollow';

	var urlAcceptAnswerFeed = baseUrl + 'api/client/accept_answer_feed';
	var urlRemoveAcceptAnswerFeed = baseUrl + 'api/client/remove_accept_answer_feed';

	var urlLockFeed = baseUrl + 'api/client/lock_feed';
	var urlRemoveFeed = baseUrl + 'api/client/remove_feed';
	var urlEditFeed = baseUrl + 'api/client/edit_feed';

	var urlCateQuestion = baseUrl + 'api/client/catequestion';
	var urlSubCateQuestion = baseUrl + 'api/client/subcatequestion';

	var token = AuthJS.getToken();

	if (!token) {
		$location.path('/login');
	}

	$http({
		headers: {
			'Content-Type': 'application/json',
			'Authorization': 'Bearer ' + token
		},
		method: 'GET',
		url: urlUser,
		data: {}
	}).then(function (response) {
		$scope.user = response.data.user;
	}, function () {});

	$http({
		headers: {
			'Content-Type': 'application/json',
			'Authorization': 'Bearer ' + token
		},
		method: 'GET',
		url: urlCommentFeed,
		data: {}
	}).then(function (response) {
		$scope.getUser = response.data.getUser;
		$scope.feed = response.data.feed;
		$scope.subcatequestion = response.data.feed.sub_cate_question.cate_question.sub_cate_question;
		$scope.title_question = response.data.feed.name;
		$scope.content_question = response.data.feed.content;
		$scope.comment_feeds = response.data.comment_feeds;
		$scope.total_comments = response.data.total_comments;

		if ($scope.feed.status != 1) {
			$('.hidden_status').css('display', 'none');
		}

		$scope.loadScroll();
	}, function () {});

	$scope.doRemoveFollow = function (formRemoveFollow) {

		getUsername = formRemoveFollow.inputUsername.$$attr.value;

		$http({
			headers: {
				'Content-Type': 'application/json',
				'Authorization': 'Bearer ' + token
			},
			method: 'POST',
			url: urlRemoveFollow,
			data: {
				username: getUsername
			}
		}).then(function (response) {

			if (response.data.success) {

				$route.reload();
			} else {}
		}, function () {});
	};

	$scope.doAddFollow = function (formAddFollow) {

		getUsername = formAddFollow.inputUsername.$$attr.value;

		$http({
			headers: {
				'Content-Type': 'application/json',
				'Authorization': 'Bearer ' + token
			},
			method: 'POST',
			url: urlAddFollow,
			data: {
				username: getUsername
			}
		}).then(function (response) {

			if (response.data.success) {
				$route.reload();
			} else {}
		}, function () {});
	};

	$scope.doLike = function (status) {
		$http({
			headers: {
				'Content-Type': 'application/json',
				'Authorization': 'Bearer ' + token
			},
			method: 'POST',
			url: urlDoLike,
			data: {
				slug_feed: status.slug.$$attr.value
			}
		}).then(function (response) {
			$route.reload();
		}, function () {});
	};

	$scope.doDislike = function (status) {
		$http({
			headers: {
				'Content-Type': 'application/json',
				'Authorization': 'Bearer ' + token
			},
			method: 'POST',
			url: urlDoDislike,
			data: {
				slug_feed: status.slug.$$attr.value
			}
		}).then(function (response) {
			$route.reload();
		}, function () {});
	};

	$scope.doComment = function (status) {

		$http({
			headers: {
				'Content-Type': 'application/json',
				'Authorization': 'Bearer ' + token
			},
			method: 'POST',
			url: urlDoComment,
			data: {
				slug_feed: status.slug.$$attr.value,
				comment_content: status.comment.$viewValue,
				comment_image: $scope.dataImageComment
			}
		}).then(function (response) {
			$route.reload();
		}, function () {});
	};

	$scope.focus_comment = function () {
		$('.focus-comment').focus();
	};
	$scope.doShare = function () {
		alert('Chức năng đang được cập nhật');
	};

	$scope.loadScroll = function () {
		$(window).scroll(function () {
			if ($(window).scrollTop() == $(document).height() - $(window).height()) {

				if ($scope.comment_feeds.next_page_url != null) {
					$scope.load_more_comment_feeds = true;
					$http({
						headers: {
							'Content-Type': 'application/json',
							'Authorization': 'Bearer ' + token
						},
						method: 'GET',
						url: $scope.comment_feeds.next_page_url,
						data: {}
					}).then(function (response) {

						var count = 0;
						angular.forEach(response.data.comment_feeds.data, function (value, key) {
							angular.forEach($scope.comment_feeds.data, function (value_scope, key_scope) {
								if (value_scope.id == value.id) {
									count++;
								}
							});
							if (count == 0) {
								$scope.comment_feeds.data.push(value);
							}
						});
						$scope.comment_feeds.next_page_url = response.data.comment_feeds.next_page_url;
						$scope.load_more_comment_feeds = false;
					}, function () {});
				}
			}
		});
	};

	var fileInput = $(".input-file"),
	    button = document.querySelector(".input-file-trigger"),
	    the_return = document.querySelector(".file-return");

	button.addEventListener("keydown", function (event) {
		if (event.keyCode == 13 || event.keyCode == 32) {
			fileInput.focus();
		}
	});

	button.addEventListener("click", function (event) {
		fileInput.focus();
		return false;
	});

	$scope.dataImageComment = null;

	fileInput.change(function (event) {
		the_return.innerHTML = this.value;
		if (this.files[0]) {
			var fileReader = new FileReader();
			fileReader.readAsDataURL(this.files[0]);
			fileReader.onload = function (e) {
				var dataImage = e.target.result;

				var newImage = document.createElement('img');
				newImage.src = dataImage;

				document.getElementById("imgComment").innerHTML = newImage.outerHTML;

				$('#imgComment img').css('max-width', '200px');
				$('.remove-add-image').css('display', 'inline');

				$scope.dataImageComment = dataImage;
			};
		} else {
			$scope.dataImageComment = null;
			$('#imgComment img').remove();
		}
	});

	$scope.removeImageData = function () {
		$scope.dataImageComment = null;
		$('#imgComment img').remove();
		$('.file-return').html('');
		$('.remove-add-image').css('display', 'none');
	};

	$scope.edit_comment_feed = function (event) {
		$('.showQuestionForm').css('display', 'inline-block');
	};

	$http.get(urlCateQuestion).then(function (response) {
		$scope.catequestion = response.data;
	}, function (response) {});

	$scope.select_cate_fun = function () {
		$scope.subcatequestion = null;
		$scope.select_subcate = null;
		var urlCateGetFeeds = urlCateQuestion + '/' + $scope.select_cate;
		$http.get(urlCateGetFeeds).then(function (response) {
			$scope.subcatequestion = response.data.subcatequestion;
		}, function (response) {});
	};

	$scope.editQuestionFun = function (event) {
		console.log($scope.select_subcate);
		var slug = $routeParams.param;
		$http({
			headers: {
				'Content-Type': 'application/json',
				'Authorization': 'Bearer ' + token
			},
			method: 'POST',
			url: urlEditFeed,
			data: {
				feed_slug: slug,
				cate: $scope.select_cate,
				subcate: $scope.select_subcate,
				title: $scope.title_question,
				content: $scope.content_question,
				imageData: $scope.dataImageQuestion
			}
		}).then(function (response) {
			console.log(response);

			if (response.data.success) {
				$route.reload();
			} else {
				alert(response.data.error);
			}
		}, function () {
			// alert("Lỗi")
		});
	};

	$scope.remove_comment_feed = function (event) {

		var slug = event;
		$http({
			headers: {
				'Content-Type': 'application/json',
				'Authorization': 'Bearer ' + token
			},
			method: 'POST',
			url: urlRemoveFeed,
			data: {
				feed_slug: slug
			}
		}).then(function (response) {
			if (response.data.success) {
				$location.path('/social-learning');
			} else {
				alert(response.data.error);
			}
		}, function () {
			alert("Lỗi");
		});
	};

	$scope.lock_feed = function (event) {
		var slug = event.currentTarget.name;
		$http({
			headers: {
				'Content-Type': 'application/json',
				'Authorization': 'Bearer ' + token
			},
			method: 'POST',
			url: urlLockFeed,
			data: {
				feed_slug: slug
			}
		}).then(function (response) {
			if (response.data.success) {
				$route.reload();
			} else {
				alert(response.data.error);
			}
		}, function () {
			alert("Lỗi");
		});
	};

	$scope.accept_ans = function (event) {
		var id = event.currentTarget.id;
		$http({
			headers: {
				'Content-Type': 'application/json',
				'Authorization': 'Bearer ' + token
			},
			method: 'POST',
			url: urlAcceptAnswerFeed,
			data: {
				comment_id: id
			}
		}).then(function (response) {
			if (response.data.success) {
				$route.reload();
			} else {
				alert(response.data.error);
			}
		}, function () {
			alert("Lỗi");
		});
	};

	$scope.remove_accept_ans = function (event) {
		var id = event.currentTarget.id;
		$http({
			headers: {
				'Content-Type': 'application/json',
				'Authorization': 'Bearer ' + token
			},
			method: 'POST',
			url: urlRemoveAcceptAnswerFeed,
			data: {
				comment_id: id
			}
		}).then(function (response) {
			if (response.data.success) {
				$route.reload();
			} else {
				alert(response.data.error);
			}
		}, function () {
			alert("Lỗi");
		});
	};

	$scope.cancel_form_add = function () {
		$('.showQuestionForm').css('display', 'none');
	};

	$scope.zoom = true;
	$scope.cancel_resize_add = function () {
		if ($scope.zoom) {
			$('.showQuestionForm').css('top', '20%');
			$scope.zoom = false;
		} else {
			$('.showQuestionForm').css('top', "");
			$scope.zoom = true;
		}
	};
	$scope.minify = true;
	$scope.cancel_minify_add = function () {
		if ($scope.minify) {
			$('.showQuestionForm').css('top', '90%');
			$scope.minify = false;
		} else {
			$('.showQuestionForm').css('top', "");
			$scope.minify = true;
		}
	};

	var fileInput = $(".input-file"),
	    button = document.querySelector(".input-file-trigger"),
	    the_return = document.querySelector(".file-return");

	button.addEventListener("keydown", function (event) {
		if (event.keyCode == 13 || event.keyCode == 32) {
			fileInput.focus();
		}
	});

	button.addEventListener("click", function (event) {
		fileInput.focus();
		return false;
	});

	$scope.dataImageQuestion = null;

	fileInput.change(function (event) {

		the_return.innerHTML = this.value;
		if (this.files[0]) {
			var fileReader = new FileReader();
			fileReader.readAsDataURL(this.files[0]);
			fileReader.onload = function (e) {
				var dataImage = e.target.result;

				var newImage = document.createElement('img');
				newImage.src = dataImage;

				document.getElementById("imgQuestion").innerHTML = newImage.outerHTML;

				$('#imgQuestion img').css('max-width', '200px');
				$('.remove-add-image').css('display', 'inline');

				$scope.dataImageQuestion = dataImage;
			};
		} else {
			$scope.dataImageQuestion = null;
			$('#imgQuestion img').remove();
		}
	});

	$scope.removeImageData = function () {
		$scope.dataImageQuestion = null;
		$('#imgQuestion img').remove();
		$('.file-return').html('');
		$('.remove-add-image').css('display', 'none');
	};
}]);

/***/ }),

/***/ 225:
/***/ (function(module, exports) {

myApp.controller('FriendshipController', ['$scope', '$http', 'AuthJS', '$routeParams', '$route', '$location', function ($scope, $http, AuthJS, $routeParams, $route, $location) {
	var token = AuthJS.getToken();

	var urlUser = baseUrl + 'api/client/user';
	var urlFollowers = baseUrl + 'api/client/followers';

	var urlAddFollow = baseUrl + 'api/client/addFollow';
	var urlRemoveFollow = baseUrl + 'api/client/removeFollow';
	var urlFollowing = baseUrl + 'api/client/following';

	if (!token) {
		alert('Bạn cần đăng nhập để sử dụng tính năng này');
		$location.path('/login');
	}

	$http({
		headers: {
			'Content-Type': 'application/json',
			'Authorization': 'Bearer ' + token
		},
		method: 'GET',
		url: urlUser,
		data: {}
	}).then(function (response) {
		$scope.user = response.data.user;
	}, function () {
		$('#logout-click').click();
	});

	$http({
		headers: {
			'Content-Type': 'application/json',
			'Authorization': 'Bearer ' + token
		},
		method: 'POST',
		url: urlFollowing,
		data: {}
	}).then(function (response) {
		$scope.followings = response.data.followings;
		$scope.followers = response.data.followers;
		$scope.users = response.data.users;
	}, function () {});

	$scope.doRemoveFollow = function (formRemoveFollow) {

		if ($routeParams.param) {
			getUsername = $routeParams.param;
		} else {
			getUsername = formRemoveFollow.inputUsername.$$attr.value;
		}
		$http({
			headers: {
				'Content-Type': 'application/json',
				'Authorization': 'Bearer ' + token
			},
			method: 'POST',
			url: urlRemoveFollow,
			data: {
				username: getUsername
			}
		}).then(function (response) {

			if (response.data.success) {

				$route.reload();
			} else {}
		}, function () {});
	};

	$scope.doAddFollow = function (formAddFollow) {

		if ($routeParams.param) {
			getUsername = $routeParams.param;
		} else {
			getUsername = formAddFollow.inputUsername.$$attr.value;
		}

		$http({
			headers: {
				'Content-Type': 'application/json',
				'Authorization': 'Bearer ' + token
			},
			method: 'POST',
			url: urlAddFollow,
			data: {
				username: getUsername
			}
		}).then(function (response) {

			if (response.data.success) {
				$route.reload();
			} else {}
		}, function () {});
	};

	$scope.doSearch = function (search) {
		$http({
			headers: {
				'Content-Type': 'application/json',
				'Authorization': 'Bearer ' + token
			},
			method: 'POST',
			url: urlFollowing,
			data: {
				search_user: search
			}
		}).then(function (response) {
			$scope.followers = response.data.followers;
			$scope.followings = response.data.followings;
			$scope.users = response.data.users;
			$scope.show_followers_model = false;
		}, function () {});
	};

	$scope.show_followers = function () {

		$scope.show_followers_model = true;
		$scope.users = false;

		$http({
			headers: {
				'Content-Type': 'application/json',
				'Authorization': 'Bearer ' + token
			},
			method: 'POST',
			url: urlFollowers,
			data: {}
		}).then(function (response) {
			$scope.show_followers_model = response.data.followers;
		});
	};
}]).filter('check_following', function () {
	return function (list_following, current_user_id) {
		var status = false;
		var going = true;
		angular.forEach(list_following, function (friendship, key) {
			if (going) {
				if (friendship.id == current_user_id) {
					status = true;
					going = false;
				}
			}
		});
		return status;
	};
});

/***/ }),

/***/ 226:
/***/ (function(module, exports) {

myApp.controller('HomeController', ['$scope', '$http', 'AuthJS', function ($scope, $http, AuthJS) {
	var url = baseUrl + 'api/client/posts';
	var urlGetRank = baseUrl + 'api/client/getRank';

	$http.get(url).then(function (response) {
		$scope.featurePosts = response.data.featurePosts;
		$scope.posts = response.data.posts;

		$scope.loadScroll();
	}, function (response) {});

	var token = AuthJS.getToken();

	if (token) {
		$http({
			headers: {
				'Content-Type': 'application/json',
				'Authorization': 'Bearer ' + token
			},
			method: 'GET',
			url: urlGetRank,
			data: {}
		}).then(function (response) {

			$scope.users_sort = response.data.users_sort;
			if (response.data.current_rank) {
				$scope.current_rank = response.data.current_rank;
			} else if (response.data.current_rank_status) {
				$scope.current_rank_status = response.data.current_rank_status;
			}
		});
	}

	$scope.loadScroll = function () {
		$(window).scroll(function () {
			if ($(window).scrollTop() == $(document).height() - $(window).height()) {

				if ($scope.posts.next_page_url != null) {
					$scope.loading_more_home = true;

					$http({
						headers: {
							'Content-Type': 'application/json'
						},
						method: 'GET',
						url: $scope.posts.next_page_url,
						data: {}
					}).then(function (response) {
						var count = 0;
						angular.forEach(response.data.posts.data, function (value, key) {
							angular.forEach($scope.posts.data, function (value_scope, key_scope) {
								if (value_scope.slug == value.slug) {
									count++;
								}
							});
							if (count == 0) {
								$scope.posts.data.push(value);
							}
						});
						$scope.posts.next_page_url = response.data.posts.next_page_url;
						$scope.loading_more_home = false;
					}, function () {});
				}
			}
		});
	};
}]);

/***/ }),

/***/ 227:
/***/ (function(module, exports) {

myApp.controller('LoginController', ['$scope', '$http', '$window', 'AuthJS', '$location', function ($scope, $http, $window, AuthJS, $location) {

	if (AuthJS.getToken()) {
		$location.path('/');
	}

	$scope.doLogin = function (loginForm) {

		var url = baseUrl + 'login';
		$scope.wrong_account = false;
		$scope.wrong_info = false;

		$http({
			headers: {
				'Content-Type': 'application/json'
			},
			method: 'POST',
			url: url,
			data: {
				login: $scope.login,
				password: $scope.password
			}
		}).then(function (response) {

			if (response.data.wrong_info) {
				$scope.wrong_info = response.data.wrong_info;
			} else if (response.data.wrong_account) {
				$scope.wrong_account = response.data.wrong_account;
			} else if (response.data.token) {
				localStorage.setItem('token', response.data.token);
				$window.location.href = '/';
			} else {
				$window.location.href = '/login';
			}
		}, function errorCallback(response) {
			// $window.location.href= '/login'
		});
	};

	$scope.goForgot = function () {
		$window.location.href = '/password/reset';
	};
}]);

/***/ }),

/***/ 228:
/***/ (function(module, exports) {

myApp.controller('PostController', ['$scope', '$http', '$routeParams', '$sce', 'AuthJS', '$route', '$location', function ($scope, $http, $routeParams, $sce, AuthJS, $route, $location) {

	var urlPost = baseUrl + 'api/client/' + $routeParams.param1 + '/' + $routeParams.param2;
	var urlComment = baseUrl + 'api/client/comment/' + $routeParams.param2;
	var urlUser = baseUrl + 'api/client/user';

	$http.get(urlPost).then(function (response) {

		$scope.post = response.data.post;
		$scope.testonline = response.data.testonline;
		$scope.same_posts = response.data.same_posts;
		$scope.content = $sce.trustAsHtml(response.data.post.content);
	}, function (response) {
		$location.path('/');
	});

	var token = AuthJS.getToken();

	if (token) {
		$http({
			headers: {
				'Content-Type': 'application/json',
				'Authorization': 'Bearer ' + token
			},
			method: 'GET',
			url: urlUser,
			data: {}
		}).then(function (response) {
			$scope.user = response.data.user;
		}, function () {
			$('#logout-click').click();
		});

		$http({
			headers: {
				'Content-Type': 'application/json',
				'Authorization': 'Bearer ' + token
			},
			method: 'GET',
			url: urlComment,
			data: {}
		}).then(function (response) {
			$scope.comments = response.data.comments;

			$scope.loadScroll();
		}, function () {});

		$scope.loadScroll = function () {

			$(window).scroll(function () {
				if ($(window).scrollTop() == $(document).height() - $(window).height()) {

					if ($scope.comments.next_page_url != null) {
						$scope.loading_more_comment = true;

						$http({
							headers: {
								'Content-Type': 'application/json',
								'Authorization': 'Bearer ' + token
							},
							method: 'GET',
							url: $scope.comments.next_page_url,
							data: {}
						}).then(function (response) {

							var count = 0;

							angular.forEach(response.data.comments.data, function (value, key) {
								angular.forEach($scope.comments.data, function (value_scope, key_scope) {
									if (value_scope.id == value.id) {
										count++;
									}
								});
								if (count == 0) {
									$scope.comments.data.push(value);
								}
							});
							$scope.comments.next_page_url = response.data.comments.next_page_url;

							$scope.loading_more_comment = false;
						}, function () {});
					}
				}
			});
		};

		$scope.wrong_comment = false;
		$scope.doComment = function (commentForm) {
			$http({
				headers: {
					'Content-Type': 'application/json',
					'Authorization': 'Bearer ' + token
				},
				method: 'POST',
				url: urlComment,
				data: {
					comment_content: $scope.comment_content
				}
			}).then(function (response) {
				if (response.data.success) {
					$route.reload();
				} else if (response.data.wrong_comment) {
					$scope.wrong_comment = response.data.wrong_comment;
				} else {
					$route.reload();
				}
			}, function () {});
		};
	}
}]);

/***/ }),

/***/ 229:
/***/ (function(module, exports) {

myApp.controller('ProfileController', ['$scope', '$http', '$routeParams', 'AuthJS', '$route', '$window', '$location', function ($scope, $http, $routeParams, AuthJS, $route, $window, $location) {

	var urlUser = baseUrl + 'api/client/user';

	var urlGetUser = baseUrl + 'api/client/getUser/' + $routeParams.param;

	var urlDoLike = baseUrl + 'api/client/like';

	var urlDoDislike = baseUrl + 'api/client/dislike';

	var urlDoComment = baseUrl + 'api/client/comment';

	var token = AuthJS.getToken();

	if (!token) {
		alert('Bạn cần đăng nhập để sử dụng tính năng này');
		$location.path('/login');
	}

	$http({
		headers: {
			'Content-Type': 'application/json',
			'Authorization': 'Bearer ' + token
		},
		method: 'GET',
		url: urlUser,
		data: {}
	}).then(function (response) {
		$scope.user = response.data.user;
	}, function () {
		$('#logout-click').click();
	});

	$http({
		headers: {
			'Content-Type': 'application/json',
			'Authorization': 'Bearer ' + token
		},
		method: 'GET',
		url: urlGetUser,
		data: {}
	}).then(function (response) {
		$scope.getUser = response.data.getUser;
		$scope.max_points = response.data.max_points;
		$scope.feeds = response.data.feeds;
		console.log($scope.getUser);
		$scope.loadScroll();
	}, function () {
		$location.path('/');
	});

	$scope.loadScroll = function () {
		$(window).scroll(function () {
			if ($(window).scrollTop() == $(document).height() - $(window).height()) {

				if ($scope.feeds.next_page_url != null) {
					$scope.loading_more_status = true;
					$http({
						headers: {
							'Content-Type': 'application/json',
							'Authorization': 'Bearer ' + token
						},
						method: 'GET',
						url: $scope.feeds.next_page_url,
						data: {}
					}).then(function (response) {

						var count = 0;
						angular.forEach(response.data.feeds.data, function (value, key) {
							angular.forEach($scope.feeds.data, function (value_scope, key_scope) {
								if (value_scope.slug == value.slug) {
									count++;
								}
							});
							if (count == 0) {
								$scope.feeds.data.push(value);
							}
						});
						$scope.feeds.next_page_url = response.data.feeds.next_page_url;
						$scope.loading_more_status = false;
					}, function () {});
				}
			}
		});
	};

	$scope.doLike = function (status) {
		$http({
			headers: {
				'Content-Type': 'application/json',
				'Authorization': 'Bearer ' + token
			},
			method: 'POST',
			url: urlDoLike,
			data: {
				slug_feed: status.slug.$$attr.value
			}
		}).then(function (response) {
			$route.reload();
		}, function () {});
	};

	$scope.doDislike = function (status) {
		$http({
			headers: {
				'Content-Type': 'application/json',
				'Authorization': 'Bearer ' + token
			},
			method: 'POST',
			url: urlDoDislike,
			data: {
				slug_feed: status.slug.$$attr.value
			}
		}).then(function (response) {
			$route.reload();
		}, function () {});
	};

	$scope.doComment = function (status) {

		$http({
			headers: {
				'Content-Type': 'application/json',
				'Authorization': 'Bearer ' + token
			},
			method: 'POST',
			url: urlDoComment,
			data: {
				slug_feed: status.slug.$$attr.value,
				comment_content: status.comment.$viewValue
			}
		}).then(function (response) {

			$window.location.href = '/comment_feed/' + status.slug.$$attr.value;
		}, function () {});
	};

	$scope.doShare = function (status) {
		alert('Chức năng chưa được cập nhật!');
	};
}]).filter('check_like_feed', function () {
	return function (list_like_feed, current_user_id) {
		var status = false;
		var going = true;
		angular.forEach(list_like_feed, function (like_feed, key) {
			if (going) {
				if (like_feed.id_user == current_user_id) {
					status = true;
					going = false;
				}
			}
		});
		return status;
	};
});

/***/ }),

/***/ 230:
/***/ (function(module, exports) {

myApp.controller('RegisterController', ['$scope', '$http', '$window', 'AuthJS', '$location', function ($scope, $http, $window, AuthJS, $location) {

	if (AuthJS.getToken()) {
		$location.path('/');
	}

	$scope.doRegister = function (registerForm) {
		var url = baseUrl + 'api/client/register';
		$scope.wrong_form = false;
		$scope.wrong_name = false;
		$scope.wrong_username = false;
		$scope.wrong_email = false;
		$scope.wrong_password = false;
		$scope.wrong_gender = false;

		$http({

			method: 'POST',
			url: url,
			data: {
				name: $scope.name,
				username: $scope.username,
				email: $scope.email,
				password: $scope.password,
				repassword: $scope.repassword,
				gender: $scope.gender
			}
		}).then(function (response) {
			if (response.data.wrong_form) {
				$scope.wrong_form = response.data.wrong_form;
			} else if (response.data.wrong_name) {
				$scope.wrong_name = response.data.wrong_name;
			} else if (response.data.wrong_username) {
				$scope.wrong_username = response.data.wrong_username;
			} else if (response.data.wrong_email) {
				$scope.wrong_email = response.data.wrong_email;
			} else if (response.data.wrong_password) {
				$scope.wrong_password = response.data.wrong_password;
			} else if (response.data.wrong_gender) {
				$scope.wrong_gender = response.data.wrong_gender;
			} else if (response.data.success) {
				$window.alert(response.data.success);
				$window.location.href = '/login';
			} else {
				$window.location.href = '/';
			}
		}, function (response) {
			$window.location.href = '/';
		});
	};
}]);

/***/ }),

/***/ 231:
/***/ (function(module, exports) {

myApp.controller('SearchPostController', ['$scope', '$http', '$route', function ($scope, $http, $route) {

	var urlSearchPost = baseUrl + 'api/client/searchPost';

	$scope.doSearch = function (searchPost) {

		$http({
			headers: {
				'Content-Type': 'application/json'
			},
			method: 'POST',
			url: urlSearchPost,
			data: {
				keyword: $scope.searchPost
			}
		}).then(function (response) {

			$scope.posts = response.data.posts;

			$scope.loadScroll();
		}, function () {});
	};

	$scope.loadScroll = function () {
		$(window).scroll(function () {
			if ($(window).scrollTop() == $(document).height() - $(window).height()) {

				if ($scope.posts.next_page_url != null) {
					$scope.loading_more_search_post = true;

					$http({
						headers: {
							'Content-Type': 'application/json'
						},
						method: 'POST',
						url: $scope.posts.next_page_url,
						data: {
							keyword: $scope.searchPost
						}
					}).then(function (response) {
						var count = 0;
						angular.forEach(response.data.posts.data, function (value, key) {
							angular.forEach($scope.posts.data, function (value_scope, key_scope) {
								if (value_scope.id == value.id) {
									count++;
								}
							});
							if (count == 0) {
								$scope.posts.data.push(value);
							}
						});

						$scope.posts.next_page_url = response.data.posts.next_page_url;
						$scope.loading_more_search_post = false;
					}, function (response) {});
				}
			}
		});
	};
}]);

/***/ }),

/***/ 232:
/***/ (function(module, exports) {

myApp.controller('SettingController', ['$scope', '$http', '$route', 'AuthJS', '$location', function ($scope, $http, $route, AuthJS, $location) {

	var token = AuthJS.getToken();
	var urlUser = baseUrl + 'api/client/user';

	var urlSettingName = baseUrl + 'api/client/settingName';
	var urlSettingInfo = baseUrl + 'api/client/settingInfo';
	var urlSettingAvatar = baseUrl + 'api/client/settingAvatar';
	var urlSettingPassword = baseUrl + 'api/client/settingPassword';

	if (!token) {
		$location.path('/');
	}

	$http({
		headers: {
			'Content-Type': 'application/json',
			'Authorization': 'Bearer ' + token
		},
		method: 'GET',
		url: urlUser,
		data: {}
	}).then(function (response) {
		$scope.user = response.data.user;
	}, function () {
		$location.path('/');
	});

	$scope.doSettingName = function (formSettingName) {
		$http({
			headers: {
				'Content-Type': 'application/json',
				'Authorization': 'Bearer ' + token
			},
			method: 'POST',
			url: urlSettingName,
			data: {
				name: formSettingName.name.$viewValue
			}
		}).then(function (response) {

			if (response.data.success) {
				// $route.reload()
				$location.path('/setting');
			}
		}, function () {
			$location.path('/setting');
		});
	};

	$scope.doSettingInfo = function (formSettingInfo) {
		$http({
			headers: {
				'Content-Type': 'application/json',
				'Authorization': 'Bearer ' + token
			},
			method: 'POST',
			url: urlSettingInfo,
			data: {
				info: formSettingInfo.info.$viewValue
			}
		}).then(function (response) {

			if (response.data.success) {
				$location.path('/setting');
			}
		}, function () {});
	};

	$scope.doSettingPassword = function (formSettingPassword) {

		var pwd = $scope.password;
		var re_pwd = $scope.password_confirmation;

		if (pwd != re_pwd) {
			$scope.wrong_password = 'Xác nhận mật khẩu không đúng';
		} else {
			$http({
				headers: {
					'Content-Type': 'application/json',
					'Authorization': 'Bearer ' + token
				},
				method: 'POST',
				url: urlSettingPassword,
				data: {
					cur_pwd: $scope.old_password,
					new_pwd: pwd
				}
			}).then(function (response) {
				if (response.data.wrong_old_password) {
					$scope.wrong_old_password = 'Mật khẩu hiện tại không đúng';
				} else {
					$location.path('/setting');
				}
			}, function () {});
		}
	};

	$scope.doSettingAvatar = function (formSettingAvatar) {

		var fileReader = new FileReader();
		fileReader.readAsDataURL(document.getElementById('image').files[0]);
		fileReader.onload = function (e) {
			var dataImage = e.target.result;
			$http({
				headers: {
					'Content-Type': 'application/json',
					'Authorization': 'Bearer ' + token
				},
				method: 'POST',
				url: urlSettingAvatar,
				data: {
					avatar: dataImage
				}
			}).then(function (response) {
				if (response.data.success) {
					$location.path('/setting');
				}
			}, function () {});
		};
	};
}]);

/***/ }),

/***/ 233:
/***/ (function(module, exports) {

myApp.controller('SocialLearningController', ['$scope', '$http', '$routeParams', '$location', '$route', '$window', 'AuthJS', '$mdDialog', function ($scope, $http, $routeParams, $location, $route, $window, AuthJS, $mdDialog) {

	var urlCateQuestion = baseUrl + 'api/client/catequestion';
	var urlSubCateQuestion = baseUrl + 'api/client/subcatequestion';
	var urlGetFeeds = baseUrl + 'api/client/comment_feed';
	var urlPostFeed = baseUrl + 'api/client/postFeed';

	var token = AuthJS.getToken();
	var urlUser = baseUrl + 'api/client/user';

	if (token) {
		$http({
			headers: {
				'Content-Type': 'application/json',
				'Authorization': 'Bearer ' + token
			},
			method: 'GET',
			url: urlUser,
			data: {}
		}).then(function (response) {
			$scope.user = response.data.user;
		}, function () {
			$('#logout-click').click();
		});
	}

	$http.get(urlCateQuestion).then(function (response) {
		$scope.catequestion = response.data;

		angular.forEach($scope.catequestion, function (value, key) {

			value['color'] = $scope.getColor();
		});
	}, function (response) {
		$location.path('/');
	});

	if (!$routeParams.param1) {

		// load full

		$http.get(urlGetFeeds, { params: { sort_key: $location.search().sort } }).then(function (response) {
			$scope.feeds = response.data.feeds;
		}, function (response) {
			// $location.path('/')
		});
	} else {

		if (!$routeParams.param2) {
			// load cate
			var urlCateGetFeeds = urlCateQuestion + '/' + $routeParams.param1;
			$http.get(urlCateGetFeeds, { params: { sort_key: $location.search().sort } }).then(function (response) {
				$scope.feeds = response.data.feeds;
				$('#belong-cate-' + $routeParams.param1).css('display', 'block');
			}, function (response) {
				// $location.path('/')
			});
		} else {

			// load subcate

			var urlSubCateGetFeeds = urlSubCateQuestion + '/' + $routeParams.param2;
			$http.get(urlSubCateGetFeeds, { params: { sort_key: $location.search().sort } }).then(function (response) {
				$scope.feeds = response.data.feeds;
				$('#belong-cate-' + $routeParams.param1).css('display', 'block');
			}, function (response) {
				// $location.path('/')
			});
		}
	}

	$scope.addQuestion = function () {
		if ($scope.user) {
			$('.showQuestionForm').css('display', 'inline-block');
		} else {
			alert('Bạn cần đăng nhập');
		}
	};

	if ($location.search().sort) {
		$scope.sort_by = $location.search().sort;
	}

	$scope.sort_custom = function () {
		$window.location.href = $location.path() + '?sort=' + $scope.sort_by;
	};

	$scope.doRefresh = function () {
		$route.reload();
	};

	$scope.getColor = function () {

		return '#' + Math.random().toString(16).slice(2, 8);
	};
	$scope.color1 = $scope.getColor();
	$scope.color2 = $scope.getColor();

	$scope.select_cate_fun = function () {
		$scope.subcatequestion = null;
		var urlCateGetFeeds = urlCateQuestion + '/' + $scope.select_cate;
		$http.get(urlCateGetFeeds).then(function (response) {
			$scope.subcatequestion = response.data.subcatequestion;
			$('.div_select_subcate').css('display', 'inline');
		}, function (response) {
			$location.path('/');
		});
	};

	$scope.cancel_form_add = function () {
		$('.showQuestionForm').css('display', 'none');
	};

	$scope.zoom = true;
	$scope.cancel_resize_add = function () {
		if ($scope.zoom) {
			$('.showQuestionForm').css('top', '20%');
			$scope.zoom = false;
		} else {
			$('.showQuestionForm').css('top', "");
			$scope.zoom = true;
		}
	};
	$scope.minify = true;
	$scope.cancel_minify_add = function () {
		if ($scope.minify) {
			$('.showQuestionForm').css('top', '90%');
			$scope.minify = false;
		} else {
			$('.showQuestionForm').css('top', "");
			$scope.minify = true;
		}
	};

	var fileInput = $(".input-file"),
	    button = document.querySelector(".input-file-trigger"),
	    the_return = document.querySelector(".file-return");

	button.addEventListener("keydown", function (event) {
		if (event.keyCode == 13 || event.keyCode == 32) {
			fileInput.focus();
		}
	});

	button.addEventListener("click", function (event) {
		fileInput.focus();
		return false;
	});

	$scope.dataImageQuestion = null;

	fileInput.change(function (event) {
		the_return.innerHTML = this.value;
		if (this.files[0]) {
			var fileReader = new FileReader();
			fileReader.readAsDataURL(this.files[0]);
			fileReader.onload = function (e) {
				var dataImage = e.target.result;

				var newImage = document.createElement('img');
				newImage.src = dataImage;

				document.getElementById("imgQuestion").innerHTML = newImage.outerHTML;

				$('#imgQuestion img').css('max-width', '200px');
				$('.remove-add-image').css('display', 'inline');

				$scope.dataImageQuestion = dataImage;
			};
		} else {
			$scope.dataImageQuestion = null;
			$('#imgQuestion img').remove();
		}
	});

	$scope.removeImageData = function () {
		$scope.dataImageQuestion = null;
		$('#imgQuestion img').remove();
		$('.file-return').html('');
		$('.remove-add-image').css('display', 'none');
	};

	$scope.addQuestionFun = function () {

		if ($scope.select_cate && $scope.select_subcate && $scope.title_question && $scope.content_question && $scope.point_set) {
			$http({
				headers: {
					'Content-Type': 'application/json',
					'Authorization': 'Bearer ' + token
				},
				method: 'POST',
				url: urlPostFeed,
				data: {
					cate: $scope.select_cate,
					subcate: $scope.select_subcate,
					title: $scope.title_question,
					content: $scope.content_question,
					imageData: $scope.dataImageQuestion,
					point_set: $scope.point_set
				}
			}).then(function (response) {

				if (response.data.error) {
					alert(response.data.error);
				} else {
					alert(response.data.success);
					$route.reload();
				}
			}, function () {

				alert('Lỗi');
			});
		} else {
			alert('Cần điền đủ thông tin');
		}
	};

	$scope.goTo = function (e) {

		if (e.currentTarget.value > 0 && e.currentTarget.value <= $scope.feeds.last_page) {
			var urlGoTo = $scope.feeds.path + "?page=" + e.currentTarget.value;

			$http.get(urlGoTo, { params: { sort_key: $location.search().sort } }).then(function (response) {
				$scope.feeds = response.data.feeds;
			}, function (response) {});
		}
	};
	$scope.goPrev = function () {

		if ($scope.feeds.prev_page_url) {
			var urlGoPrev = $scope.feeds.prev_page_url;

			$http.get(urlGoPrev, { params: { sort_key: $location.search().sort } }).then(function (response) {
				$scope.feeds = response.data.feeds;
			}, function (response) {});
		}
	};

	$scope.goNext = function () {

		if ($scope.feeds.next_page_url) {
			var urlGoNext = $scope.feeds.next_page_url;

			$http.get(urlGoNext, { params: { sort_key: $location.search().sort } }).then(function (response) {
				$scope.feeds = response.data.feeds;
			}, function (response) {});
		}
	};
}]);

/***/ }),

/***/ 234:
/***/ (function(module, exports) {

myApp.controller('SubCategoryController', ['$scope', '$http', '$routeParams', '$location', function ($scope, $http, $routeParams, $location) {

	var url = baseUrl + 'api/client/subcategory/' + $routeParams.param;

	$http.get(url).then(function (response) {
		$scope.subcategory = response.data.subcategory;
		$scope.posts = response.data.posts;
		$scope.top_posts = response.data.top_posts;

		$scope.loadScroll();
	}, function (response) {
		$location.path('/');
	});

	$scope.loadScroll = function () {
		$(window).scroll(function () {
			if ($(window).scrollTop() == $(document).height() - $(window).height()) {

				if ($scope.posts.next_page_url != null) {
					$scope.loading_more_cate_post = true;

					$http.get($scope.posts.next_page_url).then(function (response) {
						var count = 0;
						angular.forEach(response.data.posts.data, function (value, key) {
							angular.forEach($scope.posts.data, function (value_scope, key_scope) {
								if (value_scope.id == value.id) {
									count++;
								}
							});
							if (count == 0) {
								$scope.posts.data.push(value);
							}
						});

						$scope.posts.next_page_url = response.data.posts.next_page_url;
						$scope.loading_more_cate_post = false;
					}, function (response) {});
				}
			}
		});
	};
}]);

/***/ }),

/***/ 235:
/***/ (function(module, exports) {

myApp.controller('TestOnlineController', ['$scope', '$http', '$routeParams', 'AuthJS', '$interval', '$window', '$location', function ($scope, $http, $routeParams, AuthJS, $interval, $window, $location) {

	var token = AuthJS.getToken();

	var urlUser = baseUrl + 'api/client/user';

	var urlTestOnlineIndex = baseUrl + 'api/client/testonline';
	var urlAjaxAnswer = baseUrl + 'api/client/ajaxanswer';
	var urlSubmitTest = baseUrl + 'api/client/submitTest';

	if (!token) {
		$location.path('/');
	} else {
		$http({
			headers: {
				'Content-Type': 'application/json',
				'Authorization': 'Bearer ' + token
			},
			method: 'POST',
			url: urlTestOnlineIndex,
			data: {
				paramUrl: $routeParams.param
			}
		}).then(function (response) {

			console.log(response);

			if (response.data.wait_start) {
				var count_down = response.data.wait_start;
				$scope.wait_start = true;
				$scope.shutTime(count_down);
			} else if (response.data.wait_end) {
				var _count_down = response.data.wait_end;
				$scope.wait_end = true;
				$scope.shutTime(_count_down);
			} else if (response.data.eliminate) {
				var _count_down2 = response.data.eliminate;
				$scope.eliminate = true;
				$scope.shutTime(_count_down2);
			} else if (response.data.timeSubmitOnline) {
				$scope.bquestions = response.data.bquestions;
				$scope.dataAns = response.data.dataAns;
				$scope.timeSubmitOnline = true;
				var _count_down3 = response.data.timeSubmitOnline;

				$scope.shutTime(_count_down3);
			} else if (response.data.timeSubmitOffline) {

				$scope.bquestions = response.data.bquestions;
				$scope.dataAns = response.data.dataAns;
				$scope.timeSubmitOffline = true;
				var _count_down4 = response.data.timeSubmitOffline;
				$scope.shutTime(_count_down4);
			} else if (response.data.ans_true) {
				$scope.bquestions = response.data.bquestions;
				$scope.dataAns = response.data.dataAns;

				$scope.ans_true = response.data.ans_true;
				$scope.users = response.data.users;
				$scope.points = response.data.points;
				$scope.current_user_rank_status = response.data.current_user_rank_status;
			}
			$scope.post = response.data.post;
		}, function () {
			$location.path('/');
		});
	}

	$scope.doAnswer = function (key, value) {

		$http({
			headers: {
				'Content-Type': 'application/json',
				'Authorization': 'Bearer ' + token
			},
			method: 'POST',
			url: urlAjaxAnswer,
			data: {
				paramUrl: $routeParams.param,
				answerKey: key,
				answerValue: value
			}
		}).then(function (response) {

			if (response.data.timeSubmitOnline) {
				var count_down = response.data.timeSubmitOnline;
				$scope.shutTime(count_down);
			} else if (response.data.timeSubmitOffline) {
				var _count_down5 = response.data.timeSubmitOffline;
				$scope.shutTime(_count_down5);
			}

			$('#answer_' + key).css('color', 'blue');
		}, function (response) {

			$('#answer_' + key).css('color', 'red');
		});
	};
	var intervals = [];
	var location = $location.path();
	$scope.shutTime = function (time) {

		if (intervals.length > 0) {
			$interval.cancel(intervals.pop());
		}
		intervals.push($interval(function () {
			if ($location.path() != location) {
				$interval.cancel(intervals[0]);
			}
			var h = Math.floor(time / 3600);
			var m = Math.floor(time % 3600 / 60);
			var s = Math.floor(time % 3600 % 60);
			time--;
			if (time < 0) {
				$window.location.reload();
			} else {

				var hh = h,
				    mm = m,
				    ss = s;

				if (h < 10) {
					hh = "0" + h;
				}
				if (m < 10) {
					mm = "0" + m;
				}
				if (s < 10) {
					ss = "0" + s;
				}

				$scope.timeCount = hh + ":" + mm + ":" + ss;
			}
		}, 1000));
	};

	$scope.clickSubmit = function () {
		$http({
			headers: {
				'Content-Type': 'application/json',
				'Authorization': 'Bearer ' + token
			},
			method: 'POST',
			url: urlSubmitTest,
			data: {
				paramUrl: $routeParams.param
			}
		}).then(function (response) {
			if (response.data.submit) {
				$window.location.reload();
			}
		});
	};
}]).filter('range', function () {
	return function (input, total) {
		total = parseInt(total);
		for (var i = 0; i < total; i++) {
			input.push(i);
		}return input;
	};
});

/***/ }),

/***/ 236:
/***/ (function(module, exports) {

myApp.service('AuthJS', function () {
	return {
		getToken: function getToken() {
			var token = localStorage.getItem('token');
			return token;
		},
		setToken: function setToken(token) {
			localStorage.setItem('token', token);
		},
		destroyToken: function destroyToken() {
			localStorage.removeItem('token');
		},
		isAuthenticated: function isAuthenticated() {
			if (this.getToken()) {
				return true;
			}
			return false;
		}
	};
});

/***/ }),

/***/ 314:
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(153);
__webpack_require__(155);
__webpack_require__(156);
module.exports = __webpack_require__(154);


/***/ })

/******/ });