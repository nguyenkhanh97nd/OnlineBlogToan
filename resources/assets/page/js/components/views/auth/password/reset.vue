<template>
	<div class="container">
	    <div class="row">
	        <div class="col-md-8 col-md-offset-2">
	            <div class="panel panel-default">
	                <div class="panel-heading">Đặt lại mật khẩu</div>

	                <div class="panel-body">
	                	<div v-if="status">
	                		<div class="alert alert-success">
	                            {{ status }}
	                        </div>
	                	</div>

	                    <div class="form-horizontal">
	                      
	                        <div class="form-group">
	                            <label for="email" class="col-md-4 control-label">E-Mail</label>

	                            <div class="col-md-6">
	                                <input id="email" v-model="email" type="email" class="form-control" name="email" required autofocus>
							
	                                <div v-if="error_email">
	                                	<span class="help-block">
	                                        <strong>{{ error_email }}</strong>
	                                    </span>
	                                </div>
	                            </div>
	                        </div>

	                        <div class="form-group">
	                            <label for="password" class="col-md-4 control-label">Mật khẩu</label>

	                            <div class="col-md-6">
	                                <input id="password" type="password" v-model="password" class="form-control" name="password" required>

	                               <div v-if="error_password">
	                                	<span class="help-block">
	                                        <strong>{{ error_password }}</strong>
	                                    </span>
	                                </div>
	                            </div>
	                        </div>

	                        <div class="form-group">
	                            <label for="password-confirm" class="col-md-4 control-label">Xác nhận mật khẩu</label>
	                            <div class="col-md-6">
	                                <input id="password-confirm" type="password" v-model="repassword" class="form-control" name="password_confirmation" required>

	                                <div v-if="error_repassword">
	                                	<span class="help-block">
	                                        <strong>{{ error_repassword }}</strong>
	                                    </span>
	                                </div>
	                            </div>
	                        </div>

	                        <div class="form-group">
	                            <div class="col-md-6 col-md-offset-4">
	                                <button @click="doReset" class="btn btn-primary">
	                                    Đặt lại mật khẩu
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
				email: '',
				password: '',
				repassword: '',

				status: '',
				error_email: '',
				error_repassword: '',
				error_password: ''
			}
		},
		created() {
			if(!this.$route.params.code) {
				this.$router.push({ name: 'ClientIndex' })
			}
		},
		methods: {
			doReset() {
				var vm = this
				var link = "/password/reset"
				vm.status = "Đang chờ xử lý..."
				if(vm.password != vm.repassword) {
					vm.$swal("Error!", 'Xác nhận mật khẩu không đúng!', "error", {
	                  button: "OK!",
	                })
				}

				var data = {
					token: vm.$route.params.code,
					email: vm.email,
					password: vm.password,
					password_confirmation: vm.repassword
				}
				axios.post(link, data).then((response) => {
					vm.$swal("Success!", 'Đặt lại mật khẩu thành công!', "success", {
	                  button: "OK!",
	                })
	                vm.$router.push({ name: 'ClientLogin' })
	                vm.status = ''
				}, (error) => {
					vm.$swal("Error!", 'Lỗi!!! Kiểm tra lại thông tin!', "error", {
	                  button: "OK!",
	                })
	                vm.status = ''
				})
			}
		}
	}
</script>