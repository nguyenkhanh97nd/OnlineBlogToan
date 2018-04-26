<template>
	<div class="container">
		<div class="row" v-if="getUser && current_user">

			<div class="col-sm-9 col-xs-12">
				<div class="col-md-3">
					<div class="row">
					<div class="be-user-block">
						<div class="be-user-detail">

							<router-link  :to="{ name: 'ClientProfileIndex', params: { userslug: getUser.username } }">

							<a class="be-ava-user">
								<div v-if="!getUser.avatar">
									<div  class="span-circle">
										<span>{{ getUser.name.substring(0,1) }}</span>
									</div>
								</div>
								<div v-if="getUser.avatar">
									<img class="img-circle" width="64px" height="64px" :src="'public/upload/users/' + getUser.avatar">
								</div>
							</a>
							</router-link>
							<p class="be-user-name">
								{{ getUser.name }}
							</p>
							<div v-if="current_user.id == getUser.id">
								<router-link  :to="{ name: 'ClientSetting' }">
									<a><span>Cài đặt</span></a>
								</router-link>
							</div>
						</div>
						<div class="be-user-activity-block">
							<div class="row">
								<div class="col-md-12">

								<div v-if="getUser.is_following">
									<button class="be-user-activity-button be-add-type" @click="doRemoveFollow(getUser.username)">Unfollow</button>
								</div>
								<div v-if="current_user.id != getUser.id">
									<div v-if="!getUser.is_following">
										<button class="be-user-activity-button be-add-type" @click="doAddFollow(getUser.username)">Follow</button>
									</div>
								</div>
					
								</div>
							</div>
						</div>
						<h5 class="be-title">Thông tin</h5>
						<p class="be-text-userblock">{{ getUser.info }}</p>
					</div>
					</div>
				</div>
				<div class="col-md-9">
					<div class="be-large-post">
						<div class="be-info-block">
							<div class="be-large-post-align">
								<span class="glyphicon glyphicon-comment be-glyphicon-info"> </span>
								<span class="be-info-count">{{ getUser.comment.length }}</span>
								<span class="glyphicon glyphicon-check be-glyphicon-info"> </span>
								<span class="be-info-count">{{ getUser.bdata.length }}</span>
								<span class="glyphicon glyphicon-pencil be-glyphicon-info"> </span>
								<span class="be-info-count">{{ getUser.post.length }}</span>
							</div>
						</div>
						
						<div v-for="feed in feeds.data">
							<div class="col-md-12">
								<div class="row be-single-feed">
									<div class="col-md-12">
										<h4 class="be-feed-title"><router-link  :to="{ name: 'ClientProfileIndex', params: { userslug: getUser.username } }"><a>{{ getUser.name }}</a></router-link> đã đăng câu hỏi tại 
											<router-link  :to="{ name: 'ClientSocialLearningCateQuestion', params: { slugCateQuestion: feed.sub_cate_question.cate_question.slug } }">
				                            <a>{{ feed.sub_cate_question.cate_question.name }}</a></router-link>, 

				                            <router-link  :to="{ name: 'ClientSocialLearningSubCateQuestion', params: { slugCateQuestion: feed.sub_cate_question.cate_question.slug, slugSubCateQuestion: feed.sub_cate_question.slug } }">
				                            <a>{{ feed.sub_cate_question.name }}</a>
					                        </router-link>
				                        </h4>
				                        <p class="be-feed-time"><span class="glyphicon glyphicon-time"></span> {{ feed.updated_at }}</p>
									</div>
									<div class="col-md-12">
										<p class="be-feed-content" v-html="feed.content"></p>
									</div>
									<div class="col-md-12">
										<div class="row be-devide-feed">
											<div class="col-md-4">
												<div v-if="!check_like_feed(current_user.id, feed.like_feed)">
													<span class="be-like-feed-btn"><span class="glyphicon glyphicon-thumbs-up"></span> 
													<button @click="doLike(feed.slug)" class="be-like-feed-btn-submit">Thích {{ feed.like_feed.length }}</button></span>
												</div>
												<div v-if="check_like_feed(current_user.id, feed.like_feed)">
													<span style="color:#3b5998" class="be-like-feed-btn"><span class="glyphicon glyphicon-thumbs-up"></span> 
													<button @click="doDislike(feed.slug)" class="be-like-feed-btn-submit">Bỏ thích</button> </span>
												</div> 
											</div>
											<div class="col-md-4">
												<span class="be-like-feed-btn">
													<span class="glyphicon glyphicon-comment"></span> 
													<span class="be-comment-feed-span-click click-comment" @click="focusComment(feed.slug)">Bình luận</span>
													<span>{{ feed.comment_feed.length }}</span>
												</span>
											</div>
											<div class="col-md-4">
												<span class="be-like-feed-btn"><span class="glyphicon glyphicon-share-alt"></span> 
												<button @click="doShare(feed.slug)" class="be-like-feed-btn-submit">Chia sẻ</button></span>
											</div>
										</div>
									</div>
									<div class="col-md-12">
										<div v-if="check_like_feed(current_user.id, feed.like_feed)">
											<p>Bạn <span v-if="feed.like_feed.length > 1">và {{ (feed.like_feed.length) - 1 }} người khác</span> thích điều này</p>
										</div>
									</div>
									<div class="col-md-12">
										<div v-if="feed.status == 1">
											<router-link  :to="{ name: 'ClientProfileIndex', params: { userslug: current_user.username } }">
					                        <a class="pull-left be-comment-media">
					                                <span style="border-radius: 50%; width:34px; height: 34px; line-height: 34px; font-size: 15px" v-if="! current_user.avatar">{{ current_user.name.substring(0,1) }}</span>
					                                <img class="img-circle" style="width: 34px; height: 34px" v-if="current_user.avatar" width="50px" height="50px" :src="'public/upload/users/' + current_user.avatar">
					                        </a>
						                    </router-link>
					                        <div class="media-body">
					                            <div class="formDoComment">
					                            <div class="form-group">
					                            	<input :id="feed.slug" type="text" class="form-control be-comment-form" @keydown="$event.keyCode === 13 && doComment($event)" placeholder="Trả lời nhanh..."  :name="feed.slug">
					                            </div>
					                        	</div>
					                        </div>
						                </div>

						                <div v-for="(comment_feed_item, key) in feed.comment_feed" class="be-show-first-comment">
											<div v-if="key < 2">
											
						                	<a :href="'/profile/' + comment_feed_item.user.username " class="pull-left be-comment-media">
					                                <span style="border-radius: 50%; width:34px; height: 34px; line-height: 34px; font-size: 15px" v-if="! comment_feed_item.user.avatar">{{ comment_feed_item.user.name.substring(0,1) }}</span>
					                                <img class="img-circle" style="width: 34px; height: 34px" v-if="comment_feed_item.user.avatar" width="50px" height="50px" :src="'public/upload/users/' + comment_feed_item.user.avatar">
					                            
					                        </a>
						                    
					                        <div class="media-body">
					                        	<p>
						                            <span class="media-heading"><a :href="'/profile/' + comment_feed_item.user.username "><font size="3" color="#3b5998"> {{ comment_feed_item.user.name }} </font></a>
						                            </span>
						                            <span>{{ comment_feed_item.content }}</span>
					                        	</p>
					                        </div>
					                    	</div>
						                </div>
						                
			                    	</div>
			                    	<div class="col-md-12">

					               		<p><router-link  :to="{ name: 'ClientCommentFeed', params: { slugFeed: feed.slug } }"><a>Xem chi tiết...</a></router-link></p>
									</div>
								</div>
							</div>
						</div>
						<!-- TODO more-->

					</div>
				</div>

			</div>
			<div class="col-sm-3 hidden-xs">
		    	<p class="heading-title">THÀNH TÍCH</p>
		    	<p><font size="3" color="#f1004c">GPA: {{ getUser.gpa }}</font></p>
		    	<p><font size="3" color="#f1004c">Điểm hoạt động: {{ getUser.point_activity }}</font></p>
		    	<div  class="be-max-points">
		    	<div v-for="max_point in max_points.data">
		    		<p>
		    			Đạt điểm tuyệt đối trong bài thi <a><router-link  :to="{ name: 'ClientPostIndex', params: { slugSubCate: max_point.post.subcategory.slug, slugPost: max_point.post.slug } }">{{ max_point.post.name }}</router-link></a>
		    		</p>
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
				getUser: '',
				current_user: '',
				link_getUser: '',
			}
		},
		created() {
			if(this.$authjs.isAuthenticated()) {
				this.getCurrentUser()

				this.link_getUser = 'api/client/getUser/' + this.$route.params.userslug

				this.fetchData()
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
			fetchData() {
				var vm = this
				axios.get(vm.link_getUser, { headers: { Authorization: 'Bearer ' + this.$authjs.getToken() }}).then((response) => {
					vm.getUser = response.data.getUser
					vm.max_points = response.data.max_points
					vm.feeds = response.data.feeds
				})

			},
			check_like_feed(id_check, array_check) {
				var i
				for(i=0;i<array_check.length; i++) {
					if(array_check[i].id_user == id_check) {
						return 1
						
						break
					}
				}
				return 0;
			},
			doLike(e) {
				var vm = this
				var link = "/api/client/like"
				var data = {
					slug_feed: e
				}
				axios.post(link, data, { headers: { Authorization: 'Bearer ' + this.$authjs.getToken() }})
				.then((response) => {
					vm.$router.go()
				})
			},
			doDislike(e) {
				var vm = this
				var link = "/api/client/dislike"
				var data = {
					slug_feed: e
				}
				axios.post(link, data, { headers: { Authorization: 'Bearer ' + this.$authjs.getToken() }})
				.then((response) => {
					vm.$router.go()
				})
			},
			doShare(e) {
				var vm =this
				vm.$swal("Error!", 'Chức năng sẽ cập nhật sau!', "error", {
                  button: "OK!",
                })
			},
			focusComment(e) {
				$('#'+e).focus()
			},
			doComment(e) {
				var vm = this
				var link = "/api/client/commentFeed"
				var data = {
					slug_feed: e.target.name,
					comment_content: e.target.value
				}
				axios.post(link, data, { headers: { Authorization: 'Bearer ' + this.$authjs.getToken() }})
				.then((response) => {
					if(response.data.comment_status) {
						vm.$swal("Error!", response.data.comment_status, "error", {
		                  button: "OK!",
		                })
					} else {
						vm.$swal("Success!", response.data.success, "success", {
		                  button: "OK!",
		                })
		                vm.$router.push({ name: 'ClientCommentFeed', params: { slugFeed: e.target.name } })
					}
					
				})
			}
		}
	}
</script>