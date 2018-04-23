<template>
	<div class="container">
	<div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Đăng nhập</div>
                <div class="panel-body">
                    <div class="form-horizontal" @input="clearError">

                        <span class="help-block" v-if="wrong_account">
                            <strong>{{ wrong_account }}</strong>
                        </span> 

                        <div class="form-group">
                            

                            <label for="login" class="col-md-4 control-label">Username hoặc Email</label>

                            <div class="col-md-6">
                                <input v-model="login" id="login" type="text" class="form-control" name="login" required autofocus>

                                <span class="help-block" v-if="wrong_info">
                                    <strong>{{ wrong_info }}</strong>
                                </span>

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password" class="col-md-4 control-label">Mật khẩu</label>

                            <div class="col-md-6">

                                <input v-model="password" id="password" type="password" class="form-control" name="password" required>

                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button @click="postLogin" class="btn btn-primary">
                                    Đăng nhập
                                </button>
								<router-link  :to="{ name: 'ClientPasswordEmail' }">
                                <a class="btn btn-link">
                                    Quên mật khẩu?
                                </a>
	                            </router-link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
	</div>	
</template>

<script>

	export default {
		data() {
			return {
				login: '',
				password: '',
				link_login: '',
				link: '',
				wrong_info: '',
				wrong_account: '',
				// isAuthenticated: false
			}
		},
		created() {
			if(this.$authjs.isAuthenticated()) {
				this.isAuthenticated = true
				this.getUser()
			} else {
				this.link = '/login'
			}
		},
		methods: {
			getUser() {
				axios.get('api/client/user', { headers: { Authorization: 'Bearer ' + this.$authjs.getToken() }})
					.then((response)=>{
						this.$router.push({ name: 'ClientIndex' })
					}, (error) => {
						this.isAuthenticated = false
						this.$authjs.destroyToken()
						this.$router.push({ name: 'ClientLogin' })
					})
			},
			postLogin() {
				let vm = this
				let data = {
					login: vm.login,
					password: vm.password
				}
				axios.post(vm.link, data).then((response) => {
					if(response.data.wrong_account) {
						vm.wrong_account = response.data.wrong_account
					} else if (response.data.wrong_info) {
						vm.wrong_info = response.data.wrong_info
					} else {
						this.$authjs.setToken(response.data.token)
						this.$router.go()
					}
				}, (error) => {
					this.$router.push({ name: 'ClientIndex' })
				})
			},
			clearError() {
				let vm = this
				vm.wrong_info = '',
				vm.wrong_account = ''
			}
		}
	}
</script>