<template>
	<div id="root">
	<h2>{{ title }}</h2>
	<div class="content-section" style="padding-bottom:120px">

	    <form @submit.prevent="save" @keydown="errors.clear($event.target.name)">
	    	<div class="form-group">
	            <label>Category</label>
	            <p>

				<el-select @change="callSubCategory" @input="errors.clear('category_id')" name="category_id" v-model="form.category_id" placeholder="Select Category">
				    <el-option  
				      v-for="category in categories"
				      :key="category.id"
				      :label="category.name"

				      :value="category.id">
				    </el-option>
				</el-select>
				</p>
	            <p class="alert alert-danger" v-if="errors.has('category_id')" v-text="errors.get('category_id')"></p>
	        </div>
	        <div class="form-group">
	            <label>Sub Category</label>
				<p>
	            <el-select @input="errors.clear('subcategory_id')" name="subcategory_id" v-model="form.subcategory_id" placeholder="Select Sub Category">
				    <el-option  
				      v-for="subcategory in subcategories"
				      :key="subcategory.id"
				      :label="subcategory.name"

				      :value="subcategory.id">
				    </el-option>
				</el-select>

				</p>

	            <p class="alert alert-danger" v-if="errors.has('category_id')" v-text="errors.get('category_id')"></p>
	        </div>
	        <div class="form-group">
	            <label>Name</label>
	            <el-input placeholder="Name SubCategory" v-model="form.name" name="name"></el-input>

                <p class="alert alert-danger" v-if="errors.has('name')" v-text="errors.get('name')"></p>
	        </div>

	        <div v-if="create" class="form-group">
	            <label>Slug</label>
	            <el-input  v-model="form.slug" name="slug"  placeholder="Slug Post" ></el-input>

                <p class="alert alert-danger" v-if="errors.has('slug')" v-text="errors.get('slug')"></p>
	        </div>
            <div v-else class="form-group">
                <label>Slug</label>
                <el-input disabled  v-model="form.slug" name="slug"  placeholder="Slug Post" ></el-input>

            </div>
            <div class="form-group">
                
	            <label>Time Start</label>
                
                <el-date-picker @input="errors.clear('time_start')"
                  v-model="form.time_start"
                  type="datetime"
                  placeholder="Select date and time start">
                </el-date-picker>
                
                <p class="alert alert-danger" v-if="errors.has('time_start')" v-text="errors.get('time_start')"></p>
	        </div>
	        <div class="form-group">
	            <label>Time Do</label>
                <el-time-picker @input="errors.clear('time_do')"
                    v-model="form.time_do"
                    :picker-options="{
                      selectableRange: '0:00:00 - 2:00:00'
                    }"
                    placeholder="Time do">
                </el-time-picker>
                <p class="alert alert-danger" v-if="errors.has('time_do')" v-text="errors.get('time_do')"></p>
	        </div>
	        <div class="form-group">
	            <label>Brief</label>
                <p class="alert alert-danger" v-if="errors.has('brief')" v-text="errors.get('brief')"></p>

                <a class="btnContent" @click="btnBrief">{{ displayBrief }}</a>

                <ckeditor v-if="choseBrief" @input="updateFieldBrief" v-model="form.brief" ></ckeditor>
	        </div>
	        <div class="form-group">
	            <label>Content</label>

                <p class="alert alert-danger" v-if="errors.has('content')" v-text="errors.get('content')"></p>

                <a class="btnContent" @click="btnContent">{{ displayContent }}</a>

                <ckeditor v-if="choseContent" @input="updateFieldContent" v-model="form.content" ></ckeditor>

	        </div>
	        <div class="form-group">
	            <label>Image</label>
                
	            <input @change="changeImage" id="file" type="file" name="image" class="form-control"/>
                <img v-if="!create && form.image" class="img-posts-admin" :src="'/upload/posts/'+form.image">
                <p class="alert alert-danger" v-if="errors.has('image')" v-text="errors.get('image')"></p>

	        </div>
	        <div class="form-group">
	            <label>Status: </label>
	            <label class="radio-inline">
	                <el-radio class="radio" @input="errors.clear('status')" v-model="form.status" label="1">Active</el-radio>
	            </label>
	            <label class="radio-inline">
	                <el-radio class="radio" @input="errors.clear('status')" name="status" v-model="form.status"  label="0"  >Not Active</el-radio>
	            </label>
                <p class="alert alert-danger" v-if="errors.has('status')" v-text="errors.get('status')"></p>
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
}

import ckeditor from 'vue-ckeditor2'
      export default {
        components: {ckeditor},
        data () {
          return {
            title: "Create Post",
            create: true,
            form: {
                name:'',
                slug:'',
                category_id:'',
                subcategory_id:'',
                time_start: '',
                time_do: '',
                brief: '',
                content:'',
                image:'',
                status:'',
                image_upload: {}
            },
            tmp_category: '',
            subcategories: {},
            categories: {},
            api_category: '/api/category',
            link: '/api/posts',
            redirect: 'AdminPostsIndex',
            method: 'post',
            choseBrief: false,
            choseContent: false,
            displayBrief:'Show',
            displayContent: 'Show',
            errors : new Error,



            pickerOptions1: {
              shortcuts: [{
                text: 'Today',
                onClick(picker) {
                  picker.$emit('pick', new Date());
                }
              }, {
                text: 'Yesterday',
                onClick(picker) {
                  const date = new Date();
                  date.setTime(date.getTime() - 3600 * 1000 * 24);
                  picker.$emit('pick', date);
                }
              }, {
                text: 'A week ago',
                onClick(picker) {
                  const date = new Date();
                  date.setTime(date.getTime() - 3600 * 1000 * 24 * 7);
                  picker.$emit('pick', date);
                }
              }]
            },


          }
        },
        beforeMount() {
        	if(this.$route.meta.mode == 'edit') {
        		this.title = 'Edit Post',
        		this.link = '/api/posts/'+this.$route.params.id,
        		this.method = 'put',
                this.create = false,
                this.api_category = '/api/category',
                this.fetchData()
        	}
        	axios.get(this.api_category, { headers: { Authorization: 'Bearer'+ " " + this.$auth.getToken() }}).then((response) => {
        		this.categories = response.data.data
        	})
        	
        },
        methods: {
            fetchData() {
                var vm = this
                axios.get(vm.link, { headers: { Authorization: 'Bearer'+ " " + this.$auth.getToken() }}).then((response) => {   

                    vm.form.category_id = response.data.subcategory.category_id

                    vm.tmp_category = response.data.subcategory.category_id

                    vm.form.name = response.data.name
                    vm.form.slug = response.data.slug
                    vm.form.brief = response.data.brief
                    vm.form.content = response.data.content
                    vm.form.status = response.data.status.toString()
                    vm.form.image = response.data.image
                    vm.form.time_start = response.data.time_start
                    vm.form.time_do = moment(response.data.time_do,'HH:mm:ss')
                    vm.form.subcategory_id = response.data.subcategory_id
                    
                }).catch(error => vm.$router.push({ name: 'AdminPostsIndex' }))
            },
            parseTime(time) {
                return moment(time).format('HH:mm:ss')
            },
            parseDate(date) {
                return moment(date).format('YYYY-MM-DD HH:mm:ss')
            }
            ,
            save() {
                var vm = this
                var date = vm.parseDate(vm.form.time_start)
                var time = vm.parseTime(vm.form.time_do)
                vm.form.time_start = date
                vm.form.time_do = time

                axios({
                    method: vm.method,
                    url: vm.link,
                    data: vm.form,
                    headers: { 'Authorization' : 'Bearer'+ " " + this.$auth.getToken() }
                }).then(function(response) {
                    if(response.data.saved) {
                        vm.$swal("Success!", response.data.message, "success", {
                          button: "OK!",
                        });
                        vm.$router.push({ name: 'AdminPostsIndex' })
                    }
                }).catch(error => vm.errors.record(error.response.data))


            },
            btnBrief() {
                var vm = this
                if(vm.displayBrief == 'Show') {
                    vm.choseBrief = true,
                    vm.displayBrief = 'Hide'
                } else {
                    vm.choseBrief = false,
                    vm.displayBrief = 'Show'
                }
            },
            btnContent() {
                var vm = this
                if(vm.displayContent == 'Show') {
                    vm.choseContent = true,
                    vm.displayContent = 'Hide'
                } else {
                    vm.choseContent = false,
                    vm.displayContent = 'Show'
                }
            },
            updateFieldBrief() {
                var vm = this
                vm.$emit('input', String(vm.form.brief))
                vm.errors.clear('brief')
            },
            updateFieldContent() {
                var vm = this
                vm.$emit('input', String(vm.form.content))
                vm.errors.clear('content')
            },
            callSubCategory() {
            	var vm = this
                if(vm.form.category_id != vm.tmp_category) {
                    vm.form.subcategory_id = ''
                }
            	if(vm.form.category_id != null) {
            		axios.get(vm.api_category+'/'+vm.form.category_id, { headers: { Authorization: 'Bearer'+ " " + this.$auth.getToken() }})
	            	.then((response) => {
	            		vm.subcategories = response.data.subcategory
                        vm.tmp_category = vm.form.category_id
	            	})
            	}
            	
            },
            changeImage(e) {
                var vm = this
                if(e.target.files[0]) {
                    var fileReader = new FileReader()
                    fileReader.readAsDataURL(e.target.files[0])

                    fileReader.onload = (e) => {
                        vm.form.image_upload = e.target.result
                    }
                    vm.form.image = 'filled'
                    vm.errors.clear('image')
                } else {
                    vm.form.image = ''
                }
            }
        }
      }
      
</script>