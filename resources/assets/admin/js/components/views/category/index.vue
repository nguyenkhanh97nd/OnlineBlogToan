<template>
  <div id="root">
    <h2>{{ title }}</h2>
    <div class="col-xs-10 row" style="padding-bottom:10px">
        <input @input="updateSearch()" v-model="search" type="text" class="form-control" placeholder="Search for...">
    </div>
    <button @click="$router.push({ name: 'AdminCategoryCreate' })" class="btn btn-info col-xs-2 pull-right">New</button>

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
        <tbody v-for="category in categories.data">
            <tr class="table-content" align="center">
                <td>{{ category.id }}</td>
                <td>{{ category.name }}</td>
                <td>{{ category.slug }}</td>
                <td v-html="category.description"></td>
                <td>{{ parseTime(category.created_at)  }}</td>
                <td>{{ parseTime(category.updated_at) }}</td>
                <td class="is-delete center"><ConfirmModal
                    url="/api/category/"
                    :dataSend="category.id"
                    message="Confirm Delete Category?"
                    spanText="<span class='glyphicon glyphicon-trash'></span><span> Delete</span>"
                    spanClass="btn-danger"
                    ></ConfirmModal></td>
                <td class="is-edit center"> <router-link :to="{ name: 'AdminCategoryEdit', params:{id: category.id } }"><span class="btn btn-xs btn-info"><span class='glyphicon glyphicon-pencil'></span><span> Edit</span></span></router-link></td>
            </tr>
        </tbody>
    </table>

    <div class="panel-footer pagination-footer">
        <div class="pagination-item">
            <span>Per page: {{ categories.per_page }}</span>
        </div>
        <div class="pagination-item">
            <small>Showing {{categories.from}} - {{categories.to}} of {{categories.total}}</small>
        </div>
        <div class="pagination-item">
            <small>Current page: </small>
            <input type="text" class="pagination-input" v-model="categories.current_page"
                @keyup.enter="goTo()">
            <small> of {{categories.last_page}}</small>
        </div>
        <div class="pagination-item">
            <button v-if="categories.prev_page_url" @click="prev()" class="btn btn-default btn-sm">Prev</button>
            <button v-if="categories.next_page_url" @click="next()" class="btn btn-default btn-sm">Next</button>
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
            categories: [],
            title: "Categories",
            search: '',
            link: ''
          }
        },
        mounted() {
            this.link = '/api/category'
            this.fetchData()
        },
        methods: {
            parseTime(date) {
                return moment(date).format('DD-MM-YYYY HH:mm:ss')
            },
            fetchData() {
                var vm = this
                axios.get(vm.link, { headers: { Authorization: 'Bearer'+ " " + this.$auth.getToken() }}).then((response) => {
                    vm.categories = response.data
                })
            },
            updateSearch() {
                if(this.search!='') {
                    this.link = '/api/category/search/'+ this.search
                } else {
                    this.link = '/api/category'
                }
                this.fetchData();
            }
            ,
            next() {
                if(this.categories.next_page_url) {
                    this.link = this.categories.next_page_url
                    this.fetchData()
                }
            },
            prev() {
                if(this.categories.prev_page_url) {
                    this.link = this.categories.prev_page_url
                    this.fetchData()
                }
            },
            goTo() {
                
                if(this.categories.current_page <= this.categories.last_page) {
                    var prefix;
                    if(this.search != '') {
                        prefix = '/api/category/search/'+this.search+'?page='
                    } else {
                        prefix = '/api/category?page='
                    }
                    this.link = prefix+this.categories.current_page
                    this.fetchData()
                }
            }
        }
      }
      
</script>