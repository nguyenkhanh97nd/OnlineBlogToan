<template>
	<div id="root">
	<h2>{{ title }}</h2>
	<div class="content-section" style="padding-bottom:120px">

	    <form  @keydown="errors.clear($event.target.name)">
	    	<div class="form-group">
	            <label>Post</label>
	            <p>

				<el-select @input="errors.clear('post_id')" name="post_id" v-model="form.post_id" placeholder="Select Post">
                    <template v-if="create">
    				    <el-option v-if="!post.question.length" 
    				      v-for="post in posts"

    				      :key="post.id"
    				      :label="post.name"
                            
    				      :value="post.id">
    				    </el-option>
                    </template>
                    <template v-else>
                        <el-option
                          v-for="post in posts"

                          :key="post.id"
                          :label="post.name"
                        v-model="form.post_id"
                          :value="post.id">
                        </el-option>
                    </template>
				</el-select>
				</p>
	            <p class="alert alert-danger" v-if="errors.has('post_id')" v-text="errors.get('post_id')"></p>
	        </div>
            <div v-if="create">
    	        <div class="form-group">
                    <span>Số câu: </span> <el-input-number  @input="errors.clear('number')" name="number" v-model="form.number" :min="0" :max="90"></el-input-number>
                    
                    <p class="alert alert-danger" v-if="errors.has('number')" v-text="errors.get('number')"></p>
    	        </div>
                <div class="form-group">
                    <label>Content</label>
                    <el-input @input="errors.clear('content')"
                    name="content"
                      type="textarea"
                      :rows="8"
                      placeholder="Input Content"
                      v-model="form.content">
                    </el-input>

                    <input type="file" name="file_import" @change="readFileImport">

                    <p class="alert alert-danger" v-if="errors.has('content')" v-text="errors.get('content')"></p>
                </div>
                <div class="form-group">
                    <label>Result</label>
                    <el-input
                    @input="errors.clear('result')"
                      type="textarea"
                      name="result"
                      :rows="2"
                      placeholder="Input Result"
                      v-model="form.result">
                    </el-input>

                    <p class="alert alert-danger" v-if="errors.has('result')" v-text="errors.get('result')"></p>
                </div>
                <div class="form-group" v-for="(question,index) in form.data">
                    <el-input placeholder="Input question" v-model="question.name">
                        <template slot="prepend">Question {{ index + 1 }}:</template>
                    </el-input>
                    <input @change="changeImage" :id="index" type="file" name="image" class="form-control"/>
                    <el-input placeholder="Input answer" v-model="question.answer_a">
                        <template slot="prepend">Answer A:</template>
                    </el-input>
                    <el-input placeholder="Input answer" v-model="question.answer_b">
                        <template slot="prepend">Answer B:</template>
                    </el-input>
                    <el-input placeholder="Input answer" v-model="question.answer_c">
                        <template slot="prepend">Answer C:</template>
                    </el-input>
                    <el-input placeholder="Input answer" v-model="question.answer_d">
                        <template slot="prepend">Answer D:</template>
                    </el-input>
                    <el-input placeholder="Input answer true" v-model="question.answer_true">
                        <template slot="prepend">True:</template>
                    </el-input>            
                </div>
            </div>
            <div v-else>
                 <div class="form-group">
                    <span>Số câu: </span> <el-input-number :disabled="true" @input="errors.clear('number')" name="number" v-model="form.number" :min="0" :max="90"></el-input-number>
                    
                    <p class="alert alert-danger" v-if="errors.has('number')" v-text="errors.get('number')"></p>
                </div>
                <div class="form-group">
                    <label>Content</label>
                    <el-input @input="errors.clear('content')"
                    name="content"
                      type="textarea"
                      :rows="8"
                      placeholder="Input Content"
                      v-model="form.content">
                    </el-input>

                    <p class="alert alert-danger" v-if="errors.has('content')" v-text="errors.get('content')"></p>
                </div>
                <div class="form-group">
                    <label>Result</label>
                    <el-input
                    @input="errors.clear('result')"
                      type="textarea"
                      name="result"
                      :rows="2"
                      placeholder="Input Result"
                      v-model="form.result">
                    </el-input>

                    <p class="alert alert-danger" v-if="errors.has('result')" v-text="errors.get('result')"></p>
                </div>
                <div class="form-group" v-for="(question,index) in form.data">
                    <el-input placeholder="Input question" v-model="question.name">
                        <template slot="prepend">Question {{ index + 1 }}:</template>
                    </el-input>
                    <input @change="changeImage" :id="index" type="file" name="image" class="form-control"/>
                    <center><img v-if="question.image != ''" width="200" height="150" :src="'/public/upload/questions/'+question.image"/>
                            <p v-if="question.image != ''" class="is-delete center">
                                <ConfirmModal
                                url="/api/questions/questionimage/"
                                :dataSend="question.id"
                                message="Confirm Delete Question Image?"
                                spanText="<span class='glyphicon glyphicon-trash'></span><span> Delete</span>"
                                spanClass="btn-danger"
                                ></ConfirmModal>
                            </p>
                    </center>
                    <el-input placeholder="Input answer" v-model="question.ans_a">
                        <template slot="prepend">Answer A:</template>
                    </el-input>
                    <el-input placeholder="Input answer" v-model="question.ans_b">
                        <template slot="prepend">Answer B:</template>
                    </el-input>
                    <el-input placeholder="Input answer" v-model="question.ans_c">
                        <template slot="prepend">Answer C:</template>
                    </el-input>
                    <el-input placeholder="Input answer" v-model="question.ans_d">
                        <template slot="prepend">Answer D:</template>
                    </el-input>
                    <el-input placeholder="Input answer true" v-model="question.ans_true">
                        <template slot="prepend">True:</template>
                    </el-input>            
                </div>
            </div>
	        <p class="btn btn-default" v-if="create" @click="fetchData">Fetch Data</p>
	        <p class="btn btn-default" @click="save">Save</p>
	    </form>
	</div>
	</div>
</template>
<style type="text/css">
    .el-input-group__prepend{
        width: 100px
    }
</style>
<script>

import ConfirmModal from '../blocks/confirm.vue'

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
      export default {
        components: { ConfirmModal },
        data () {
          return {
            title: "Create Questions",
            create: true,
            posts: {},
            form: {
                post_id:'',
                data: [],
                number: '',
                images: new Array(90),
                content: '',
                result: '',
            },
            api_post: '/api/posts',
            link: '/api/questions',
            redirect: 'AdminQuestionsIndex',
            method: 'post',
            errors : new Error,
          }
        },
        beforeMount() {
        	if(this.$route.meta.mode == 'edit') {
        		this.title = 'Edit Questions',
        		this.link = '/api/questions/'+this.$route.params.id,
        		this.method = 'put',
                this.create = false,
                this.api_post = '/api/posts',
                this.fetchData()
        	}
        	axios.get(this.api_post, { headers: { Authorization: 'Bearer'+ " " + this.$auth.getToken() }}).then((response) => {
        		this.posts = response.data.data
        	})
        	
        },
        methods: {
            loadEdit() {
                var vm = this
                axios.get(vm.link, { headers: { Authorization: 'Bearer'+ " " + this.$auth.getToken() }}).then((response) => {
                    console.log(response)
                    vm.form.data = response.data
                    var i=0;
                    var content = ''
                    var result = ''
                    for(i=0;i<response.data.length;i++) {
                        content = content + "Câu "+ (i+1) + ": " + response.data[i]['name'] + '\n'
                        content = content + "A. "+ response.data[i]['ans_a'] + '\n'
                        content = content + "B. " + response.data[i]['ans_b'] + '\n'
                        content = content + "C. " + response.data[i]['ans_c'] + '\n'
                        content = content + "D. " + response.data[i]['ans_d'] + '\n'
                        result = result + response.data[i]['ans_true']
                    }
                    vm.form.content = content.trim()
                    vm.form.result = result
                    vm.form.number = response.data.length
                    vm.form.post_id = response.data[1]['id_post']

                }).catch(error => vm.$router.push({ name: 'AdminQuestionsIndex' }))
            },
            fetchData() {

                if(this.$route.meta.mode == 'edit') {
                    this.loadEdit()
                } else {
                    var vm = this
                    var getContent = vm.form.content.trim().split("\n")
                    var getResult = vm.form.result.trim().split("")
                    var getNumber = vm.form.number
                    var i

                    for(i=0; i<getNumber; i++) {
                        this.$set(vm.form.data, i,{
                            name: getContent[i*5].replace("Câu "+(i+1)+":","").trim(),
                            answer_a: getContent[i*5+1].replace("A.","").trim(),
                            answer_b: getContent[i*5+2].replace("B.","").trim(),
                            answer_c: getContent[i*5+3].replace("C.","").trim(),
                            answer_d: getContent[i*5+4].replace("D.","").trim(),
                            answer_true: getResult[i],
                        })
                    }
                }
                
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
                        vm.$swal("Success!", response.data.message, "success", {
                          button: "OK!",
                        });
                        vm.$router.push({ name: 'AdminQuestionsIndex' })
                    } else {
                        vm.$swal("Fail!", response.data.message, "error", {
                          button: "OK!",
                        });
                    }
                }).catch(error => vm.errors.record(error.response.data))
            },
            changeImage(e) {
                var vm = this
                var id = e.target.id
                if(e.target.files[0]) {
                    var fileReader = new FileReader()
                    fileReader.readAsDataURL(e.target.files[0])

                    fileReader.onload = (e) => {
                        vm.form.images[id] = e.target.result
                    }
                } else {
                    vm.form.images[id] = null
                }
            },

            readFileImport(e) {
                var vm = this
                if(e.target.files[0]) {
                    var fileReader = new FileReader()
                    fileReader.readAsText(e.target.files[0])
                    fileReader.onload = (e) => {
                        var text = e.target.result
                        vm.form.content = text
                    }
                }
            }
        }
      }
      
</script>