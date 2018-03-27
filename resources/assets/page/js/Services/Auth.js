myApp.service('AuthJS', function() {
	return {
		getToken: function() {
			let token = localStorage.getItem('token')
			return token
		},
		setToken: function(token) {
			localStorage.setItem('token', token)
		},
		destroyToken: function() {
			localStorage.removeItem('token')
		},
		isAuthenticated: function() {
			if(this.getToken()) {
				return true
			}
			return false
		}
	}
})