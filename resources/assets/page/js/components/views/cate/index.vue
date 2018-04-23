<template>
	<div class="container">
		<div class="row" v-if="category">
        <div class="col-md-9 col-sm-12 col-xs-12">
            <div class="heading-block col-sm-12">
                <a><router-link  :to="{ name: 'ClientIndex' }">Trang chủ </router-link></a>|
                <a><router-link  :to="{ name: 'ClientCateIndex', params: { slugCate: category.slug } }">{{ category.name }}</router-link></a>
            </div>
            <div class="col-md-12 subcategory-description">
                <p v-html="category.description"></p>
            </div>
            <div v-for="subcategory in category.subcategory">
            <!--Các bài đăng mới -->
	            <div class="col-sm-12">
	                <div class="row">

	                    <h2><a><router-link  :to="{ name: 'ClientSubCateIndex', params: { slugSubCate: subcategory.slug } }">{{ subcategory.name }}</router-link></a></h2>
	         
	                    <p v-html="subcategory.description"></p>
	                </div>
	            </div>
            </div>
            <!--End các bài -->

        </div>

        <div class="col-md-3 hidden-sm hidden-xs">
            <!-- BETA MODE -->
        </div>
		</div>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				category: '',
				link: '',
			}
		},
		created() {
			this.link = '/api/client/category/' + this.$route.params.slugCate
			this.fetchData()
		},
		methods: {
			fetchData() {
				var vm = this
				axios.get(vm.link).then((response) => {
					vm.category = response.data
				}, (error) => {
					this.$router.push({ name: 'ClientIndex' })
				})
			}
		}
	}
</script>