<template>
	<div id="root">
	<!--Header NAV-->
<header>
<nav class="navbar navbar-inverse navbar-fixed-top">
<div class="container">
<div class="row">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span> 
      </button>     
      <router-link  :to="{ name: 'ClientIndex' }"><a class="navbar-brand">Online Blog Toán</a></router-link>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
		
		<li><router-link  :to="{ name: 'ClientCateIndex', params: { slugCate: 'toan' } }"><a  title="Toán" class="color-white" >{{ 'Toán' }}</a></router-link></li>
		<li><router-link  :to="{ name: 'ClientCateIndex', params: { slugCate: 'ly' } }"><a title="Lý" class="color-white" >{{ 'Lý' }}</a></router-link></li>
		<li><router-link  :to="{ name: 'ClientCateIndex', params: { slugCate: 'hoa' } }"><a  title="Hoá" class="color-white" >{{ 'Hoá' }}</a></router-link></li>

		<li><router-link  :to="{ name: 'ClientSocialLearningIndex' }"><a title="Cộng đồng học tập" class="color-white">Cộng đồng học tập</a></router-link></li>

		<li><router-link  :to="{ name: 'ClientSearchPostIndex' }"><a title="Tìm kiếm" class="color-white">Tìm kiếm</a></router-link></li>

      </ul>
        
      <ul class="nav navbar-nav navbar-right" v-if="!user">
        <li><router-link  :to="{ name: 'ClientRegister' }"><a class="color-white"><span class="glyphicon glyphicon-log-in"></span> Đăng kí</a></router-link></li>
        <li><router-link  :to="{ name: 'ClientLogin' }"><a class="color-white"><span class="glyphicon glyphicon-log-in"></span> Đăng nhập</a></router-link></li>
      </ul>
	  <ul class="nav navbar-nav navbar-right" v-if="user">
			<li><router-link  :to="{ name: 'ClientFollow' }"><a class="color-white"><span class="glyphicon glyphicon-plus"></span> Follow</a></router-link></li>

			<li><router-link  :to="{ name: 'ClientProfileIndex', params: { userslug: user.username } }"><a class="color-white"><span class="glyphicon glyphicon-user"></span> {{ user.username }}</a></router-link></li>

       
            <li>
              
              <a id="logout-click" @click="logout">
                  <span class="glyphicon glyphicon-log-in"></span> Đăng xuất
              </a>

            </li>
	  </ul>
    </div>
  </div>
  </div>
  </div>
</nav>
</header>
<div style="padding-top: 90px;"></div>

<router-view></router-view>

<footer>
	<!--Container footer-->
	<div class="container">
		<!--Row-->
		<div class="row">
			<!--Column 1-->
			<div class="col-sm-6 col-xs-12">
				<!--Row 1 -->
				<div class="row">
					<!--Col 1.1-->
					<div class="col-sm-6 col-xs-6">
						<div class="row-footer">
							<span>Online Blog Toán</span>
							<ul class="list-unstyled">
								<li>Online Blog Toán - Thi thử Online - Tìm bạn học Online</li>
								<li>Sáng lập bởi: Khánh Nguyễn</li>
								<li>Bản quyền &copy 2017 BlogToan</li>
							</ul>
						</div>
					</div><!--End Col 1.1-->

					<!--Col 1.2-->
					<div class="col-sm-6 col-xs-6">
						<div class="row-footer">
							<span>Bạn bè</span>
							<ul class="list-unstyled">
								<li>Blog Toán</li>
							</ul>
						</div>
					</div><!--End Col 1.2-->

				</div><!--End Row 1-->

			</div><!--End Column 1-->


			<!--Column 2-->
			<div class="col-sm-6 col-xs-12">
				<!-- Row 2-->
				<div class="row">

					<!--Col 2.1-->
					<div class="col-sm-6 col-xs-6">
						<div class="row-footer">
							<span>Quy định</span>
							<ul class="list-unstyled">
								<li></li>
								<li>Chính sách quyền riêng tư</li>
								<li>Điều khoản và sử dụng</li>
								<li>SITEMAP</li>
							</ul>
						</div>
					</div><!--End Col 2.1-->


					<!--Col 2.2-->
					<div class="col-sm-6 col-xs-6">
						<div class="row-footer">
							<span>Về chúng tôi</span>
							<ul class="list-unstyled">
								<li>Giới thiệu</li>
								<li>Liên hệ</li>
								<li><a rel="nofollow" href="https://web.facebook.com/profile.php?id=100006087014698" style="color:#3b5998;font-weight:bold">Facebook</a>
								</li>
								<li><a rel="nofollow" href="https://plus.google.com/u/0/102529050099795243520" style="color:#db4437;font-weight:bold">Google+</a></li>
								</li>
							</ul>
						</div>
					</div><!--End Col 2.2-->

				</div><!--End Row 2 -->

			</div><!--End Col 2-->

		</div><!--End Row-->

	</div><!--End Container-->
</footer>
</div>
</template>

<script>
	export default {

		data() {
			return {
				isAuthenticated: false,
				user: ''
			}
		},
		created() {

			if(this.$authjs.isAuthenticated()) {
				this.isAuthenticated = true
				this.getUser()
			} else {
				this.isAuthenticated = false
			}
		},
		methods: {
			getUser() {
				axios.get('api/client/user', { headers: { Authorization: 'Bearer ' + this.$authjs.getToken() }})
					.then((response)=>{
						this.user = response.data.user
					}, (error) => {
						this.isAuthenticated = false
						this.$authjs.destroyToken()
						this.$router.push({ name: 'ClientIndex' })
					})
			},

			logout() {
				this.$authjs.destroyToken()
				this.$router.go()
			},
			reloadCate() {
				this.$router.go()
			}
		}

	}
</script>