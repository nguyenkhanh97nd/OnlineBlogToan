<template>
	<div id="root">
	<h2>{{ title }}</h2>
	<div class="content-section" style="padding-bottom:120px">

	    <form @submit.prevent="save()" @keydown="errors.clear($event.target.name)">
	        <div class="form-group">
	            <label>Name</label>
	            <input  v-model="form.name" name="name" class="form-control" placeholder="Name Category" />

                <p class="alert alert-danger" v-if="errors.has('name')" v-text="errors.get('name')"></p>
	        </div>

	        <div v-if="create" class="form-group">
	            <label>Slug</label>
	            <input  v-model="form.slug" name="slug" class="form-control" placeholder="Slug Category" />

                <p class="alert alert-danger" v-if="errors.has('slug')" v-text="errors.get('slug')"></p>
	        </div>
            <div v-else class="form-group">
                <label>Slug</label>
                <input disabled  v-model="form.slug" name="slug" class="form-control" placeholder="Slug Category" />
            </div>
	        <div class="form-group">
	            <label>Descriptions</label>

                <p class="alert alert-danger" v-if="errors.has('description')" v-text="errors.get('description')"></p>

                <a class="btnContent" @click="btnContent()">{{ display }}</a>

                <ckeditor v-if="chose" @input="updateField()" v-model="form.description" ></ckeditor>

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

import Ckeditor from 'vue-ckeditor2'
      export default {
        components: {Ckeditor},
        data () {
          return {
            title: "Create Category",
            create: true,
            form: {
                name:'',
                slug:'',
                description: '',
            },
            link: '/api/category',
            redirect: 'AdminCategoryIndex',
            method: 'post',
            chose: false,
            display: 'Show',
            errors : new Error
          }
        },
        beforeMount() {
        	if(this.$route.meta.mode == 'edit') {
        		this.title = 'Edit Category',
        		this.link = '/api/category/'+this.$route.params.id,
        		this.method = 'put',
                this.create = false,
                this.fetchData()
        	}
        },
        methods: {
            fetchData() {
                var vm = this
                axios.get(vm.link, { headers: { Authorization: 'Bearer'+ " " + this.$auth.getToken() }}).then((response) => {
                    vm.form = response.data
                }).catch(error => vm.$router.push({ name: 'AdminCategoryIndex' }))
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

                        vm.$swal("Success!", "Save Category!", "success", {
                          button: "OK!",
                        });
                        vm.$router.push({ name: 'AdminCategoryIndex' })
                    }
                }).catch(error => vm.errors.record(error.response.data))


            },
            btnContent() {
                var vm = this
                if(vm.display == 'Show') {
                    vm.chose = true,
                    vm.display = 'Hide'
                } else {
                    vm.chose = false,
                    vm.display = 'Show'
                }
            },
            updateField() {
                var vm = this
                vm.$emit('input', String(vm.form.description))
                vm.errors.clear('description')
            }
        }
      }
      
</script>