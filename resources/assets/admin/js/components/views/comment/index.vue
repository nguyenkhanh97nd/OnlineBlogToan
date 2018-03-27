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
                <th>Name</th>
                <th>Post</th>
                <th>Content</th>
                <th>Created at</th>
                <th>Last updated</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody v-for="comment in comments.data">
            <tr class="table-content" align="center">
                <td>{{ comment.id }}</td>
                <td>{{ comment.user.name }}</td>
                <td>{{ comment.post.name }}</td>
                <td>{{ comment.content }}</td>
                <td>{{ parseTime(comment.created_at)  }}</td>
                <td>{{ parseTime(comment.updated_at) }}</td>
                <td class="is-delete center"><ConfirmModal
                    url="/api/comment/"
                    :dataSend="comment.id"
                    message="Confirm Delete Comment?"
                    spanText="<span class='glyphicon glyphicon-trash'></span><span> Delete</span>"
                    spanClass="btn-danger"
                    ></ConfirmModal></td>
            </tr>
        </tbody>
    </table>

    <div class="panel-footer pagination-footer">
        <div class="pagination-item">
            <span>Per page: {{ comments.per_page }}</span>
        </div>
        <div class="pagination-item">
            <small>Showing {{comments.from}} - {{comments.to}} of {{comments.total}}</small>
        </div>
        <div class="pagination-item">
            <small>Current page: </small>
            <input type="text" class="pagination-input" v-model="comments.current_page"
                @keyup.enter="goTo()">
            <small> of {{comments.last_page}}</small>
        </div>
        <div class="pagination-item">
            <button v-if="comments.prev_page_url" @click="prev()" class="btn btn-default btn-sm">Prev</button>
            <button v-if="comments.next_page_url" @click="next()" class="btn btn-default btn-sm">Next</button>
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
            comments: [],
            title: "Comments",
            search: '',
            link: ''
          }
        },
        mounted() {
            this.link = '/api/comment'
            this.fetchData()
        },
        methods: {
            parseTime(date) {
                return moment(date).format('DD-MM-YYYY HH:mm:ss')
            },
            fetchData() {
                var vm = this
                axios.get(vm.link,  { headers: { Authorization: 'Bearer'+ " " + this.$auth.getToken() }}).then((response) => {
                    vm.comments = response.data
                })
            },
            updateSearch() {
                if(this.search!='') {
                    this.link = '/api/comment/search/'+ this.search
                } else {
                    this.link = '/api/comment'
                }
                this.fetchData();
            }
            ,
            next() {
                if(this.comments.next_page_url) {
                    this.link = this.comments.next_page_url
                    this.fetchData()
                }
            },
            prev() {
                if(this.comments.prev_page_url) {
                    this.link = this.comments.prev_page_url
                    this.fetchData()
                }
            },
            goTo() {
                
                if(this.comments.current_page <= this.comments.last_page) {
                    var prefix;
                    if(this.search != '') {
                        prefix = '/api/comment/search/'+this.search+'?page='
                    } else {
                        prefix = '/api/comment?page='
                    }
                    this.link = prefix+this.comments.current_page
                    this.fetchData()
                }
            }
        }
      }
      
</script>