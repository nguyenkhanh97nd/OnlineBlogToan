<template>
	<div class="container">
	<div class="row" v-if="posts">
		<div class="col-md-3 hidden-xs hidden-sm">
			<p class="heading-title">NỔI BẬT</p>
			<ul class="list-unstyled" v-for="featurePost in featurePosts">
				<li class="feature-index container-fluid">
				<div class="row">
				<div class="col-md-10">
					<div class="row">
						<a><router-link  :to="{ name: 'ClientPostIndex', params: {slugSubCate: featurePost.subcategory.slug, slugPost: featurePost.slug } }">{{ featurePost.name }}</router-link></a>
					</div>
				</div>
				<div class="col-md-2">
					<div class="row">
						<span class="pull-right"><font color="#f1004c">{{ featurePost.count_views }}</font></span>
					</div>
				</div>
				</div>
				</li>
			</ul>
		</div>
	
		<div class="col-md-6 col-xs-12">
			<p class="heading-title">BÀI VIẾT MỚI</p>
			
			<div v-for="post in posts.data">

			<div class="content-item-index col-sm-12">
				<div class="col-sm-12">
					<h2><a><router-link  :to="{ name: 'ClientPostIndex', params: {slugSubCate: post.subcategory.slug, slugPost: post.slug } }">{{ post.name }}</router-link></a></h2>
				</div>
				<div class="meta-item-index col-sm-12">
					<span>Tác giả: {{ post.author.name }}</span>
					<span>Ngày: {{ post.created_at }}</span>
					<span>Chuyên mục: <a><router-link  :to="{ name: 'ClientSubCateIndex', params: {slugSubCate: post.subcategory.slug} }">{{ post.subcategory.name }}</router-link></a></span>
					<span>Lượt xem: {{ post.count_views }}</span>
				</div>
				<div class="col-sm-12">
					<div class="col-sm-5 media">
						<a><router-link  :to="{ name: 'ClientPostIndex', params: {slugSubCate: post.subcategory.slug, slugPost: post.slug } }"><img class="img-responsive" :src="'public/upload/posts/' + post.image"/></router-link></a>
					</div>
					<div class="col-sm-7 caption">
						 <p v-html="post.brief"></p>
					</div>
				</div>
			</div>
			
			</div>
			<!--End các bài -->
		<!--Loading -->
			<center>
                <a v-if="posts.next_page_url" class="text-center" id="loadMore" @click="loadMoreFun">Xem thêm</a> 
            </center>

		</div>
		<div class="col-md-3 hidden-xs hidden-sm">
			<p class="heading-title">RANKING</p>

			<ul class="list-unstyled" v-for="(user_sort, key) in users_sort">
				
				<li class="feature-index container-fluid">
					<div class="col-md-2">
						<span class="pull-left">{{ (key+1) }}. </span>
					</div>
					<div class="col-md-8 text-center">
						<a><router-link  :to="{ name: 'ClientProfileIndex', params: {userslug: user_sort.username } }">
							
							{{ user_sort.username }}
						</router-link>
						</a>
					</div>
					<div class="col-md-2">
						<span class="pull-right"><font color="#f1004c">{{ user_sort.gpa }}</font></span>
					</div>
				</li>

			</ul>
			
			<p v-if="current_rank"><font color="#f1004c">Rank hiện tại: {{ current_rank }}</font></p>
			<p v-if="current_rank_status"><font color="#f1004c">Bạn cần {{ current_rank_status }} bài thi online nữa để xếp hạng</font></p>
		</div>
	</div>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				isAuthenticated: false,
				current_rank: '',
				current_rank_status: '',
				users_sort: '',
				posts: '',
				featurePosts: '',
				link_posts: '',
				link_rank: '',
			}
		},
		mounted() {
			this.link_posts = 'api/client/posts'
			if(this.$authjs.isAuthenticated()) {
				this.isAuthenticated = true
				this.link_rank = 'api/client/getRank'
				this.getRank()
			} else {
				this.isAuthenticated = false
			}
			this.fetchData()
		},
		methods: {
			fetchData() {
				var vm = this
				axios.get(vm.link_posts).then((response) => {
					vm.posts = response.data.posts
					vm.featurePosts = response.data.featurePosts
				})
			},
			getRank() {
				var vm = this
				if(vm.isAuthenticated) {
					var link = "/api/client/getRank"
					axios.get(link, { headers: { Authorization: 'Bearer ' + this.$authjs.getToken() }})
					.then((response) =>  {
						vm.users_sort = response.data.users_sort
						if(response.data.current_rank) {
							vm.current_rank = response.data.current_rank
						} else if(response.data.current_rank_status) {
							vm.current_rank_status = response.data.current_rank_status
						}
					})
				}
			},
			
            loadMoreFun() {
                var vm = this
                var link = vm.posts.next_page_url
                if(link) {
                    axios.get(link, { headers: { Authorization: 'Bearer ' + this.$authjs.getToken() }}).then((response) => {
                        var res = response.data.posts

                        vm.posts.next_page_url = res.next_page_url
                        for(var i = 0; i < res.data.length; i++) {
                            var check = true
                            for(var j = 0; j < vm.posts.data.length; j++) {
                                if(vm.posts.data[j].id == res.data[i].id) {
                                    check = false;
                                    break;
                                }
                            }
                            if(check) {
                                vm.posts.data.push(res.data[i])
                            }
                            
                        }

                    })
                }
            }
		}
		
	}
</script>