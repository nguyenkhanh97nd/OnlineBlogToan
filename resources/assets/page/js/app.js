$("div.alert").delay(3000).slideUp()

window.baseUrl = 'http://thithu.blogtoan.com/'
window.myApp = angular.module('myApp', ['ngRoute', 'ngSanitize', 'ngMaterial'], function($interpolateProvider) {
	$interpolateProvider.startSymbol('<%kh')
	$interpolateProvider.endSymbol('hk%>')
}).filter('myDateFormat', function myDateFormat($filter){
  return function(text){
    let  tempdate= new Date(text.replace(/-/g,"/"));
    return $filter('date')(tempdate, "dd-MM-yyyy");
  }
})



require('./Services/Auth.js')

require('./Controllers/LoginController.js')
require('./Controllers/RegisterController.js')
require('./Controllers/HomeController.js')
require('./Controllers/CategoryController.js')
require('./Controllers/SubCategoryController.js')
require('./Controllers/PostController.js')
require('./Controllers/TestOnlineController.js')
require('./Controllers/ProfileController.js')
require('./Controllers/FriendshipController.js')
require('./Controllers/SearchPostController.js')
require('./Controllers/SettingController.js')
require('./Controllers/CommentFeedController.js')


require('./Controllers/SocialLearningController.js')

myApp.config(['$routeProvider', '$locationProvider',
	function($routeProvider,$locationProvider) {
		$routeProvider
		.when('/register', {
			templateUrl: 'template/auth/register.html',
			controller: 'RegisterController'
		})
		.when('/login', {
			templateUrl: 'template/auth/login.html',
			controller: 'LoginController'
		})
		.when('/search', {
			templateUrl: 'template/search/search.html',
			controller: 'SearchPostController'
		})	
		.when('/social-learning', {
			templateUrl: 'template/social-learning/index.html',
			controller: 'SocialLearningController'
		})
		.when('/follow', {
			templateUrl: 'template/friend/friend.html',
			controller: 'FriendshipController'
		})
		.when('/setting', {
			templateUrl: 'template/setting/setting.html',
			controller: 'SettingController'
		})
		.when('/setting/name', {
			templateUrl: 'template/setting/name.html',
			controller: 'SettingController'
		})
		.when('/setting/password', {
			templateUrl: 'template/setting/password.html',
			controller: 'SettingController'
		})
		.when('/setting/avatar', {
			templateUrl: 'template/setting/avatar.html',
			controller: 'SettingController'
		})
		.when('/setting/info', {
			templateUrl: 'template/setting/info.html',
			controller: 'SettingController'
		})
		.when('/social-learning/:param1', {
			templateUrl: 'template/social-learning/index.html',
			controller: 'SocialLearningController'
		})
		.when('/social-learning/:param1/:param2', {
			templateUrl: 'template/social-learning/index.html',
			controller: 'SocialLearningController'
		})
		.when('/profile/:param', {
			templateUrl: 'template/profile/user.html',
			controller: 'ProfileController'
		})
		.when('/comment_feed/:param', {
			templateUrl: 'template/comment_feed/comment.html',
			controller: 'CommentFeedController'
		})
		.when('/testonline/:param', {
			templateUrl: 'template/testonline/test.html',
			controller: 'TestOnlineController'
		})
		.when('/:param.html', {
			templateUrl: 'template/category/category.html',
			controller: 'CategoryController'
		})
		.when('/:param', {
			templateUrl: 'template/category/subcategory.html',
			controller: 'SubCategoryController'
		})
		.when('/:param1/:param2', {
			templateUrl: 'template/single/post.html',
			controller: 'PostController'
		})
		.when('/', {
			templateUrl: 'template/index.html',
			controller: 'HomeController'
		})


		$locationProvider.html5Mode(true)
		$locationProvider.hashPrefix('');
	}
])