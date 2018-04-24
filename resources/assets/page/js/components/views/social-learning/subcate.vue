<template>
	<div class="container">
		<div class="row">
			<div class="col-md-3">

				<button class="be-user-activity-button be-add-type" @click="addQuestion">
					Đăng câu hỏi
				</button>
				<p><span :style="'color:' + color1" class="glyphicon glyphicon-pencil"></span> <router-link  :to="{ name: 'ClientSocialLearningIndex' }"><a class="link-learn">Tất cả câu hỏi</a></router-link></p>
				<p><span :style="'color:' + color2" class="glyphicon glyphicon-signal"></span> <router-link  :to="{ name: 'ClientSocialLearningIndex' }"><a class="link-learn">Hệ thống danh hiệu</a></router-link></p>
				

				<ul class="ul-catequestion">
					<li v-for="cate in catequestion"><span class="glyphicon glyphicon-book" :style="'color:' + cate.color "></span> <router-link  :to="{ name: 'ClientSocialLearningCateQuestion', params: { slugCateQuestion: cate.slug } }"><a class="link-learn">{{ cate.name }}</a></router-link>

							
							<ul v-if="cate_param == cate.slug" style="display: block" class="ul-subcatequestion">
								<li v-for="subcate in cate.sub_cate_question">
									<router-link  :to="{ name: 'ClientSocialLearningSubCateQuestion', params: { slugCateQuestion: cate.slug, slugSubCateQuestion: subcate.slug } }"><a :class="subcate.slug" @click="changeSubCate(subcate.slug)">{{ subcate.name }}</a></router-link>
								</li>
							</ul>
					
					</li>
					
				</ul>


			</div>
			<div class="col-md-9">
				<div class="col-md-12">
					<div class="heading-setting">
						<div class="sort-left">
					        <el-select v-model="sort_by" @change="sort_custom" placeholder="Sắp xếp">
							    <el-option label="Mới nhất" value="new"></el-option>
							    <el-option label="Điểm" value="point"></el-option>
							    <el-option label="Chưa trả lời" value="unans"></el-option>
						  </el-select>
					    </div>
						<div class="refresh-right pull-right">
							<a class="a-click-refresh" @click="doRefresh">
								<span class="glyphicon glyphicon-refresh"></span>
							</a>
						</div>
					</div>
				</div>
				<div class="col-md-12 margin-content">
					<div class="row">
						<div v-if="feeds">
							<div class="content-social-learning" v-for="feed in feeds.data">
								<router-link  :to="{ name: 'ClientProfileIndex', params: { userslug: feed.user.username } }">
								<a class="pull-left be-feed-media">
		                                <span style="border-radius: 50%; width:34px; height: 34px; line-height: 34px; font-size: 15px" v-if="! feed.user.avatar">{{ feed.user.name.substring(0,1) }}</span>
		                                <img class="img-circle" style="width: 34px; height: 34px" v-if="feed.user.avatar" width="50px" height="50px" :src="'upload/users/' + feed.user.avatar">
		                        </a>
			                    </router-link>
		                        <div class="media-body body-feed-item">
		                            <p class="media-heading-social-learning" >
										<router-link  :to="{ name: 'ClientCommentFeed', params: { slugFeed: feed.slug } }">
		                            	<a><font size="3" color="#333"> {{ feed.name }} </font></a>
			                            </router-link>
		                            </p>
		            				<p class="feed-item-description">
		            					<span class="pull-left">{{ feed.created_at }}</span>
		            					<span class="pull-right">
		            						<span>
		            							<router-link  :to="{ name: 'ClientSocialLearningCateQuestion', params: { slugCateQuestion: feed.sub_cate_question.cate_question.slug } }">
		            							<a :style="'background:' + color1" class="feed-cate-des feed-des-right">{{ feed.sub_cate_question.cate_question.name }}</a>
			            						</router-link>
		            						</span>
		            						<span>
		            							<router-link  :to="{ name: 'ClientSocialLearningSubCateQuestion', params: { slugCateQuestion: feed.sub_cate_question.cate_question.slug, slugSubCateQuestion: feed.sub_cate_question.slug } }">
		            							<a :style="'background:' + color2" class="feed-cate-des">{{ feed.sub_cate_question.name }}</a>
			            						</router-link>
		            						</span>
		            						<span class="feed-des-right count-des-right">{{ feed.point_feed }} điểm</span>
		            						<span style="color:#333;font-weight: bold;" class="glyphicon glyphicon-comment feed-des-right"></span>
		            						<span class="count-des-right">{{ feed.comment_feed.length }}</span>
		            					</span>
		            				</p>
		                            <p class="content-feed-item">{{ feed.content.substring(0, 60) }}</p>
		                        </div>
							</div>

							<div class="panel-footer pagination-footer">
						        <div class="pagination-item">
						            <span>Mỗi trang: {{ feeds.per_page }}</span>
						        </div>
						        <div class="pagination-item">
						            <small>Hiển thị {{ feeds.from }} - {{ feeds.to }} / {{ feeds.total }}</small>
						        </div>
						        <div class="pagination-item">
						            <small>Hiện tại: </small>
						            <input type="number" min="1" :max="feeds.last_page" class="pagination-input" :value="feeds.current_page"
						                @keydown="$event.keyCode === 13 && goTo($event)">
						            <small> / {{ feeds.last_page }}</small>
						        </div>
						        <div class="pagination-item">
						            <button v-if="feeds.prev_page_url" @click="goPrev" class="btn btn-default btn-sm">Trước</button>
						            <button v-if="feeds.next_page_url" @click="goNext" class="btn btn-default btn-sm">Sau</button>
						        </div>
						    </div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-12" style="background:red">
			<div class="col-md-offset-2 col-md-8">
			<div class="showQuestionForm" v-if="current_user">
				
				<router-link  :to="{ name: 'ClientProfileIndex', params: { userslug: current_user.username } }">

				<a class="pull-left be-feed-media" style="margin-top: 0">
	                    <span style="border-radius: 50%; width:34px; height: 34px; line-height: 34px; font-size: 15px" v-if="! current_user.avatar">{{ current_user.name.substring(0,1) }}</span>
	                    <img class="img-circle" style="width: 34px; height: 34px" v-if="current_user.avatar" width="50px" height="50px" :src="'upload/users/' + current_user.avatar">
	            </a>
		        </router-link>
				<div class="media-body body-feed-item">
					<div class="sort-left" layout="row" layout-align="space-between center">
				        <select required v-model="select_cate" @change="select_cate_fun" placeholder="Chọn chuyên mục"  class="md-no-underline custom-md-select-cate">
			        		<option value="" disabled>Chọn chuyên mục</option>
				          	<option v-for="cate in catequestion" v-if="cate.sub_cate_question.length" :value="cate.slug">{{ cate.name }}</option>
				        </select>		
				    </div>
				    <div class="sort-left div_select_subcate" layout="row" style="margin-left:5px;display: none;" layout-align="space-between center">
							<select  v-model="select_subcate" required placeholder="Chọn mục"  class="md-no-underline custom-md-select-cate">
								<option value="" disabled>Chọn mục</option>
					          <option v-for="subcate in subcatequestion" :value="subcate.slug">{{ subcate.name }}</option>
					        </select>
				    </div>
					<div class="sort-left div_select_subcate" layout="row" style="margin-left:5px; display: none;" layout-align="space-between center">

							<el-select v-model="point_set" placeholder="Số điểm">
							    <el-option label="5" value="5"></el-option>
							    <el-option label="10" value="10"></el-option>
							    <el-option label="15" value="15"></el-option>
							    <el-option label="20" value="20"></el-option>
						  </el-select>
				    </div>
				    <div class="cancel_form_question pull-right">
				    	<span v-if="minify" class="span-minify glyphicon glyphicon glyphicon-menu-down" @click="cancel_minify_add"></span>
				    	<span v-if="!minify" class="span-minify glyphicon glyphicon glyphicon-menu-up" @click="cancel_minify_add"></span>
				    	<span v-if="zoom" class="span-resize glyphicon glyphicon-resize-full" @click="cancel_resize_add"></span>
				    	<span v-if="!zoom" class="span-resize glyphicon glyphicon-resize-small" @click="cancel_resize_add"></span>
				    	<span class="span-cancel glyphicon glyphicon-remove" @click="cancel_form_add"></span>
				    </div>
	            </div>
	            <div class="col-md-12">
	            	<div class="row">
				            <label>Tiêu đề</label>
				            <input v-model="title_question" required>

	            	</div>
	            </div>
	            <div class="col-md-12">
	            	<div class="row">
				          <label>Nội dung</label>
				          <textarea v-model="content_question" required rows="5" ></textarea>
	            	</div>
	            </div>
	            <div class="col-md-12">
	            	<div class="row">
	            		<div class="form_add_question">
		            		<button class="submit_add_question" @click="addQuestionFun" >Gửi</button>
							  <div class="input-file-container">  
							    <input class="input-file" id="my-file" type="file" @change="changeImage($event)">
							    <label title="Thêm ảnh" tabindex="0" for="my-file" class="input-file-trigger"><span class="glyphicon glyphicon-folder-open"></span></label>

							    <a class="remove-add-image" @click="removeImageData">Xoá ảnh</a>
							  </div>
							  <p class="file-return"></p>
							  <div id="imgQuestion">
							  	<img :src="dataImageQuestion" alt="Ảnh câu hỏi">
							  </div>
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
				color1: '',
				color2: '',
				feeds: '',
				link_cate_question: '',
				link_subcate_question: '',
				link_post_feed: '',
				current_user: '',
				catequestion: '',
				sort_by: '',
				select_cate: '',
				select_subcate: '',
				cate: '',
				subcate: '',
				subcatequestion: '',
				point_set: '',
				title_question: '',
				content_question: '',

				dataImageQuestion: '',

				cate_param: '',
				subcate_param: '',

				zoom: true,
				minify: true,
			}
		},
		created() {
			if(this.$authjs.isAuthenticated()) {
				this.getCurrentUser()
			}
			this.link_cate_question = '/api/client/catequestion',
			this.link_subcate_question = '/api/client/subcatequestion'
			this.link_post_feed = '/api/client/postFeed'
			this.link_cate_feeds = '/api/client/comment_feed'


			this.cate_param = this.$route.params.slugCateQuestion
			this.subcate_param = this.$route.params.slugSubCateQuestion

			this.color1 = this.getColor()
			this.color2 = this.getColor()

			this.fetchData()
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
				vm.getCateQuestion()
				vm.getFeeds(vm.subcate_param)
			},
			getFeeds(subcate) {
				var vm = this
				var link = vm.link_subcate_question + "/" + subcate
				axios.get(link).then((response) => {
					vm.feeds = response.data.feeds
				})
			},
			getCateQuestion() {
				var vm = this
				axios.get(vm.link_cate_question).then((response) => {
					vm.catequestion = response.data
					var i
					for(i = 0 ; i< vm.catequestion.length; i++) {
						vm.catequestion[i]['color'] = vm.getColor()
					}
				})
				
			},
			getColor() {
				return '#' + Math.random().toString(16).slice(2, 8)
			},
			addQuestion() {
				var vm = this
				if(vm.current_user) {
					$('.showQuestionForm').css('display', 'inline-block')
					$('#imgQuestion').css('display', 'none')
				} else {
					vm.$router.push({ name: 'ClientLogin' })
				}
				
			},
			addQuestionFun() {
				var vm = this
				if(vm.select_cate && vm.select_subcate && vm.point_set && vm.title_question && vm.content_question) {
					var data = {
						cate: vm.select_cate,
						subcate: vm.select_subcate,
						title: vm.title_question,
						content: vm.content_question,
						point_set: vm.point_set,
						imageData: vm.dataImageQuestion
					}
					axios.post(vm.link_post_feed, data, { headers: { Authorization: 'Bearer ' + this.$authjs.getToken() }}).then((response) => {
						if(response.data.error) {
							vm.$swal("Error!", response.data.error, "error", {
		                      button: "OK!",
		                    })
						} else {
							vm.$swal("Success!", response.data.success, "success", {
		                      button: "OK!",
		                    })
							vm.$router.go()
						}
					})
				} else {
					vm.$swal("Error!", 'Bạn cần điền đủ thông tin', "error", {
                      button: "OK!",
                    })
				}
			},
			sort_custom() {
				var vm = this
				axios.get(vm.feeds.path, { params: { sort_key: vm.sort_by } }).then((response) => {
					vm.feeds = response.data.feeds
				})
			},
			select_cate_fun() {
				var vm = this
				vm.subcatequestion = null
				axios.get(vm.link_cate_question + '/' + vm.select_cate).then((response) => {
					vm.subcatequestion = response.data.subcatequestion
					$('.div_select_subcate').css('display', 'inline')
				})
			},
			doRefresh() {
				var vm = this
				axios.get(vm.feeds.path, { params: { sort_key: vm.sort_by } }).then((response) => {
					vm.feeds = response.data.feeds
				})
			},
			removeImageData() {
				var vm = this
				vm.dataImageQuestion = null
				$('#imgQuestion').css('display', 'none')
				$('.file-return').html('')
				$('.remove-add-image').css('display', 'none')
			},
			cancel_resize_add() {
				var vm = this
				if(vm.zoom) {
					$('.showQuestionForm').css('top', '20%')
					vm.zoom = false
				} else {
					$('.showQuestionForm').css('top', "")
					vm.zoom = true
				}
			},
			cancel_minify_add() {
				var vm = this
				if(vm.minify) {
					$('.showQuestionForm').css('top', '90%')
					vm.minify = false
				} else {
					$('.showQuestionForm').css('top', "")
					vm.minify = true
				}
			},
			cancel_form_add() {
				$('.showQuestionForm').css('display', 'none')
			},
			changeImage(event) {
				var vm = this
				vm.dataImageQuestion = null
				if(event.target.files[0]) {
					$('.file-return').html(event.target.value)
					let fileReader = new FileReader()
	        		fileReader.readAsDataURL(event.target.files[0])

	        		fileReader.onload = (e) => {
                        let dataImage = e.target.result
			        	vm.dataImageQuestion = dataImage
                    }
                    $('#imgQuestion').css('display', 'inline')
                    $('#imgQuestion img').css('max-width', '200px')
	        		$('.remove-add-image').css('display', 'inline')
                    

				} else {
					vm.dataImageQuestion = null
					$('#imgQuestion').css('display', 'none')
					$('.file-return').html('')
                    $('.remove-add-image').css('display', 'none')
				}
				
			},
			goNext() {
				var vm = this
				if(vm.feeds.next_page_url) {
					axios.get(vm.feeds.next_page_url, { params: { sort_key: vm.sort_by } }).then((response) => {
						vm.feeds = response.data.feeds
					})
				}
			},
			goPrev() {
				var vm = this
				if(vm.feeds.prev_page_url) {
					axios.get(vm.feeds.prev_page_url, { params: { sort_key: vm.sort_by } }).then((response) => {
						vm.feeds = response.data.feeds
					})
				}
			},
			goTo(e) {
				var vm = this
				if(e.target.value > 0 && e.target.value <= vm.feeds.last_page) {
					var params = {
						sort_key: vm.sort_by
					}
					var urlGoTo = vm.feeds.path + "?page=" + e.target.value
					axios.get(urlGoTo, { params: { sort_key: vm.sort_by } }).then((response) => {
						vm.feeds = response.data.feeds
					})
				}
			},
			changeSubCate(e) {
				var vm = this
				vm.subcate_param = e
				vm.getFeeds(vm.subcate_param)
			}
		}
	}
</script>	