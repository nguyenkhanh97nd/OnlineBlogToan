<template>
  <div id="root">
    <h2>{{ title }}</h2>
    <div class="col-xs-10 row" style="padding-bottom:10px">
        <input @input="updateSearch()" v-model="search" type="text" class="form-control" placeholder="Search for...">
    </div>

    <table class="table table-bordered">
        <thead>
            <tr align="center">
                <th>ID Post</th>
                <th>ID User</th>
                <th>Username</th>
                <th>Post</th>
                <th>Point</th>
                <th>Status</th>
                <th>Created at</th>
                <th>Last updated</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody v-for="bdata in bdatas.data">
            <tr class="table-content" align="center">
                <td>{{ bdata.post.id }}</td>
                <td>{{ bdata.user.id }}</td>
                <td>{{ bdata.user.username }}</td>
                <td>{{ bdata.post.name }}</td>
                <td>{{ bdata.point_exam + '/' + bdata.post.question.length }}</td>
                <td v-if="bdata.status == 1 && bdata.submit == 1">{{ 'Online - Submited' }}</td>
                <td v-if="bdata.status == 1 && bdata.submit == 0">{{ 'Online - Testing' }}</td>
                <td v-if="bdata.status == 10 && bdata.submit == 1">{{ 'Offline - Submited' }}</td>
                <td v-if="bdata.status == 10 && bdata.submit == 0">{{ 'Offline - Testing' }}</td>
                <td>{{ parseTime(bdata.created_at)  }}</td>
                <td>{{ parseTime(bdata.updated_at) }}</td>
                <td class="is-delete center"><ConfirmModal
                    url="/api/bdata/"
                    :dataSend="bdata.id"
                    message="Confirm Delete bdata?"
                    spanText="<span class='glyphicon glyphicon-trash'></span><span> Delete</span>"
                    spanClass="btn-danger"
                    ></ConfirmModal></td>
            </tr>
        </tbody>
    </table>

    <div class="panel-footer pagination-footer">
        <div class="pagination-item">
            <span>Per page: {{ bdatas.per_page }}</span>
        </div>
        <div class="pagination-item">
            <small>Showing {{bdatas.from}} - {{bdatas.to}} of {{bdatas.total}}</small>
        </div>
        <div class="pagination-item">
            <small>Current page: </small>
            <input type="text" class="pagination-input" v-model="bdatas.current_page"
                @keyup.enter="goTo()">
            <small> of {{bdatas.last_page}}</small>
        </div>
        <div class="pagination-item">
            <button v-if="bdatas.prev_page_url" @click="prev()" class="btn btn-default btn-sm">Prev</button>
            <button v-if="bdatas.next_page_url" @click="next()" class="btn btn-default btn-sm">Next</button>
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
            bdatas: [],
            title: "Data Test",
            search: '',
            link: ''
          }
        },
        mounted() {
            this.link = '/api/bdata'
            this.fetchData()
        },
        methods: {
            parseTime(date) {
                return moment(date).format('DD-MM-YYYY HH:mm:ss')
            },
            fetchData() {
                var vm = this
                axios.get(vm.link,  { headers: { Authorization: 'Bearer'+ " " + this.$auth.getToken() }}).then((response) => {
                    vm.bdatas = response.data
                })
            },
            updateSearch() {
                if(this.search!='') {
                    this.link = '/api/bdata/search/'+ this.search
                } else {
                    this.link = '/api/bdata'
                }
                this.fetchData();
            }
            ,
            next() {
                if(this.bdatas.next_page_url) {
                    this.link = this.bdatas.next_page_url
                    this.fetchData()
                }
            },
            prev() {
                if(this.bdatas.prev_page_url) {
                    this.link = this.bdatas.prev_page_url
                    this.fetchData()
                }
            },
            goTo() {
                
                if(this.bdatas.current_page <= this.bdatas.last_page) {
                    var prefix;
                    if(this.search != '') {
                        prefix = '/api/bdata/search/'+this.search+'?page='
                    } else {
                        prefix = '/api/bdata?page='
                    }
                    this.link = prefix+this.bdatas.current_page
                    this.fetchData()
                }
            }
        }
      }
      
</script>