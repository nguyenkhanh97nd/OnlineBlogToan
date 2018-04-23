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
	                                <input id="email" type="email" v-model="email" class="form-control" name="email"  required>

	                                <div v-if="error_email">
	                                	<span class="help-block">
	                                        <strong>{{ error_email }}</strong>
	                                    </span>
	                                </div>
	                            </div>
	                        </div>

	                        <div class="form-group">
	                            <div class="col-md-6 col-md-offset-4">
	                                <button @click="doSendReset" class="btn btn-primary">
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
				error_email: '',
				status: '',
			}
		},
		created() {
			this.email = ''
			this.status = ''
			this.error_email = ''
		},
		methods: {
			doSendReset() {

				var vm = this
				vm.error_email = ''
				if(!vm.email) {
					vm.error_email = 'Nhập email'
				} else {
					var data = {
						email: vm.email
					}
					var link = '/password/email'
					vm.status = 'Đang gửi...'
					axios.post(link, data).then((response) => {
						vm.$swal("Success!", 'Đã gửi yêu cầu! Kiểm tra Email!', "success", {
		                  button: "OK!",
		                })
		                vm.status = 'Đã gửi Email.'
		                
					})
				}
				
			}
		}
	}
</script>