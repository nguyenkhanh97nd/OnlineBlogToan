<template>
  <div id="root">
    <h2>{{ title }}</h2>
    <div class="col-xs-10 row" style="padding-bottom:10px">
        <input @input="updateSearch()" v-model="search" type="text" class="form-control" placeholder="Search for...">
    </div>
    <button @click="$router.push({ name: 'AdminMembersCreate' })" class="btn btn-info col-xs-2 pull-right">New</button>

    <table class="table table-bordered">
        <thead>
            <tr align="center">
                <th>ID</th>
                <th>Avatar</th>
                <th>Name</th>
                <th>Username</th>
                <th>Email</th>
                <th>Gender</th>
                <th>Level</th>
                <th>Status</th>
                <th>Delete</th>
                <th>Edit</th>
            </tr>
        </thead>
        <tbody v-for="member in members.data">
            <tr class="table-content" align="center">
                <td>{{ member.id }}</td>
                <td><img v-if="member.avatar" class="avatar-member-admin" :src="'/upload/users/'+member.avatar"/></td>
                <td>{{ member.name }}</td>
                <td>{{ member.username }}</td>
                <td>{{ member.email  }}</td>
                <td v-if="member.gender == 1">{{ 'Male' }}</td>
                <td v-if="member.gender == 0">{{ 'Female' }}</td>
                <td v-if="member.gender == 3">{{ 'Unknow' }}</td>
                <td v-if="member.level == 1">{{ 'Admin' }}</td>
                <td v-if="member.level == 2">{{ 'Editor' }}</td>
                <td v-if="member.level == 3">{{ 'Member' }}</td>
                <td v-if="member.level == 0">{{ 'Unknow' }}</td>
                <td v-if="member.status == 1">{{ 'Active' }}</td>
                <td v-if="member.status == 0">{{ 'Disable' }}</td>
                <td class="is-delete center"><ConfirmModal
                    url="/api/member/"
                    :dataSend="member.id"
                    message="Confirm Delete Member?"
                    spanText="<span class='glyphicon glyphicon-trash'></span><span> Delete</span>"
                    spanClass="btn-danger"
                    ></ConfirmModal></td>
                <td class="is-edit center"> <router-link :to="{ name: 'AdminMembersEdit', params:{id: member.id } }"><span class="btn btn-xs btn-info"><span class='glyphicon glyphicon-pencil'></span><span> Edit</span></span></router-link></td>
            </tr>
        </tbody>
    </table>

    <div class="panel-footer pagination-footer">
        <div class="pagination-item">
            <span>Per page: {{ members.per_page }}</span>
        </div>
        <div class="pagination-item">
            <small>Showing {{members.from}} - {{members.to}} of {{members.total}}</small>
        </div>
        <div class="pagination-item">
            <small>Current page: </small>
            <input type="text" class="pagination-input" v-model="members.current_page"
                @keyup.enter="goTo()">
            <small> of {{members.last_page}}</small>
        </div>
        <div class="pagination-item">
            <button v-if="members.prev_page_url" @click="prev()" class="btn btn-default btn-sm">Prev</button>
            <button v-if="members.next_page_url" @click="next()" class="btn btn-default btn-sm">Next</button>
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
            members: [],
            title: "Members",
            search: '',
            link: ''
          }
        },
        mounted() {
            this.link = '/api/member'
            this.fetchData()
        },
        methods: {
            fetchData() {
                var vm = this
                axios.get(vm.link,  { headers: { Authorization: 'Bearer'+ " " + this.$auth.getToken() }}).then((response) => {
                    vm.members = response.data
                })
            },
            updateSearch() {
                if(this.search!='') {
                    this.link = '/api/member/search/'+ this.search
                } else {
                    this.link = '/api/member'
                }
                this.fetchData();
            }
            ,
            next() {
                if(this.members.next_page_url) {
                    this.link = this.members.next_page_url
                    this.fetchData()
                }
            },
            prev() {
                if(this.members.prev_page_url) {
                    this.link = this.members.prev_page_url
                    this.fetchData()
                }
            },
            goTo() {
                
                if(this.members.current_page <= this.members.last_page) {
                    var prefix;
                    if(this.search != '') {
                        prefix = '/api/member/search/'+this.search+'?page='
                    } else {
                        prefix = '/api/member?page='
                    }
                    this.link = prefix+this.members.current_page
                    this.fetchData()
                }
            }
        }
      }
      
</script>