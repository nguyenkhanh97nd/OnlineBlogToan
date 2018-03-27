<template>
  <div id="root">
    <h2>{{ title }}</h2>
    <div class="col-xs-10 row" style="padding-bottom:10px">
        <input @input="updateSearch()" v-model="search" type="text" class="form-control" placeholder="Search for...">
    </div>
    <button @click="$router.push({ name: 'AdminCateQuestionCreate' })" class="btn btn-info col-xs-2 pull-right">New</button>

    <table class="table table-bordered">
        <thead>
            <tr align="center">
                <th>ID</th>
                <th>Name</th>
                <th>Slug</th>
                <th>Descriptions</th>
                <th>Created at</th>
                <th>Last updated</th>
                <th>Delete</th>
                <th>Edit</th>
            </tr>
        </thead>
        <tbody v-for="cate in catequestion.data">
            <tr class="table-content" align="center">
                <td>{{ cate.id }}</td>
                <td>{{ cate.name }}</td>
                <td>{{ cate.slug }}</td>
                <td v-html="cate.description"></td>
                <td>{{ parseTime(cate.created_at)  }}</td>
                <td>{{ parseTime(cate.updated_at) }}</td>
                <td class="is-delete center"><ConfirmModal
                    url="/api/catequestion/"
                    :dataSend="cate.id"
                    message="Confirm Delete Cate Question?"
                    spanText="<span class='glyphicon glyphicon-trash'></span><span> Delete</span>"
                    spanClass="btn-danger"
                    ></ConfirmModal></td>
                <td class="is-edit center"> <router-link :to="{ name: 'AdminCateQuestionEdit', params:{id: cate.id } }"><span class="btn btn-xs btn-info"><span class='glyphicon glyphicon-pencil'></span><span> Edit</span></span></router-link></td>
            </tr>
        </tbody>
    </table>

    <div class="panel-footer pagination-footer">
        <div class="pagination-item">
            <span>Per page: {{ catequestion.per_page }}</span>
        </div>
        <div class="pagination-item">
            <small>Showing {{catequestion.from}} - {{catequestion.to}} of {{catequestion.total}}</small>
        </div>
        <div class="pagination-item">
            <small>Current page: </small>
            <input type="text" class="pagination-input" v-model="catequestion.current_page"
                @keyup.enter="goTo()">
            <small> of {{catequestion.last_page}}</small>
        </div>
        <div class="pagination-item">
            <button v-if="catequestion.prev_page_url" @click="prev()" class="btn btn-default btn-sm">Prev</button>
            <button v-if="catequestion.next_page_url" @click="next()" class="btn btn-default btn-sm">Next</button>
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
            catequestion: [],
            title: "Cate Questions",
            search: '',
            link: ''
          }
        },
        mounted() {
            this.link = '/api/catequestion'
            this.fetchData()
        },
        methods: {
            parseTime(date) {
                return moment(date).format('DD-MM-YYYY HH:mm:ss')
            },
            fetchData() {
                var vm = this
                axios.get(vm.link, { headers: { Authorization: 'Bearer'+ " " + this.$auth.getToken() }}).then((response) => {
                    vm.catequestion = response.data
                })
            },
            updateSearch() {
                if(this.search!='') {
                    this.link = '/api/catequestion/search/'+ this.search
                } else {
                    this.link = '/api/catequestion'
                }
                this.fetchData();
            }
            ,
            next() {
                if(this.catequestion.next_page_url) {
                    this.link = this.catequestion.next_page_url
                    this.fetchData()
                }
            },
            prev() {
                if(this.catequestion.prev_page_url) {
                    this.link = this.catequestion.prev_page_url
                    this.fetchData()
                }
            },
            goTo() {
                
                if(this.catequestion.current_page <= this.catequestion.last_page) {
                    var prefix;
                    if(this.search != '') {
                        prefix = '/api/catequestion/search/'+this.search+'?page='
                    } else {
                        prefix = '/api/catequestion?page='
                    }
                    this.link = prefix+this.catequestion.current_page
                    this.fetchData()
                }
            }
        }
      }
      
</script>