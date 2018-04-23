<template>
	<div class="container">
		<div class="row">

        <div class="col-sm-9 col-xs-12">
                <div class="heading-block col-sm-12">
                    <span>Tìm kiếm: </span>

                    <div class="pull-right search-friend" @input="search">
                        <input class="form-control" v-model="searchPost" name="searchPost" type="text" placeholder="Tìm kiếm bài viết">
                    </div>
                </div>
                
                <div v-if="posts && searchPost">
                <div v-for="post in posts.data">
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
                	<!--TODO more-->
                <center>
                    <a v-if="posts.next_page_url" class="text-center" id="loadMore" @click="loadMoreFun">Xem thêm</a> 
                </center>
                </div>
        </div>
        <div class="col-sm-3 hidden-xs">
            
        </div>

	</div>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				posts: '', 
				searchPost: '',
				link: ''
			}
		},
		created() {
			this.link = 'api/client/searchPost'
		},
		methods: {
			
			search() {
				var vm = this
				var data = {
					keyword: vm.searchPost
				}
				axios.post(vm.link, data).then((response) => {
					vm.posts = response.data.posts
				}, (error) => {
					vm.$swal("Error!", "Lỗi!", "error", {
                      button: "OK!",
                    })
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