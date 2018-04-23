<template>
	<div class="container">
		<div class="row" v-if="subcategory">
		    <div class="col-sm-9 col-xs-12">
		            <div class="heading-block col-sm-12">
		                <a><router-link  :to="{ name: 'ClientIndex' }">Trang chủ </router-link></a>|
		                <a><router-link  :to="{ name: 'ClientCateIndex', params: { slugCate: subcategory.category.slug } }">{{ subcategory.category.name }}</router-link></a> |
		                <a><router-link  :to="{ name: 'ClientSubCateIndex', params: { slugSubCate: subcategory.slug } }">{{ subcategory.name }}</router-link></a>
		            </div>
		            <div class="col-md-12 subcategory-description">
		                <p v-html="subcategory.description"></p>
		            </div>
		            <div v-for="post in posts.data">
		                <!--Các bài đăng mới -->
		                <div class="content-item-subcategory col-sm-12">
		                    <div class="row">
		                        <div class="col-sm-3 hidden-xs">
		                            <div class="row">
		                                <a><router-link  :to="{ name: 'ClientPostIndex', params: {slugSubCate: post.subcategory.slug, slugPost: post.slug } }"><img class="img-responsive" :src="'upload/posts/' + post.image"/></router-link></a>
		                            </div>
		                        </div>
		                        <div class="meta-content-single col-sm-9 col-xs-12 caption">
		                        	<a class="cate-post-title"><router-link  :to="{ name: 'ClientPostIndex', params: { slugSubCate: post.subcategory.slug, slugPost: post.slug } }">{{ post.name }}</router-link></a>

		                            <p>Tác giả: {{ post.author.name }} | Ngày: {{ post.created_at }} | Chuyên mục: <a><router-link  :to="{ name: 'ClientSubCateIndex', params: { slugSubCate: post.subcategory.slug } }">{{ post.subcategory.name }}</router-link></a> | Lượt xem: {{ post.count_views }}</p>
		                            <p class="cate-post-brief" v-html="post.brief"></p>
		                        </div>
		                    </div>
		                </div>
		            </div>
		            <!--End các bài -->
		            <!-- TODO more -->
		            <center>
                        <a v-if="posts.next_page_url" class="text-center" id="loadMore" @click="loadMoreFun">Xem thêm</a> 
                    </center>
		    </div>
		    <div class="col-sm-3 hidden-xs">
		        
		        <p class="heading-title">TOP XEM NHIỀU</p>
		        <div class="row">
		        <ul  class="list-unstyled" v-for="top_post in top_posts">
		            <div class="col-md-12">
		                <div class="row">
		                    <div class="col-md-5 text-center">
		                    	<a><router-link  :to="{ name: 'ClientPostIndex', params: {slugSubCate: top_post.subcategory.slug, slugPost: top_post.slug } }"><img class="img-responsive" :src="'upload/posts/' + top_post.image"/></router-link></a>
		                    </div>
		                    <div class="col-md-7">
		                        <p style="margin: 0">
		                            <span> <a><router-link  :to="{ name: 'ClientPostIndex', params: { slugSubCate: top_post.subcategory.slug, slugPost: top_post.slug } }"><font size="2">{{ top_post.name }}</font></router-link></a></span>
		                        </p>
		                        <p><font size="1">{{ top_post.created_at }}</font></p>
		                    </div>
		                </div>
		            </div>
		        </ul>
		        </div>
		    </div>

		</div>
	</div>
</template>
<script>
	export default {
		data() {
			return {
				link: '',
				subcategory: '',
				posts: '',
				top_posts: '',
			}
		},
		created() {
			this.link = '/api/client/subcategory/' + this.$route.params.slugSubCate
			this.fetchData()
		},
		methods: {
			fetchData() {
				var vm = this
				axios.get(vm.link).then((response) => {
					vm.subcategory = response.data.subcategory,
					vm.posts = response.data.posts,
					vm.top_posts = response.data.top_posts
				}, (error) => {
					this.$router.push({ name: 'ClientIndex' })
				})
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