<template>
  <div id="root">
    <h2>{{ title }}</h2>
    <div class="col-xs-10 row" style="padding-bottom:10px">
        <input @input="updateSearch()" v-model="search" type="text" class="form-control" placeholder="Search for...">
    </div>
    <button @click="$router.push({ name: 'AdminSubCateQuestionCreate' })" class="btn btn-info col-xs-2 pull-right">New</button>

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
        <tbody v-for="subcate in subcatequestion.data">
            <tr class="table-content" align="center">
                <td>{{ subcate.id }}</td>
                <td>{{ subcate.name }}</td>
                <td>{{ subcate.slug }}</td>
                <td>{{ subcate.cate_question.name }}</td>
                <td v-html="subcate.description"></td>
                <td>{{ parseTime(subcate.created_at)  }}</td>
                <td>{{ parseTime(subcate.updated_at) }}</td>
                <td class="is-delete center"><ConfirmModal
                    url="/api/subcatequestion/"
                    :dataSend="subcate.id"
                    message="Confirm Delete Sub Cate Question?"
                    spanText="<span class='glyphicon glyphicon-trash'></span><span> Delete</span>"
                    spanClass="btn-danger"
                    ></ConfirmModal></td>
                <td class="is-edit center"> <router-link :to="{ name: 'AdminSubCateQuestionEdit', params:{id: subcate.id } }"><span class="btn btn-xs btn-info"><span class='glyphicon glyphicon-pencil'></span><span> Edit</span></span></router-link></td>
            </tr>
        </tbody>
    </table>

    <div class="panel-footer pagination-footer">
        <div class="pagination-item">
            <span>Per page: {{ subcatequestion.per_page }}</span>
        </div>
        <div class="pagination-item">
            <small>Showing {{subcatequestion.from}} - {{subcatequestion.to}} of {{subcatequestion.total}}</small>
        </div>
        <div class="pagination-item">
            <small>Current page: </small>
            <input type="text" class="pagination-input" v-model="subcatequestion.current_page"
                @keyup.enter="goTo()">
            <small> of {{subcatequestion.last_page}}</small>
        </div>
        <div class="pagination-item">
            <button v-if="subcatequestion.prev_page_url" @click="prev()" class="btn btn-default btn-sm">Prev</button>
            <button v-if="subcatequestion.next_page_url" @click="next()" class="btn btn-default btn-sm">Next</button>
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
            subcatequestion: [],
            title: "Sub Cate Question",
            search: '',
            link: ''
          }
        },
        mounted() {
            this.link = '/api/subcatequestion'
            this.fetchData()
        },
        methods: {
            parseTime(date) {
                return moment(date).format('DD-MM-YYYY HH:mm:ss')
            },
            fetchData() {
                var vm = this
                axios.get(vm.link, { headers: { Authorization: 'Bearer'+ " " + this.$auth.getToken() }}).then((response) => {
                    vm.subcatequestion = response.data
                    console.log(response.data)
                })
            },
            updateSearch() {
                if(this.search!='') {
                    this.link = '/api/subcatequestion/search/'+ this.search
                } else {
                    this.link = '/api/subcatequestion'
                }
                this.fetchData();
            }
            ,
            next() {
                if(this.subcatequestion.next_page_url) {
                    this.link = this.subcatequestion.next_page_url
                    this.fetchData()
                }
            },
            prev() {
                if(this.subcatequestion.prev_page_url) {
                    this.link = this.subcatequestion.prev_page_url
                    this.fetchData()
                }
            },
            goTo() {
                
                if(this.subcatequestion.current_page <= this.subcatequestion.last_page) {
                    var prefix;
                    if(this.search != '') {
                        prefix = '/api/subcatequestion/search/'+this.search+'?page='
                    } else {
                        prefix = '/api/subcatequestion?page='
                    }
                    this.link = prefix+this.subcatequestion.current_page
                    this.fetchData()
                }
            }
        }
      }
      
</script>