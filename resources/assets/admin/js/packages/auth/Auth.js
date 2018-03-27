export default function (Vue) {

	Vue.auth = {
		setToken(token, expiration) {
			localStorage.setItem('token_admin', token)
			localStorage.setItem('expiration_admin', expiration)
		},

		getToken() {
			var token = localStorage.getItem('token_admin')
			var expiration = localStorage.getItem('expiration_admin')

			if(!token || !expiration) {
				return null
			}
			if(Date.now() >= parseInt(expiration)) {
				this.destroyToken()
				return null
			} else {
				return token
			}
		},

		destroyToken() {
			localStorage.removeItem('token_admin')
			localStorage.removeItem('expiration_admin')
		},

		isAuthenticated() {
			if(this.getToken())
				return true
			else
				return false
		}
	}

	Object.defineProperties(Vue.prototype, {
		$auth: {
			get() {
				return Vue.auth
			}
		}
	})
	
}