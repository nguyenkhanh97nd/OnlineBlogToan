<template>
  <div id="root">
    <h2>{{ title }}</h2>
    <div class="col-xs-10 row" style="padding-bottom:10px">
        <input @input="updateSearch()" v-model="search" type="text" class="form-control" placeholder="Search for...">
    </div>

    <table class="table table-bordered">
        <thead>
            <tr align="center">
                <th>ID</th>
                <th>Image</th>
                <th>Name</th>
                <th>Slug</th>
                <th>Time Start</th>
                <th>Time Do</th>
                <th>Brief</th>
                <th>Category</th>
				<th>Sub Category</th>
				<th>Author</th>
				<th>Views</th>
				<th>Status</th>
                <th>Created at</th>
                <th>Last updated</th>
                <th>Delete</th>
                <th>Edit</th>
            </tr>
        </thead>
        <tbody v-for="post in posts.data">
            <tr class="table-content" align="center">
                <td>{{ post.id }}</td>
                <td><img class="img-posts-admin" :src="'/upload/posts/'+post.image"/></td>
                <td>{{ post.name }}</td>
                <td>{{ post.slug }}</td>
                <td>{{ parseDate(post.time_start) }}</td>
                <td>{{ post.time_do }}</td>
				<td>{{ post.brief }}</td>
				<td>{{ post.subcategory.category.name }}</td>
				<td>{{ post.subcategory.name }}</td>
				<td>{{ post.author.name }}</td>
				<td>{{ post.count_views }}</td>
				<td>{{ post.status == 1 ? 'Active' : 'Pending' }}</td>
                <td>{{ parseDate(post.created_at)  }}</td>
                <td>{{ parseDate(post.updated_at) }}</td>
                <td class="is-delete center"><ConfirmModal
                    url="/api/pendingposts/"
                    :dataSend="post.id"
                    message="Confirm Delete Post?"
                    spanText="<span class='glyphicon glyphicon-trash'></span><span> Delete</span>"
                    spanClass="btn-danger"
                    ></ConfirmModal></td>
                <td class="is-edit center"> <router-link :to="{ name: 'AdminPendingPostsEdit', params:{id: post.id } }"><span class="btn btn-xs btn-info"><span class='glyphicon glyphicon-pencil'></span><span> Edit</span></span></router-link></td>
            </tr>
        </tbody>
    </table>

    <div class="panel-footer pagination-footer">
        <div class="pagination-item">
            <span>Per page: {{ posts.per_page }}</span>
        </div>
        <div class="pagination-item">
            <small>Showing {{posts.from}} - {{posts.to}} of {{posts.total}}</small>
        </div>
        <div class="pagination-item">
            <small>Current page: </small>
            <input type="text" class="pagination-input" v-model="posts.current_page"
                @keyup.enter="goTo()">
            <small> of {{posts.last_page}}</small>
        </div>
        <div class="pagination-item">
            <button v-if="posts.prev_page_url" @click="prev()" class="btn btn-default btn-sm">Prev</button>
            <button v-if="posts.next_page_url" @click="next()" class="btn btn-default btn-sm">Next</button>
        </div>
    </div>
    
  </div>
</template>

<script>

import ConfirmModal from '../blocks/confirm.vue'

      export default {
        components: { ConfirmModal },
        data () {
          return {
            posts: [],
            title: "Pending Posts",
            search: '',
            link: ''
          }
        },
        mounted() {
            this.link = '/api/pendingposts'
            this.fetchData()
        },
        methods: {
            parseDate(date) {
                return moment(date).format('DD-MM-YYYY HH:mm:ss')
            },
            fetchData() {
                var vm = this
                axios.get(vm.link, { headers: { Authorization: 'Bearer'+ " " + this.$auth.getToken() }}).then((response) => {
                    vm.posts = response.data
                })
            },
            updateSearch() {
                if(this.search!='') {
                    this.link = '/api/pendingposts/search/'+ this.search
                } else {
                    this.link = '/api/pendingposts'
                }
                this.fetchData();
            }
            ,
            next() {
                if(this.posts.next_page_url) {
                    this.link = this.posts.next_page_url
                    this.fetchData()
                }
            },
            prev() {
                if(this.posts.prev_page_url) {
                    this.link = this.posts.prev_page_url
                    this.fetchData()
                }
            },
            goTo() {
                
                if(this.posts.current_page <= this.posts.last_page) {
                    var prefix;
                    if(this.search != '') {
                        prefix = '/api/pendingposts/search/'+this.search+'?page='
                    } else {
                        prefix = '/api/pendingposts?page='
                    }
                    this.link = prefix+this.posts.current_page
                    this.fetchData()
                }
            }
        }
      }
      
</script>