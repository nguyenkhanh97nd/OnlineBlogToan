<template>
	<div class="container" >
		<div class="row" v-if="current_user">

			<div class="col-sm-6">

				<div class="col-md-6">
					<div class="row">
					<div class="be-user-block">
						<div class="be-user-detail">
							<router-link  :to="{ name: 'ClientProfileIndex', params: { userslug: current_user.username } }">
							<a class="be-ava-user">
								<div v-if="!current_user.avatar">
									<div  class="span-circle">
										<span>{{ current_user.name.substring(0,1) }}</span>
									</div>
								</div>
								<div v-if="current_user.avatar">
									<img class="img-circle" width="64px" height="64px" :src="'public/upload/users/' + current_user.avatar">
								</div>
							</a>
							</router-link>
							<p class="be-user-name">
								{{ current_user.name }}
							</p>
							<router-link  :to="{ name: 'ClientSetting' }">
							<a><span>Cài đặt</span></a>
							</router-link>
						</div>
						<h5 class="be-title">Thông tin</h5>
						<p class="be-text-userblock">{{ current_user.info }}</p>
					</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="be-large-post">
						<div class="col-md-12">
							<h2 class="media-heading" style="padding-bottom: 10px;">{{ current_user.username }}</h2>
			                <p><a @click="setting_name" >Đổi tên hiển thị</a></p>
			                <p><a @click="setting_password" >Đổi mật khẩu</a></p>
			                <p><a @click="setting_avatar" >Cập nhật Ảnh đại diện</a></p>
			                <p><a @click="setting_info">Cập nhật giới thiệu</a></p>
		                </div>
					</div>
				</div>
				
			</div>
			<div class="col-sm-6">
		    	<div class="col-md-12">
		    		<div class="form-horizontal"  v-if="click_name">
		                <label for="name" class="col-md-4 control-label">Tên:</label>
						<div class="form-group">
			                <div class="col-md-6">
			                    <input id="name" v-model="name" type="text" class="form-control" name="name" required autofocus>

			                        <span class="help-block" v-if="wrong_name">
	                                    <strong>{{ wrong_name }}</strong>
	                                </span>
		                	</div>
	                	</div>
		            	<div class="form-group">
			                <div class="col-md-8 col-md-offset-4">
			                    <button @click="edit_name" class="btn btn-primary">
			                        Sửa
			                    </button>
		                	</div>
		            	</div>
       				</div>

       				<div class="form-horizontal" v-if="click_password">
                        <div class="form-group">
                            <label for="old_password"  class="col-md-4 control-label">Mật khẩu hiện tại</label>
                            <div class="col-md-6">
                                <input id="old_password" v-model="old_password" type="password" class="form-control" name="old_password" required>
                                    <span class="help-block" v-if="wrong_old_password">
                                        <strong>{{ wrong_old_password }}</strong>
                                    </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password" class="col-md-4 control-label">Mật khẩu mới</label>
                            <div class="col-md-6">
                                <input id="password" type="password" v-model="password" class="form-control" name="password" required>

                                    <span class="help-block" v-if="wrong_password">
                                        <strong>{{ wrong_password }}</strong>
                                    </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">Xác nhận mật khẩu</label>

                            <div class="col-md-6">
                                <input id="password-confirm" v-model="password_confirmation" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button @click="edit_password" class="btn btn-primary">
                                    Đổi mật khẩu
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="form-horizontal" v-if="click_avatar">
		                <label for="name" class="col-md-4 control-label">Avatar</label>
						<div class="form-group">
			                <div class="col-md-6">
			                    <input id="image" type="file" name="image" class="form-control" @change="changeImage($event)" required/>

			                        <span class="help-block" v-if="wrong_avatar">
	                                    <strong>{{ wrong_avatar }}</strong>
	                                </span>
		                	</div>
	                	</div>
		            	<div class="form-group">
			                <div class="col-md-8 col-md-offset-4">
			                    <button @click="edit_avatar" class="btn btn-primary">
			                        Cập nhật Ảnh đại diện
			                    </button>
		                	</div>
		            	</div>
       				</div>

       				<div class="form-horizontal" v-if="click_info">
		                <label for="info" class="col-md-4 control-label">Thông tin</label>
						<div class="form-group">
			                <div class="col-md-6">
			                    <input id="info" type="text" v-model="info" class="form-control" name="info" required autofocus>

			                        <span class="help-block" v-if="wrong_info">
	                                    <strong>{{ wrong_info }}</strong>
	                                </span>
		                	</div>
	                	</div>
		            	<div class="form-group">
			                <div class="col-md-8 col-md-offset-4">
			                    <button @click="edit_info" class="btn btn-primary">
			                        Cập nhật
			                    </button>
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
				current_user: '',
				click_name: false,
				click_password: false,
				click_avatar: false,
				click_info: false,

				wrong_name: '',
				name: '',

				wrong_info: '',
				info: '',

				wrong_password: '',
				wrong_old_password: '',
				password_confirmation: '',
				old_password: '',
				password: '',

				wrong_avatar: '',
				dataImage: '',
			}
		},
		created() {
			if(this.$authjs.isAuthenticated()) {
				this.getCurrentUser()
			}
		},
		methods: {
			getCurrentUser() {
				var vm = this
				axios.get('/api/client/user', { headers: { Authorization: 'Bearer ' + this.$authjs.getToken() }})
					.then((response)=>{
						vm.current_user = response.data.user
					}, (error) => {
						this.$authjs.destroyToken()
						this.$router.push({ name: 'ClientLogin' })
					})
			},
			setting_name() {
				var vm = this
				vm.name = vm.current_user.name
				vm.wrong_name = null
				vm.click_name = true
				vm.click_password = false
				vm.click_avatar = false
				vm.click_info = false
			},
			setting_password() {
				var vm = this
				vm.wrong_password = null
				vm.wrong_old_password = null
				vm.password_confirmation = null
				vm.old_password = null
				vm.password = null
				vm.click_name = false
				vm.click_password = true
				vm.click_avatar = false
				vm.click_info = false
			},
			setting_avatar() {
				var vm = this
				vm.click_name = false
				vm.click_password = false
				vm.click_avatar = true
				vm.click_info = false
			},
			setting_info() {
				var vm = this
				vm.name = vm.current_user.info
				vm.wrong_info = null
				vm.click_name = false
				vm.click_password = false
				vm.click_avatar = false
				vm.click_info = true
			},
			edit_name() {
				var vm = this
				var data = {
					name: vm.name
				}
				var link = '/api/client/settingName'
				vm.wrong_name = null
				axios.post(link, data, { headers: { Authorization: 'Bearer ' + this.$authjs.getToken() }})
				.then((response) => {
					if(response.data.success) {
						vm.$swal("Success!", response.data.success, "success", {
	                      button: "OK!",
	                    })
						vm.$router.go()
					} else {
						vm.wrong_name = response.data.wrong_name
					}
				})
			},
			edit_password() {
				var vm = this
				vm.wrong_password = null
				vm.wrong_old_password = null

				if(vm.password != vm.password_confirmation) {
					vm.wrong_password = 'Xác nhận mật khẩu không đúng'
				}

				var data = {
					cur_pwd: vm.old_password,
					new_pwd: vm.password
				}
				var link = '/api/client/settingPassword'

				axios.post(link, data, { headers: { Authorization: 'Bearer ' + this.$authjs.getToken() }})
				.then((response) => {
					if(response.data.wrong_old_password) {
						vm.wrong_old_password = response.data.wrong_old_password
					} else if(response.data.wrong_password) {
						vm.wrong_password = response.data.wrong_password
					} else {
						vm.$swal("Success!", response.data.success, "success", {
	                      button: "OK!",
	                    })
						vm.$router.go()
					}
				})

			},
			edit_info() {
				var vm = this
				var data = {
					info: vm.info
				}
				var link = '/api/client/settingInfo'
				vm.wrong_info = null
				axios.post(link, data, { headers: { Authorization: 'Bearer ' + this.$authjs.getToken() }})
				.then((response) => {
					if(response.data.success) {
						vm.$swal("Success!", response.data.success, "success", {
	                      button: "OK!",
	                    })
						vm.$router.go()
					} else {
						vm.wrong_info = response.data.wrong_info
					}
				})
			},
			changeImage(event) {
				var vm = this
				vm.dataImage = null
				if(event.target.files[0]) {
					var fileReader = new FileReader()
	        		fileReader.readAsDataURL(event.target.files[0])
	        		fileReader.onload = (e) => {
                        var dataRead = e.target.result
			        	vm.dataImage = dataRead
                    }
				} else {
					vm.dataImage = null
				}
			},
			edit_avatar() {
				var vm = this
				vm.wrong_avatar = null
				if(vm.dataImage) {
					var link = '/api/client/settingAvatar'
					var data = {
						avatar: vm.dataImage
					}
					axios.post(link, data, { headers: { Authorization: 'Bearer ' + this.$authjs.getToken() }})
					.then((response) => {
						if(response.data.wrong_avatar) {
							vm.wrong_avatar = response.data.wrong_avatar
						} else {
							vm.$swal("Success!", response.data.success, "success", {
		                      button: "OK!",
		                    })
							// vm.$router.go()
						}
					}, (response) => {
						console.log(response)
					})
				} else {
					vm.wrong_avatar = 'Chưa chọn ảnh'
				}

			}
		}
	}
</script>