<template>
  <div id="root">
    <h2>{{ title }}</h2>
    <div class="col-xs-10 row" style="padding-bottom:10px">
        <input @input="updateSearch()" v-model="search" type="text" class="form-control" placeholder="Search for...">
    </div>
    <button @click="$router.push({ name: 'AdminSubCategoryCreate' })" class="btn btn-info col-xs-2 pull-right">New</button>

    <table class="table table-bordered">
        <thead>
            <tr align="center">
                <th>ID</th>
                <th>Name</th>
                <th>Slug</th>
                <th>Category</th>
                <th>Descriptions</th>
                <th>Created at</th>
                <th>Last updated</th>
                <th>Delete</th>
                <th>Edit</th>
            </tr>
        </thead>
        <tbody v-for="subcategory in subcategories.data">
            <tr class="table-content" align="center">
                <td>{{ subcategory.id }}</td>
                <td>{{ subcategory.name }}</td>
                <td>{{ subcategory.slug }}</td>
                <td>{{ subcategory.category.name }}</td>
                <td v-html="subcategory.description"></td>
                <td>{{ parseTime(subcategory.created_at)  }}</td>
                <td>{{ parseTime(subcategory.updated_at) }}</td>
                <td class="is-delete center"><ConfirmModal
                    url="/api/subcategory/"
                    :dataSend="subcategory.id"
                    message="Confirm Delete Subcategory?"
                    spanText="<span class='glyphicon glyphicon-trash'></span><span> Delete</span>"
                    spanClass="btn-danger"
                    ></ConfirmModal></td>
                <td class="is-edit center"> <router-link :to="{ name: 'AdminSubCategoryEdit', params:{id: subcategory.id } }"><span class="btn btn-xs btn-info"><span class='glyphicon glyphicon-pencil'></span><span> Edit</span></span></router-link></td>
            </tr>
        </tbody>
    </table>

    <div class="panel-footer pagination-footer">
        <div class="pagination-item">
            <span>Per page: {{ subcategories.per_page }}</span>
        </div>
        <div class="pagination-item">
            <small>Showing {{subcategories.from}} - {{subcategories.to}} of {{subcategories.total}}</small>
        </div>
        <div class="pagination-item">
            <small>Current page: </small>
            <input type="text" class="pagination-input" v-model="subcategories.current_page"
                @keyup.enter="goTo()">
            <small> of {{subcategories.last_page}}</small>
        </div>
        <div class="pagination-item">
            <button v-if="subcategories.prev_page_url" @click="prev()" class="btn btn-default btn-sm">Prev</button>
            <button v-if="subcategories.next_page_url" @click="next()" class="btn btn-default btn-sm">Next</button>
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
            subcategories: [],
            title: "Sub Categories",
            search: '',
            link: ''
          }
        },
        mounted() {
            this.link = '/api/subcategory'
            this.fetchData()
        },
        methods: {
            parseTime(date) {
                return moment(date).format('DD-MM-YYYY HH:mm:ss')
            },
            fetchData() {
                var vm = this
                axios.get(vm.link, { headers: { Authorization: 'Bearer'+ " " + this.$auth.getToken() }}).then((response) => {
                    vm.subcategories = response.data
                })
            },
            updateSearch() {
                if(this.search!='') {
                    this.link = '/api/subcategory/search/'+ this.search
                } else {
                    this.link = '/api/subcategory'
                }
                this.fetchData();
            }
            ,
            next() {
                if(this.subcategories.next_page_url) {
                    this.link = this.subcategories.next_page_url
                    this.fetchData()
                }
            },
            prev() {
                if(this.subcategories.prev_page_url) {
                    this.link = this.subcategories.prev_page_url
                    this.fetchData()
                }
            },
            goTo() {
                
                if(this.subcategories.current_page <= this.subcategories.last_page) {
                    var prefix;
                    if(this.search != '') {
                        prefix = '/api/subcategory/search/'+this.search+'?page='
                    } else {
                        prefix = '/api/subcategory?page='
                    }
                    this.link = prefix+this.subcategories.current_page
                    this.fetchData()
                }
            }
        }
      }
      
</script>