<template>
	<div id="root">
	<div v-if="!metalogin">
		<div class="main-container">
			<div class="col-md-2 left-col">
				<div class="dashboard-title page-header">
					<router-link  :to="{ name:'AdminDashboardIndex' }"> Online - Admin </router-link>
		        </div>
		        <div class="profile media">
		          <div class="wrapper">
		            <div class="media-left">
		              <span>{{ user.name | getFirstChar }}</span>
		            </div>
		            <div class="media-body">
		              <p>{{ user.name }}</p>
		              <p>{{ user.level | getPermission }}</p>
		            </div>
		          </div> 
		        </div>
		        <div class="sidebar-menu">
		        	<div class="menu-section">
		        		<div class="wrapper">
		        			<h4>Menu</h4>
		        			<div class="menu-left">
		        				<ul class="sidebar-left">
							    	<li><span class="glyphicon glyphicon-th-list" style="font-size: 10px;margin-right:5px"></span><router-link  :to="{ name:'AdminCategoryIndex' }"> Category</router-link></li>
							    	<li><span class="glyphicon glyphicon-th-list" style="font-size: 10px;margin-right:5px"></span><router-link :to="{ name:'AdminSubCategoryIndex' }"> Sub Category</router-link></li>
							    	<li><span class="glyphicon glyphicon-pencil" style="font-size: 10px;margin-right:5px"></span><router-link :to="{ name:'AdminPostsIndex' }"> Posts</router-link></li>
							    	<li><span class="glyphicon glyphicon-pencil" style="font-size: 10px;margin-right:5px"></span><router-link :to="{ name:'AdminPendingPostsIndex' }"> Pending Posts</router-link></li>
							    	<li><span class="glyphicon glyphicon-pencil" style="font-size: 10px;margin-right:5px"></span><router-link :to="{ name:'AdminQuestionsIndex' }"> Questions</router-link></li>
							    	<li><span class="glyphicon glyphicon-user" style="font-size: 10px;margin-right:5px"></span><router-link :to="{ name:'AdminMembersIndex' }"> Members</router-link></li>
							    	<li><span class="glyphicon glyphicon-envelope" style="font-size: 10px;margin-right:5px"></span><router-link :to="{ name:'AdminMailIndex' }"> Mail</router-link></li>
							    	<li><span class="glyphicon glyphicon-comment" style="font-size: 10px;margin-right:5px"></span><router-link :to="{ name:'AdminCommentIndex' }"> Comment</router-link></li>
							    	<li><span class="glyphicon glyphicon-check" style="font-size: 10px;margin-right:5px"></span><router-link :to="{ name:'AdminDataIndex' }"> Data Test</router-link></li>

							    	<li><span class="glyphicon glyphicon-th-list" style="font-size: 10px;margin-right:5px"></span><router-link  :to="{ name:'AdminCateQuestionIndex' }"> Cate Question</router-link></li>
							    	<li><span class="glyphicon glyphicon-th-list" style="font-size: 10px;margin-right:5px"></span><router-link  :to="{ name:'AdminSubCateQuestionIndex' }"> Sub Cate Question</router-link></li>
							    </ul>
		        			</div>
		        		</div>
		        	</div>
		        </div>
			</div>
			<div class="col-md-10 right-col">
				<div class="row">
				<div class="top-nav fixed-top" >
					<nav class="navbar navbar-inverse ">
		              <div class="container-fluid">
		                <div class="navbar-header">
		                  <button type="button" class="navbar-toggle-left" data-toggle="collapse" data-target="#myNavbar">
		                    <span class="icon-bar"></span>
		                    <span class="icon-bar"></span>
		                    <span class="icon-bar"></span> 
		                  </button>
		                </div>
		                <ul class="nav navbar-nav navbar-right">
		                  <li><a href="" title="AuthName"><span class="glyphicon glyphicon-user"></span> {{ user.name }}</a></li>
		                  <li><a @click="logout()" itle="Đăng xuất"><span class="glyphicon glyphicon-log-in"></span> Đăng xuất</a></li>
		                </ul>
		              </div>
		            </nav>
		        </div>
		        <div class="main-content-admin">
		            <div class="wrapper">
		              	<router-view></router-view>
		            </div>
		        </div>
				</div>
			</div>
		</div>
	</div>
	<div v-else>
		<div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
			    	<div class="panel-heading">
				        <h3 class="panel-title">Login</h3>
				    </div>
				    <div class="panel-body">

					    <div class="form-group">
					        <input v-model="email"
									   class="form-control"
									   type="email"
									   placeholder="Nhập email">
					    </div>
					    <div class="form-group">
					        <input v-model="password"
								       class="form-control"
								       type="password"
								       placeholder="Mật khẩu">
					    </div>
					    <button @click="login" class="btn btn-lg btn-success btn-block">
							Login
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
				user: '',
				email: '',
				password: '',
				metalogin: '',
			}
		},
		created() {
			if(this.$auth.isAuthenticated()) {
				this.metalogin = false
				this.getUser()
			} else {
				this.metalogin = true
			}
		},
		methods: {
			login() {
				var data = {
					client_id: 1,
					client_secret: '3KCdm7TJgXvx069T79rHrDrGt5mrVfVHxrmrfJMM',
					grant_type: 'password',
					username: this.email,
					password: this.password			
				}
				axios.post('/oauth/token', data)
					.then((response) => {

						this.$auth.setToken(response.data.access_token, response.data.expires_in + Date.now())
						this.getUser()
						this.metalogin = false
						this.$router.push({name:'AdminDashboardIndex'})
					})
			},
			logout() {
				this.$auth.destroyToken();
				this.metalogin = true
				this.$router.push({name:'AdminLogin'})
			},
			getUser() {
				axios.get('/api/user', { headers: { Authorization: 'Bearer'+ " " + this.$auth.getToken() }})
					.then((response)=>{
						this.user = response.data
					})	
			}
		},
		filters: {
			getFirstChar(value) {
			    if (!value) return ''
			    value = value.toString()
			    return value.charAt(0)
			},
			getPermission(value) {
				if(!value) {
					return ''
				} else if(value == 1) {
					return 'Admin'
				} else if(value == 2) {
					return 'Editor'
				} else if(value == 3) {
					return 'Member'
				} else {
					return 'Unknown'
				}
			}
		}
	}
</script>
