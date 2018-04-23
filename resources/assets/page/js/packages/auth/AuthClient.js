export default function (Vue) {

	Vue.authjs = {
		setToken(token) {
			localStorage.setItem('token', token)
		},

		getToken() {
			var token = localStorage.getItem('token')
			return token
		},

		destroyToken() {
			localStorage.removeItem('token')
		},

		isAuthenticated() {
			if(this.getToken())
				return true
			else
				return false
		}
	}

	Object.defineProperties(Vue.prototype, {
		$authjs: {
			get() {
				return Vue.authjs
			}
		}
	})
	
}