<template>
	<div class="container">
	<div class="row">
	    <div class="col-sm-9 col-xs-12" v-if="post">
	        <div class="heading-block col-sm-12">
	            <a><router-link  :to="{ name: 'ClientIndex' }">Trang chủ </router-link></a>|
	            <a><router-link  :to="{ name: 'ClientCateIndex', params: { slugCate: post.subcategory.category.slug } }">{{ post.subcategory.category.name }}</router-link></a> |
	            <a><router-link  :to="{ name: 'ClientSubCateIndex', params: { slugSubCate: post.subcategory.slug } }">{{ post.subcategory.name }}</router-link></a> |
	            <a><router-link  :to="{ name: 'ClientPostIndex', params: { slugSubCate: post.subcategory.slug, slugPost: post.slug } }">{{ post.name }}</router-link></a>
	        </div>
	        <div class="col-sm-12">
	            <div class="row">
	                <div class="col-sm-3 media hidden-xs">
						<a><router-link  :to="{ name: 'ClientPostIndex', params: {slugSubCate: post.subcategory.slug, slugPost: post.slug } }"><img style="margin-top: 22px" class="img-responsive" :src="'upload/posts/' + post.image"/></router-link></a>
	                </div>
	                <div class="meta-content-single  col-sm-9 col-xs-12 caption">
	                	<h1><router-link  :to="{ name: 'ClientPostIndex', params: { slugSubCate: post.subcategory.slug, slugPost: post.slug } }"><a>{{ post.name }}</a></router-link></h1>
	                    <p>Tác giả: {{ post.author.name }}</p>
	                    <p>Ngày: {{ post.created_at }}</p>
	                    <p>Chuyên mục: <router-link  :to="{ name: 'ClientSubCateIndex', params: { slugSubCate: post.subcategory.slug } }"><a>{{ post.subcategory.name }}</a></router-link></p>
	                    <p>Lượt xem: {{ post.count_views }} </p>
	                </div>

	                <div class="content-single col-sm-12 col-xs-12">
	                    <p v-html="post.content"></p>
	                </div>
	                <div class="test_online col-sm-12 col-xs-12">
	                    <div v-if="user">
	                        <p v-if="testonline"><font color="#f1004c">Tham gia thi thử:</font> <router-link  :to="{ name: 'ClientTestOnlineIndex', params: { postSlug: post.slug } }"><a>{{ post.name }}</a></router-link></p>
	                        <p v-else><font color="#f1004c">Lịch thi thử sẽ được công bố sau.</font></p>
	                    </div>
	                    <div v-else>
	                        <p>Bạn cần đăng nhập để thi thử.</p>
	                    </div>
	                </div>
	            </div>
	        </div>

	    <!--bình luận -->

	        <div v-if="user">
		        <div class="col-sm-12 col-xs-12">
		        <div class="row well">
		            <h4>Viết bình luận ...</h4>
		            <div>
		                <span class="help-block" v-if="wrong_comment">
		                    <strong>{{ wrong_comment }}</strong>
		                </span> 

		                <div class="form-group">
		                    <textarea class="comment-area form-control" rows="3" v-model="comment_content" name="comment_content"></textarea>
		                </div>
		                <button  @click="doComment" class="btn btn-primary">Gửi</button>
		            </div>
		        </div>
		        </div>
	        </div>
	                    
	        <!-- Posted Comments -->
	        <div v-if="comments">
	            <div class="col-sm-12 col-xs-12">
	            <div class="row">
	            <div v-for="comment in comments.data">
	            
	                    <div class="media">
	                        <a class="pull-left" ng-href="profile/comment.user.username">
	                                <span style="border-radius: 50%; width:50px; height: 50px; line-height: 50px" v-if="! comment.user.avatar">{{comment.user.name.substring(0,1)}}</span>
	                                <img class="img-circle" v-if="comment.user.avatar" width="50px" height="50px" :src="'upload/users/' + comment.user.avatar">
	                        </a>
	                        <div class="media-body">
	                            <h4 class="media-heading"><router-link  :to="{ name: 'ClientProfileIndex', params: { userslug: comment.user.username } }"><a><font size="3" color="#3b5998"> {{comment.user.name}} </font></a></router-link>
	                                <font size="1" class="pull-right">{{ comment.created_at }}</font>
	                            </h4>
	                            <p v-html="comment.content"></p>
	                        </div>
	                 
	                    </div>
	            </div>
	            </div>
	            </div>
					<!-- Loading -->
					<center>
                        <a v-if="comments.next_page_url" class="text-center" id="loadMore" @click="loadMoreFun">Xem thêm</a> 
                    </center>
	        </div>
	        
	    </div>

	    <div class="col-sm-3 hidden-xs">
	        <p class="heading-title">CÙNG CHUYÊN MỤC</p>
	        <ul  class="list-unstyled" v-for="(same_post, key) in same_posts">
	            <div class="col-md-12"><div class="row">
	            <div class="col-md-5 text-center">
					<a><router-link  :to="{ name: 'ClientPostIndex', params: {slugSubCate: same_post.subcategory.slug, slugPost: same_post.slug } }"><img class="img-responsive" :src="'upload/posts/' + same_post.image"/></router-link></a>
	            </div>
	            <div class="col-md-7">
	                <p style="margin: 0"><span>
						<router-link  :to="{ name: 'ClientPostIndex', params: { slugSubCate: same_post.subcategory.slug, slugPost: same_post.slug } }"><a><font size="2">{{ same_post.name }}</font></a></router-link>
						</span>
	                <p><font size="1">{{ same_post.created_at }}</font></p>
	            </div>
	            </div></div>
	        </ul>
	    </div>

	</div>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				link_post: '',
				link_comment: '',
				link_user: '',
				wrong_comment: '',
				comment_content: '',
				isAuthenticated: false,
				post: '',
				same_posts: '',
				user: '',
				comments: ''
			}
		},
		mounted() {
			this.link_post = 'api/client/' + this.$route.params.slugSubCate + '/' + this.$route.params.slugPost
			this.link_comment = 'api/client/comment/' + this.$route.params.slugPost
			if(this.$authjs.isAuthenticated()) {
				this.isAuthenticated = true
				this.link_user = '/api/client/user'
				this.getUser()
				this.getComment()
			} else {
				this.isAuthenticated = false
			}
			this.fetchData()
		},
		methods: {
			fetchData() {
				var vm = this
				axios.get(vm.link_post).then((response)=> {
					vm.post = response.data.post
					vm.testonline = response.data.testonline
					vm.same_posts = response.data.same_posts
				})
			},
			getComment() {
				var vm = this
				axios.get(vm.link_comment, { headers: { Authorization: 'Bearer ' + this.$authjs.getToken() }}).then((response)=> {
					vm.comments = response.data.comments
					console.log(response)
				})
			},
			getUser() {
				var vm = this
				axios.get(vm.link_user, { headers: { Authorization: 'Bearer ' + this.$authjs.getToken() }}).then((response)=> {
					vm.user = response.data.user
				})
			},
			doComment() {
				var vm = this
				var data = {
					comment_content: vm.comment_content
				}
				axios.post(vm.link_comment, data, { headers: { Authorization: 'Bearer ' + this.$authjs.getToken() }}).then((response) => {
					if(response.data.success) {
						vm.$router.go()
					} else if(response.data.wrong_comment) {
						vm.wrong_comment = response.data.wrong_comment
					}
				}, (error) => {
					vm.$router.go()
				})
			},
			loadMoreFun() {
                var vm = this
                var link = vm.comments.next_page_url
                if(link) {
                    axios.get(link, { headers: { Authorization: 'Bearer ' + this.$authjs.getToken() }}).then((response) => {
                        var res = response.data.comments

                        vm.comments.next_page_url = res.next_page_url
                        for(var i = 0; i < res.data.length; i++) {
                            var check = true
                            for(var j = 0; j < vm.comments.data.length; j++) {
                                if(vm.comments.data[j].id == res.data[i].id) {
                                    check = false;
                                    break;
                                }
                            }
                            if(check) {
                                vm.comments.data.push(res.data[i])
                            }
                            
                        }

                    })
                }
            }
		}
	}
</script>