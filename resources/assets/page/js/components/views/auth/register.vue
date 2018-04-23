<template>
	<div class="container">
	<div class="row">
	    <div class="col-md-8 col-md-offset-2">
	        <div class="panel panel-default">
	            <div class="panel-heading">Đăng ký</div>
	            <div class="panel-body">
	                <div class="form-horizontal" @input="clearError">
	                    <span class="help-block" v-if="wrong_form">
	                        <strong>{{ wrong_form }}</strong>
	                    </span>
	                    <div class="form-group">
	                        <label for="name" class="col-md-4 control-label">Họ tên</label>

	                        <div class="col-md-6">
	                            <input v-model="name" id="name" type="text" class="form-control" name="name" required autofocus>

	                            <span class="help-block" v-if="wrong_name">
	                                <strong>{{ wrong_name }}</strong>
	                            </span>
	                        </div>
	                    </div>

	                    <div class="form-group">
	                        <label for="name" class="col-md-4 control-label">Username</label>

	                        <div class="col-md-6">
	                            <input v-model="username" id="username" type="text" class="form-control" name="username" required autofocus>

	                            <span class="help-block" v-if="wrong_username">
	                                <strong>{{ wrong_username }}</strong>
	                            </span>
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <label for="email" class="col-md-4 control-label">E-Mail</label>

	                        <div class="col-md-6">
	                            <input v-model="email" id="email" type="email" class="form-control" name="email" required>

	                            <span class="help-block" v-if="wrong_email">
	                                <strong>{{ wrong_email }}</strong>
	                            </span>
	                        </div>
	                    </div>

	                    <div class="form-group">
	                        <label for="password" class="col-md-4 control-label">Mật khẩu</label>

	                        <div class="col-md-6">
	                            <input v-model="password" id="password" type="password" class="form-control" name="password" required>

	                            <span class="help-block" v-if="wrong_password">
	                                <strong>{{ wrong_password }}</strong>
	                            </span>
	                        </div>
	                    </div>

	                    <div class="form-group">
	                        <label for="repassword" class="col-md-4 control-label">Xác nhận mật khẩu</label>

	                        <div class="col-md-6">
	                            <input v-model="repassword" id="repassword" type="password" class="form-control" name="repassword" required>
	                        </div>
	                    </div>

	                    <div class="form-group">
	                        <label for="gender" class="col-md-4 control-label">Giới tính</label>

	                        <div class="col-md-6">
	                            <input type="radio" class="radio-inline" name="gender" v-model="gender" value="1"> Nam

	                            <input type="radio" class="radio-inline" name="gender" v-model="gender" value="0"> Nữ

	                            <input type="radio" class="radio-inline" name="gender" v-model="gender" value="3"> Không xác định

	                            <span class="help-block" v-if="wrong_gender">
	                                <strong>{{ wrong_gender }}</strong>
	                            </span>
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <div class="col-md-6 col-md-offset-4">
	                            <button @click="postRegister" class="btn btn-primary">
	                                Đăng ký
	                            </button>
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
				wrong_gender: '',
				wrong_password: '',
				wrong_email: '',
				wrong_username: '',
				wrong_name: '',
				wrong_form: '',
				name: '',
				username: '',
				email: '',
				password: '',
				repassword: '',
				gender: '',
				link: '',
			}
		},
		created() {
			this.link = 'api/client/register'
		},
		methods: {
			postRegister() {
				let vm = this
				let data = {
					name: vm.name,
					username: vm.username,
					password: vm.password,
					repassword: vm.repassword,
					email: vm.email,
					gender: vm.gender,
				}
				axios.post(vm.link, data).then((response) => {
					if(response.data.wrong_gender) {
						vm.wrong_gender = response.data.wrong_gender
					} else if(response.data.wrong_password) {
						vm.wrong_password = response.data.wrong_password
					} else if(response.data.wrong_email) {
						vm.wrong_email = response.data.wrong_email
					} else if(response.data.wrong_username) {
						vm.wrong_username = response.data.wrong_username
					} else if(response.data.wrong_name) {
						vm.wrong_name = response.data.wrong_name
					} else if(response.data.wrong_form) {
						vm.wrong_form = response.data.wrong_form
					} else {
						this.$router.push({ name: 'ClientLogin' })
					}
				}, (error) => {

				})
			},
			clearError() {
				var vm = this
				vm.wrong_gender = ''
				vm.wrong_password = ''
				vm.wrong_email = ''
				vm.wrong_username = ''
				vm.wrong_name = ''
				vm.wrong_form = ''
			}
		}
	}
</script>