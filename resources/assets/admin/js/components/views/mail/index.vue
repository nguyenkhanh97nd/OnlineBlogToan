<template>
    <div id="root">
        <h2>{{ title }}</h2>
        <div class="content-section" style="padding-bottom:120px">
             <form @submit.prevent="send()" @keydown="errors.clear($event.target.name)">
                <div class="form-group">
                    <label>Name</label>
                    <input  v-model="form.name" name="name" class="form-control" placeholder="Name Mail" />

                    <p class="alert alert-danger" v-if="errors.has('name')" v-text="errors.get('name')"></p>
                </div>
                <div class="form-group">
                    <label>Title</label>
                    <input  v-model="form.title" name="title" class="form-control" placeholder="Title Mail" />

                    <p class="alert alert-danger" v-if="errors.has('title')" v-text="errors.get('title')"></p>
                </div>
                <div class="form-group">
                    <label>Content</label>
                    <input  v-model="form.content" name="content" class="form-control" placeholder="Content Mail" />

                    <p class="alert alert-danger" v-if="errors.has('content')" v-text="errors.get('content')"></p>
                </div>
                <div class="form-group">
                    <label>Send to</label>
                    <label class="radio-inline">
                        <el-radio class="radio" @input="errors.clear('users')" name="users" v-model="form.users"  label="0"  >All</el-radio>
                    </label>
                    <label class="radio-inline">
                        <el-radio class="radio" @input="errors.clear('users')" name="users" v-model="form.users" label="1">Admins</el-radio>
                    </label>
                    <label class="radio-inline">
                        <el-radio class="radio" @input="errors.clear('users')" name="users" v-model="form.users"  label="2"  >Editors</el-radio>
                    </label>
                    <label class="radio-inline">
                        <el-radio class="radio" @input="errors.clear('users')" name="users" v-model="form.users" label="3">Members</el-radio>
                    </label>

                    <label class="radio-inline">
                        <el-radio class="radio" @input="errors.clear('users')" name="users" v-model="form.users"  label="4"  >Custom</el-radio>
                    </label>
                    <p class="alert alert-danger" v-if="errors.has('users')" v-text="errors.get('users')"></p>
                </div>
                <div class="form-group" v-if="form.users == 4">
                    <input  v-model="form.data" name="data" class="form-control" placeholder="Custom Mail" />
                </div>
                <button class="btn btn-default">Send</button>
            </form>
        </div>
    </div>
</template>

<script>
class Error {
    constructor() {
        this.errors = {}
    }

    get(field) {
        if(this.errors[field]) {
            return this.errors[field][0]
        }
    }
    record(errors) {
        this.errors = errors
    }
    clear(field) {
        delete this.errors[field]
    }
    has(field) {
        return this.errors.hasOwnProperty(field)
    }
    any() {
        return Object.keys(this.errors).length >0
    }
}
    export default {
        data() {
            return {
                title: 'Admin Mail',
                form: {
                    title: '',
                    content: '',
                    users: '',
                    name: '',
                    data: '',
                },
                link: '/api/mail',
                errors: new Error,
                method: 'post'
            }
        },
        methods: {
            fetchData() {
                var vm = this
                vm.form.title = '',
                vm.form.content = '',
                vm.form.users = '',
                vm.form.name = '',
                vm.form.data = ''
            },
            send() {
                var vm = this
                axios({
                    method: vm.method,
                    url: vm.link,
                    data: vm.form,
                    headers: { 'Authorization' : 'Bearer'+ " " + this.$auth.getToken() }
                }).then(function(response) {
                    if(response.data.sended) {
                        vm.$swal("Success!", response.data.message, "success", {
                                  button: "OK!",
                                })
                        vm.fetchData()
                    } else {
                        vm.$swal("Failed!", response.data.message, "error", {
                                  button: "OK!",
                                })
                    }
                }).catch(error => vm.errors.record(error.response.data))
            }
        }
    }
</script>