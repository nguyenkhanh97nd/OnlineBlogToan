<template>
<div id="app">
<h2>{{ 'Categories' }}</h2>
<div class="row title-count">
	  <div class="col-md-2 col-sm-4 col-xs-6 tile-stats-count">
      <span class="count-top"><span class="glyphicon glyphicon-user"></span> Total Categories</span>
      <div class="count">{{ categories.total }}</div>
      <span class="count-bottom"><font color="#42b72a">{{ '+' + categories.total }}</font> In this week</span>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6 tile-stats-count">
      <span class="count-top"><span class="glyphicon glyphicon-folder-close"></span> Active Categories</span>
      <div class="count">{{ active_categories.length }}</div>
      <span class="count-bottom"><font color="#42b72a">{{ '+' + active_categories.length }}</font> In this week</span>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6 tile-stats-count">
      <span class="count-top"><span class="glyphicon glyphicon-folder-close"></span> Disable Categories</span>
      <div class="count">{{ disable_categories.length }}</div>
      <span class="count-bottom"><font color="#42b72a">{{ '+' + disable_categories.length }}</font> In this week</span>
    </div>
</div>
<h2>{{ 'SubCategories' }}</h2>
<div class="row title-count">
    <div class="col-md-2 col-sm-4 col-xs-6 tile-stats-count">
      <span class="count-top"><span class="glyphicon glyphicon-user"></span> Total SubCategories</span>
      <div class="count">{{ subcategories.total }}</div>
      <span class="count-bottom"><font color="#42b72a">{{ '+' + subcategories.total }}</font> In this week</span>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6 tile-stats-count">
      <span class="count-top"><span class="glyphicon glyphicon-folder-close"></span> Active SubCategories</span>
      <div class="count">{{ active_subcategories.length }}</div>
      <span class="count-bottom"><font color="#42b72a">{{ '+' + active_subcategories.length }}</font> In this week</span>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6 tile-stats-count">
      <span class="count-top"><span class="glyphicon glyphicon-folder-close"></span> Disable SubCategories</span>
      <div class="count">{{ disable_subcategories.length }}</div>
      <span class="count-bottom"><font color="#42b72a">{{ '+' + disable_subcategories.length }}</font> In this week</span>
    </div>
</div>

<h2>{{ 'Posts' }}</h2>
<div class="row title-count">
    <div class="col-md-2 col-sm-4 col-xs-6 tile-stats-count">
      <span class="count-top"><span class="glyphicon glyphicon-user"></span> Total Posts</span>
      <div class="count">{{ posts.total }}</div>
      <span class="count-bottom"><font color="#42b72a">{{ '+' + posts.total }}</font> In this week</span>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6 tile-stats-count">
      <span class="count-top"><span class="glyphicon glyphicon-folder-close"></span> Active Posts</span>
      <div class="count">{{ active_posts.length }}</div>
      <span class="count-bottom"><font color="#42b72a">{{ '+' + active_posts.length }}</font> In this week</span>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6 tile-stats-count">
      <span class="count-top"><span class="glyphicon glyphicon-folder-close"></span> Disable Posts</span>
      <div class="count">{{ disable_posts.length }}</div>
      <span class="count-bottom"><font color="#42b72a">{{ '+' + disable_posts.length }}</font> In this week</span>
    </div>
</div>

<h2>{{ 'Questions' }}</h2>
<div class="row title-count">
    <div class="col-md-2 col-sm-4 col-xs-6 tile-stats-count">
      <span class="count-top"><span class="glyphicon glyphicon-user"></span> Post Has Questions</span>
      <div class="count">{{ bquestions.total }}</div>
      <span class="count-bottom"><font color="#42b72a">{{ '+' + bquestions.total }}</font> In this week</span>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6 tile-stats-count">
      <span class="count-top"><span class="glyphicon glyphicon-folder-close"></span> Total Questions</span>
      <div class="count">{{ allquestions.length }}</div>
      <span class="count-bottom"><font color="#42b72a">{{ '+' + allquestions.length }}</font> In this week</span>
    </div>
</div>

<h2>{{ 'Comments' }}</h2>
<div class="row title-count">
    <div class="col-md-2 col-sm-4 col-xs-6 tile-stats-count">
      <span class="count-top"><span class="glyphicon glyphicon-user"></span> Comments</span>
      <div class="count">{{ comments.total }}</div>
      <span class="count-bottom"><font color="#42b72a">{{ '+' + comments.total }}</font> In this week</span>
    </div>
</div>

<h2>{{ 'Users' }}</h2>
<div class="row title-count">
    <div class="col-md-2 col-sm-4 col-xs-6 tile-stats-count">
      <span class="count-top"><span class="glyphicon glyphicon-user"></span> Total Users</span>
      <div class="count">{{ users.total }}</div>
      <span class="count-bottom"><font color="#42b72a">{{ '+' + users.total }}</font> In this week</span>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6 tile-stats-count">
      <span class="count-top"><span class="glyphicon glyphicon-folder-close"></span> Admins</span>
      <div class="count">{{ admin.length }}</div>
      <span class="count-bottom"><font color="#42b72a">{{ '+' + admin.length }}</font> In this week</span>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6 tile-stats-count">
      <span class="count-top"><span class="glyphicon glyphicon-folder-close"></span> Editors</span>
      <div class="count">{{ editor.length }}</div>
      <span class="count-bottom"><font color="#42b72a">{{ '+' + editor.length }}</font> In this week</span>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6 tile-stats-count">
      <span class="count-top"><span class="glyphicon glyphicon-folder-close"></span> Members</span>
      <div class="count">{{ member.length }}</div>
      <span class="count-bottom"><font color="#42b72a">{{ '+' + member.length }}</font> In this week</span>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6 tile-stats-count">
      <span class="count-top"><span class="glyphicon glyphicon-signal"></span> Banned</span>
      <div class="count">{{ banned.length }}</div>
      <span class="count-bottom"><font color="#42b72a">{{ '+' + banned.length }}</font> In this week</span>
    </div>
</div>

<h2>{{ 'Data Test' }}</h2>
<div class="row title-count">
    <div class="col-md-2 col-sm-4 col-xs-6 tile-stats-count">
      <span class="count-top"><span class="glyphicon glyphicon-user"></span> Total Data Test</span>
      <div class="count">{{ bdatas.total }}</div>
      <span class="count-bottom"><font color="#42b72a">{{ '+' + bdatas.total }}</font> In this week</span>
    </div>
</div>

</div>
</template>

<script>
	export default {
		data() {
			return {
				user_link : '',
				users : '',
        admin: '',
        editor: '',
        member: '',
        banned: '',

				cate_link: '',
				categories: '',
        active_categories: '',
        disable_categories: '',

				subcate_link: '',
				subcategories: '',
        active_subcategories: '',
        disable_subcategories: '',

				post_link: '',
				posts: '',
        active_posts: '',
        disable_posts: '',

				bquestion_link: '',
				bquestions: '',
        allquestions: '',

        comment_link: '',
        comments: '',

				bdata_link: '',
				bdatas: '',

			}
		},
		mounted() {
			let vm = this
			vm.user_link = '/api/member'
			vm.cate_link = '/api/category'
			vm.subcate_link = '/api/subcategory'
			vm.post_link = '/api/posts'
			vm.bquestion_link = '/api/questions',
      vm.comment_link = '/api/comment'
			vm.bdata_link = '/api/bdata'
			vm.fetchData()
		},
		methods: {
			fetchData() {
				var vm = this
        var token = this.$auth.getToken()
				    axios.get(vm.user_link, { headers: { Authorization: 'Bearer'+ " " + token }})
              .then((response) => {
                var res = response.data, i, j = 0, k = 0, h = 0, m = 0, admin = new Array(), editor = new Array(), member = new Array(), banned = new Array()
                for(i=0; i<res.total; i++) {
                    if(res.data[i].level == 1) {
                        admin[j] = res.data[i]
                        j++
                    } else if(res.data[i].level == 2) {
                        editor[k] = res.data[i]
                        k++
                    } else {
                        member[h] = res.data[i]
                        h++
                    }
                    if(res.data[i].status == 0) {
                        banned[m] = res.data[i]
                        m++
                    }
                }
                vm.users = res
                vm.admin = admin
                vm.editor = editor
                vm.member = member
                vm.banned = banned
            })
            axios.get(vm.cate_link, { headers: { Authorization: 'Bearer'+ " " + token }})
              .then((response) => {
                var res = response.data, i, j = 0, k = 0, activeCate = new Array(), disableCate = new Array()
                for(i=0; i<res.total; i++) {
                    if(res.data[i].status == 1) {
                        activeCate[j] = res.data[i]
                        j++
                    } else {
                        disableCate[k] = res.data[i]
                        k++
                    }
                }
                vm.categories = res
                vm.active_categories = activeCate
                vm.disable_categories = disableCate
            })
            axios.get(vm.subcate_link, { headers: { Authorization: 'Bearer'+ " " + token }})
              .then((response) => {
                var res = response.data, i, j = 0, k = 0, activeSubCate = new Array(), disableSubCate = new Array()
                for(i=0; i<res.total; i++) {
                    if(res.data[i].status == 1) {
                        activeSubCate[j] = res.data[i]
                        j++
                    } else {
                        disableSubCate[k] = res.data[i]
                        k++
                    }
                }
                vm.subcategories = res
                vm.active_subcategories = activeSubCate
                vm.disable_subcategories = disableSubCate
            })
            axios.get(vm.post_link, { headers: { Authorization: 'Bearer'+ " " + token }})
              .then((response) => {
                var res = response.data, i, j = 0, k = 0, activePost = new Array(), disablePost = new Array()
                for(i=0; i<res.total; i++) {
                    if(res.data[i].status == 1) {
                        activePost[j] = res.data[i]
                        j++
                    } else {
                        disablePost[k] = res.data[i]
                        k++
                    }
                }
                vm.posts = res
                vm.active_posts = activePost
                vm.disable_posts = disablePost
            })
            axios.get(vm.bquestion_link, { headers: { Authorization: 'Bearer'+ " " + token }})
              .then((response) => {
                var res = response.data, i, j, k = 0, allquestions = new Array()
                for(i=0; i<res.total; i++) {
                    for(j=0; j<res.data[i].question.length; j++) {
                        allquestions[k] = res.data[i].question
                        k++
                    }
                }
                vm.bquestions = res
                vm.allquestions = allquestions
            })
            axios.get(vm.comment_link, { headers: { Authorization: 'Bearer'+ " " + token }})
              .then((response) => {
                var res = response.data
                vm.comments = res
              })
            axios.get(vm.bdata_link, { headers: { Authorization: 'Bearer'+ " " + token }})
              .then((response) => {
                var res = response.data
                vm.bdatas = res
            })
			}
		}
	}
</script>