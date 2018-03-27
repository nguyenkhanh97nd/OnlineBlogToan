<template>
  <div id="root">
    <h2>{{ title }}</h2>
    <div class="col-xs-10 row" style="padding-bottom:10px">
        <input @input="updateSearch()" v-model="search" type="text" class="form-control" placeholder="Search for...">
    </div>
    <button @click="$router.push({ name: 'AdminQuestionsCreate' })" class="btn btn-info col-xs-2 pull-right">New</button>

    <table class="table table-bordered">
        <thead>
            <tr align="center">
                <th>ID</th>
                <th>Name</th>
                <th>Slug</th>
                <th>Time Start</th>
                <th>Time Do</th>
				<th>Status</th>
                <th>Created at</th>
                <th>Last updated</th>
                <th>Delete</th>
                <th>Edit</th>
            </tr>
        </thead>
        <tbody v-for="question in questions.data">
            <tr class="table-content" align="center">
                <td>{{ question.id }}</td>
                <td>{{ question.name }}</td>
                <td>{{ question.slug }}</td>
                <td>{{ parseDate(question.time_start) }}</td>
                <td>{{ question.time_do }}</td>
				<td>{{ question.status == 1 ? 'Active' : 'Pending' }}</td>
                <td>{{ parseDate(question.created_at)  }}</td>
                <td>{{ parseDate(question.updated_at) }}</td>
                <td class="is-delete center"><ConfirmModal
                    url="/api/questions/"
                    :dataSend="question.id"
                    message="Confirm Delete Questions Exam?"
                    spanText="<span class='glyphicon glyphicon-trash'></span><span> Delete</span>"
                    spanClass="btn-danger"
                    ></ConfirmModal></td>
                <td class="is-edit center"> <router-link :to="{ name: 'AdminQuestionsEdit', params:{id: question.id } }"><span class="btn btn-xs btn-info"><span class='glyphicon glyphicon-pencil'></span><span> Edit</span></span></router-link></td>
            </tr>
        </tbody>
    </table>

    <div class="panel-footer pagination-footer">
        <div class="pagination-item">
            <span>Per page: {{ questions.per_page }}</span>
        </div>
        <div class="pagination-item">
            <small>Showing {{questions.from}} - {{questions.to}} of {{questions.total}}</small>
        </div>
        <div class="pagination-item">
            <small>Current page: </small>
            <input type="text" class="pagination-input" v-model="questions.current_page"
                @keyup.enter="goTo()">
            <small> of {{questions.last_page}}</small>
        </div>
        <div class="pagination-item">
            <button v-if="questions.prev_page_url" @click="prev()" class="btn btn-default btn-sm">Prev</button>
            <button v-if="questions.next_page_url" @click="next()" class="btn btn-default btn-sm">Next</button>
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
            questions: [],
            title: "Questions",
            search: '',
            link: ''
          }
        },
        mounted() {
            this.link = '/api/questions'
            this.fetchData()
        },
        methods: {
            parseDate(date) {
                return moment(date).format('DD-MM-YYYY HH:mm:ss')
            },
            fetchData() {
                var vm = this
                axios.get(vm.link, { headers: { Authorization: 'Bearer'+ " " + this.$auth.getToken() }}).then((response) => {
                    vm.questions = response.data
                })
            },
            updateSearch() {
                if(this.search!='') {
                    this.link = '/api/questions/search/'+ this.search
                } else {
                    this.link = '/api/questions'
                }
                this.fetchData();
            }
            ,
            next() {
                if(this.questions.next_page_url) {
                    this.link = this.posts.next_page_url
                    this.fetchData()
                }
            },
            prev() {
                if(this.questions.prev_page_url) {
                    this.link = this.posts.prev_page_url
                    this.fetchData()
                }
            },
            goTo() {
                
                if(this.questions.current_page <= this.questions.last_page) {
                    var prefix;
                    if(this.search != '') {
                        prefix = '/api/questions/search/'+this.search+'?page='
                    } else {
                        prefix = '/api/questions?page='
                    }
                    this.link = prefix+this.questions.current_page
                    this.fetchData()
                }
            }
        }
      }
      
</script>