myApp.controller('TestOnlineController', ['$scope', '$http', '$routeParams', 'AuthJS', '$interval', '$window', '$location',
	function($scope, $http, $routeParams, AuthJS, $interval, $window, $location) {
	
	let token = AuthJS.getToken()
	
	let urlUser = baseUrl + 'api/client/user'

	let urlTestOnlineIndex = baseUrl + 'api/client/testonline'
	let urlAjaxAnswer = baseUrl + 'api/client/ajaxanswer'
	let urlSubmitTest = baseUrl + 'api/client/submitTest'

	if(!token) {
		$location.path('/')
	} else {
		$http({
			headers: {
				'Content-Type': 'application/json',
				'Authorization': 'Bearer ' + token
			},
			method : 'POST',
			url : urlTestOnlineIndex,
			data: {
				paramUrl: $routeParams.param
			},
		}).then(function(response) {

			console.log(response)

			if(response.data.wait_start) {
				let count_down = response.data.wait_start
				$scope.wait_start = true
				$scope.shutTime(count_down)

			} else if(response.data.wait_end) {
				let count_down = response.data.wait_end
				$scope.wait_end = true
				$scope.shutTime(count_down)

			} else if(response.data.eliminate){
				let count_down = response.data.eliminate
				$scope.eliminate = true
				$scope.shutTime(count_down)

			} else if(response.data.timeSubmitOnline){
				$scope.bquestions = response.data.bquestions
				$scope.dataAns = response.data.dataAns
				$scope.timeSubmitOnline = true
				let count_down = response.data.timeSubmitOnline

				$scope.shutTime(count_down)

			} else if(response.data.timeSubmitOffline) {
				
				$scope.bquestions = response.data.bquestions
				$scope.dataAns = response.data.dataAns
				$scope.timeSubmitOffline = true
				let count_down = response.data.timeSubmitOffline
				$scope.shutTime(count_down)
				
			} else if(response.data.ans_true) {
				$scope.bquestions = response.data.bquestions
				$scope.dataAns = response.data.dataAns

				$scope.ans_true = response.data.ans_true
				$scope.users = response.data.users
				$scope.points = response.data.points
				$scope.current_user_rank_status = response.data.current_user_rank_status
			}
			$scope.post = response.data.post

		}, function() {
			$location.path('/')
		})
	}
	

	$scope.doAnswer = function(key, value) {

		$http({
			headers: {
				'Content-Type': 'application/json',
				'Authorization': 'Bearer ' + token
			},
			method : 'POST',
			url : urlAjaxAnswer,
			data: {
				paramUrl: $routeParams.param,
				answerKey: key,
				answerValue: value
			},
		}).then(function(response) {

			if(response.data.timeSubmitOnline) {
				let count_down = response.data.timeSubmitOnline
				$scope.shutTime(count_down)
			} else if(response.data.timeSubmitOffline) {
				let count_down = response.data.timeSubmitOffline
				$scope.shutTime(count_down)
			}

			$('#answer_'+key).css('color', 'blue')

		}, function(response) {

			$('#answer_'+key).css('color', 'red')

		})
	}
	var intervals = []
	var location = $location.path()
	$scope.shutTime = function(time) {

		if(intervals.length > 0) {
			$interval.cancel(intervals.pop())
		}
		intervals.push($interval(function() {
			if($location.path() != location) {
				$interval.cancel(intervals[0])
			}
			let h = Math.floor(time / 3600)
		    let m = Math.floor(time % 3600 / 60)
		    let s = Math.floor(time % 3600 % 60)
			time --
			if(time < 0) {
				$window.location.reload()
			} else {

				var hh = h, mm = m, ss = s

				if(h < 10) {
					hh = "0" + h
				}
				if(m < 10) {
					mm = "0" + m
				}
				if(s < 10) {
					ss = "0" + s
				}

				$scope.timeCount = hh + ":" + mm + ":" + ss
			}
			
		}, 1000))
	}

	$scope.clickSubmit = function() {
		$http({
			headers: {
				'Content-Type': 'application/json',
				'Authorization': 'Bearer ' + token
			},
			method : 'POST',
			url : urlSubmitTest,
			data: {
				paramUrl: $routeParams.param
			},
		}).then(function(response) {
			if(response.data.submit) {
				$window.location.reload()
			}
		})
	}

}]).filter('range', function() {
  return function(input, total) {
    total = parseInt(total);
    for (var i=0; i<total; i++)
      input.push(i)
    return input
  }
})