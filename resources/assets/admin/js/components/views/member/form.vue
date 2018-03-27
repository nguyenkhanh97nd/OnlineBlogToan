<template>
	<div id="root">
	<h2>{{ title }}</h2>
	<div class="content-section" style="padding-bottom:120px">

	    <form @submit.prevent="save()" @keydown="errors.clear($event.target.name)">
	        <div class="form-group">
	            <label>Name</label>

                <el-input placeholder="Name" name="name" @input="errors.clear('name')" v-model="form.name"></el-input>

                <p class="alert alert-danger" v-if="errors.has('name')" v-text="errors.get('name')"></p>
	        </div>

	        <div v-if="create" class="form-group">
	            <label>Username</label>
                <el-input placeholder="Username" name="username" @input="errors.clear('username')" v-model="form.username"></el-input>

                <p class="alert alert-danger" v-if="errors.has('username')" v-text="errors.get('username')"></p>
	        </div>
            <div v-else class="form-group">
                <label>Username</label>
                <el-input :disabled="true" placeholder="Username" name="username" @input="errors.clear('username')" v-model="form.username"></el-input>

            </div>

            <div class="form-group">
                <label>Gender</label>
                <label class="radio-inline">
                    <el-radio class="radio" @input="errors.clear('gender')" name="gender" v-model="form.gender" label="1">Male</el-radio>
                </label>
                <label class="radio-inline">
                    <el-radio class="radio" @input="errors.clear('gender')" name="gender" v-model="form.gender"  label="0"  >Female</el-radio>
                </label>
                <label class="radio-inline">
                    <el-radio class="radio" @input="errors.clear('gender')" name="gender" v-model="form.gender"  label="3"  >Unknow</el-radio>
                </label>

                <p class="alert alert-danger" v-if="errors.has('gender')" v-text="errors.get('gender')"></p>
            </div>
            
            <div v-if="create" class="form-group">
                <label>Email</label>
                <el-input placeholder="Email" name="email" @input="errors.clear('email')" v-model="form.email"></el-input>
                <p class="alert alert-danger" v-if="errors.has('email')" v-text="errors.get('email')"></p>
            </div>
            <div v-if="!create" class="form-group">
                <label>Email</label>
                <el-input :disabled="true" placeholder="Email" name="email" @input="errors.clear('email')" v-model="form.email"></el-input>
                <p class="alert alert-danger" v-if="errors.has('email')" v-text="errors.get('email')"></p>
            </div>

	        <div class="form-group">
	            <label>Password</label>
                <input class="form-control" type="password" name="password" placeholder="Password" v-model="form.password">
                <p class="alert alert-danger" v-if="errors.has('password')" v-text="errors.get('password')"></p>

	        </div>
            <div class="form-group">
                <label>Confirm password</label>
                <input class="form-control" type="password" name="repassword" placeholder="Confirm password" v-model="form.repassword">
                <p class="alert alert-danger" v-if="errors.has('repassword')" v-text="errors.get('repassword')"></p>

            </div>
            
            <div class="form-group">
                <label>Intro</label>
                <el-input placeholder="Intro" name="info" @input="errors.clear('info')" v-model="form.info"></el-input>
                <p class="alert alert-danger" v-if="errors.has('info')" v-text="errors.get('info')"></p>
            </div>

            <div class="form-group">
                <label>Level</label>
                <label class="radio-inline">
                    <el-radio class="radio" @input="errors.clear('level')" name="level" v-model="form.level" label="1">Admin</el-radio>
                </label>
                <label class="radio-inline">
                    <el-radio class="radio" @input="errors.clear('level')" name="level" v-model="form.level"  label="2"  >Editor</el-radio>
                </label>
                <label class="radio-inline">
                    <el-radio class="radio" @input="errors.clear('level')" name="level" v-model="form.level" label="3">Member</el-radio>
                </label>
                <label class="radio-inline">
                    <el-radio class="radio" @input="errors.clear('level')" name="level" v-model="form.level"  label="0"  >Unknow</el-radio>
                </label>
                <p class="alert alert-danger" v-if="errors.has('level')" v-text="errors.get('level')"></p>
            </div>

            <div class="form-group">
                <label>Status</label>
                <label class="radio-inline">
                    <el-radio class="radio" @input="errors.clear('status')" name="status" v-model="form.status" label="1">Active</el-radio>
                </label>
                <label class="radio-inline">
                    <el-radio class="radio" @input="errors.clear('status')" name="status" v-model="form.status"  label="0"  >Disable</el-radio>
                </label>
                <p class="alert alert-danger" v-if="errors.has('status')" v-text="errors.get('status')"></p>
            </div>

            <div class="form-group">
                <label>Image</label>
                
                <input @change="changeImage" id="file" type="file" name="avatar" class="form-control"/>
     
                <img v-if="!create && temp_avatar" class="avatar-member-admin" :src="'/upload/users/'+temp_avatar">
                <p v-if="!create && temp_avatar" @click="delete_image" class='btn btn-xs btn-danger'>Delete</p>
                <p class="alert alert-danger" v-if="errors.has('avatar')" v-text="errors.get('avatar')"></p>

            </div>

	        <button class="btn btn-default">Save</button>
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
        data () {
          return {
            title: "Create Member",
            create: true,
            temp_avatar: '',
            form: {
                name:'',
                username:'',
                password: '',
                repassword: '',
                gender:'',
                email:'',
                level:'',
                info:'',
                avatar: '',
                image_upload:'',
                status:''

            },
            link: '/api/member',
            redirect: 'AdminMembersIndex',
            method: 'post',
            errors : new Error
          }
        },
        beforeMount() {

        	if(this.$route.meta.mode == 'edit') {
        		this.title = 'Edit Member',
        		this.link = '/api/member/'+this.$route.params.id,
        		this.method = 'put',
                this.create = false,
                this.fetchData()
        	}
        },
        methods: {
            fetchData() {
                var vm = this
                axios.get(vm.link,  { headers: { Authorization: 'Bearer'+ " " + this.$auth.getToken() }}).then((response) => {
                    vm.form.password = ''
                    vm.form.name = response.data.name
                    vm.form.username = response.data.username
                    vm.form.email = response.data.email
                    vm.form.info = response.data.info
                    vm.form.avatar = response.data.avatar
                    vm.temp_avatar = response.data.avatar
                    vm.form.gender = response.data.gender.toString()
                    vm.form.level = response.data.level.toString()
                    vm.form.status = response.data.status.toString()
                    
                }).catch(error => vm.$router.push({ name: 'AdminMembersIndex' }))
            },
            save() {
                var vm = this
                axios({
                    method: vm.method,
                    url: vm.link,
                    data: vm.form,
                    headers: { 'Authorization' : 'Bearer'+ " " + this.$auth.getToken() }
                }).then(function(response) {
                    if(response.data.saved) {

                        vm.$swal("Success!", "Save Member!", "success", {
                          button: "OK!",
                        });
                        vm.$router.push({ name: 'AdminMembersIndex' })
                    }
                }).catch(error => vm.errors.record(error.response.data))


            },
            changeImage(e) {
                var vm = this
                if(e.target.files[0]) {
                    var fileReader = new FileReader()
                    fileReader.readAsDataURL(e.target.files[0])

                    fileReader.onload = (e) => {
                        vm.form.image_upload = e.target.result
                    }
                    vm.form.avatar = 'filled'
                    vm.errors.clear('image')
                } else {
                    vm.form.avatar = ''
                }
            },
            delete_image() {
                var vm = this
                vm.form.avatar = 'deleted'
                vm.temp_avatar = ''
            }
        }
    }
      
</script>