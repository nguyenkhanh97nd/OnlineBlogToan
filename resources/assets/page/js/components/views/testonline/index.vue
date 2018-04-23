<template>
	<div class="container">
		<div class="row" v-if="post">
		    <div class="col-md-9">
		        <div class="heading-block col-sm-12">
		            <a><router-link  :to="{ name: 'ClientIndex' }">Trang chủ </router-link></a>|
		            <a><router-link  :to="{ name: 'ClientCateIndex', params: { slugCate: post.subcategory.category.slug } }">{{ post.subcategory.category.name }}</router-link></a> |
		            <a><router-link  :to="{ name: 'ClientSubCateIndex', params: { slugSubCate: post.subcategory.slug } }">{{ post.subcategory.name }}</router-link></a>
		            <a><router-link  :to="{ name: 'ClientPostIndex', params: { slugSubCate: post.subcategory.slug, slugPost: post.slug } }">{{ post.name }}</router-link></a>
		        </div>
		        <div class="col-sm-12">
		            <div class="row">
		                <div class="col-sm-3 media hidden-xs">
		                	<router-link  :to="{ name: 'ClientPostIndex', params: { slugSubCate: post.subcategory.slug, slugPost: post.slug } }">
		                    <a><img class="img-responsive" :src="'upload/posts/' + post.image"/></a>
			                </router-link>
		                </div>
		                <div class="meta-content-single  col-sm-9 col-xs-12 caption">
		                    <h1><a><router-link  :to="{ name: 'ClientPostIndex', params: { slugSubCate: post.subcategory.slug, slugPost: post.slug } }">{{ post.name }}</router-link></a></h1>
		                    <p>Tác giả: {{ post.author.name }}</p>
		                    <p>Ngày: {{ post.created_at }}</p>
		                    <p>Chuyên mục: <router-link  :to="{ name: 'ClientSubCateIndex', params: { slugSubCate: post.subcategory.slug } }"><a>{{ post.subcategory.name }}</a></router-link></p>
		                    <p>Lượt xem: {{ post.count_views }} </p>
		                </div>

		                <div class="content-single col-sm-12 col-xs-12">
		                    <div v-if="wait_start">
		                        <span>Bài thi sẽ bắt đầu sau: </span><span class="count_down">{{ timeCount }}</span>
		                    </div>
		                    <div v-if="wait_end">
		                        <span>Bài thi sẽ kết thúc sau: </span><span class="count_down">{{ timeCount }}</span>
		                        <p>Nhằm đảm bảo tính công bằng, đáp án và kết quả xếp hạng sẽ công bố sau khi kết thúc thời gian thi online</p>
		                    </div>
		                    <div v-if="eliminate">
		                        <span>Bài thi sẽ kết thúc sau: </span><span class="count_down">{{ timeCount }}</span>
		                        <p>Bạn vào muộn hơn 20% thời gian. Vui lòng đợi các thí sinh khác thi xong để được thi offline</p>
		                    </div>
		                    <div v-if="bquestions">
		                        <div v-if="!ans_true">
		                        <div v-for="(question, key) in bquestions" >
		                            <fieldset :id = "'ques-' + key" class="fieldset-question">
		                                <legend class="legend-name-question" ><strong>Câu {{ key + 1 }}. {{ question.name }}</strong></legend>
		                                <div v-if="question.image">
		                                <p><img width="200px" height="112px" :src="'upload/questions/' + question.image"/></p>
		                                </div>

		                                <label class="label-testonline">
		                                    <input type="radio" @click="doAnswer(key, 'A')" class="choose option-input radio" :name="'ans-' + key" :id="'ans-a' + key" value='A' :checked="dataAns[key] == 'A'" />
		                                    <strong class="strong-answer">A. {{ question.ans_a }}</strong>
		                                </label>
		                                
		                                <label class="label-testonline">
		                                    <input type="radio" @click="doAnswer(key, 'B')" class="choose option-input radio" :name="'ans-' + key" :id="'ans-b' + key" value='B' :checked="dataAns[key] == 'B'" />
		                                    <strong class="strong-answer">B. {{ question.ans_b }}</strong>
		                                </label>

		                                <label class="label-testonline">
		                                    <input type="radio" @click="doAnswer(key, 'C')" class="choose option-input radio" :name="'ans-' + key" :id="'ans-c' + key" value='C' :checked="dataAns[key] == 'C'" />
		                                    <strong class="strong-answer">C. {{ question.ans_c }}</strong>
		                                </label>

		                                <label class="label-testonline">
		                                    <input type="radio" @click="doAnswer(key, 'D')" class="choose option-input radio" :name="'ans-' + key" :id="'ans-d' + key" value='D' :checked="dataAns[key] == 'D'" />
		                                    <strong class="strong-answer">D. {{ question.ans_d }}</strong>
		                                </label>

		                            </fieldset>
		                        </div>
		                        </div>
		                        <div v-if="ans_true">
		                        <div v-for="(question, key) in bquestions">
		                            <fieldset :id = "'ques-' + key" class="fieldset-question">
		                                <legend class="legend-name-question">Câu {{ key + 1 }}. {{ question.name }}</legend>
		                                <div v-if="question.image">
		                                <p><img width="200px" height="112px" :src="'upload/questions/' + question.image"/></p>
		                                </div>

		                                <label class="label-testonline">
		                                    <input disabled type="radio" class="chooseResult option-input radio" :name="'ans-' + key" :id="'ans-a' + key" value='A' :checked="dataAns[key] == 'A'" />
		                                    <strong class="strong-answer" :style="ans_true[key] == 'A' ? {'color' : 'blue'} : {}">A. {{ question.ans_a }}</strong>
		                                </label>
		                                
		                                <label class="label-testonline">
		                                    <input disabled type="radio" class="chooseResult option-input radio" :name="'ans-' + key" :id="'ans-b' + key" value='B' :checked="dataAns[key] == 'B'" />
		                                    <strong class="strong-answer" :style="ans_true[key] == 'B' ? {'color' : 'blue'} : {}">B. {{ question.ans_b }}</strong>
		                                </label>

		                                <label class="label-testonline">
		                                    <input disabled type="radio" class="chooseResult option-input radio" :name="'ans-' + key" :id="'ans-c' + key" value='C' :checked="dataAns[key] == 'C'" />
		                                    <strong class="strong-answer" :style="ans_true[key] == 'C' ? {'color' : 'blue'} : {}">C. {{ question.ans_c }}</strong>
		                                </label>

		                                <label class="label-testonline">
		                                    <input disabled type="radio" class="chooseResult option-input radio" :name="'ans-' + key" :id="'ans-d' + key" value='D' :checked="dataAns[key] == 'D'" />
		                                    <strong class="strong-answer" :style="ans_true[key] == 'D' ? {'color' : 'blue'} : {}">D. {{ question.ans_d }}</strong>
		                                </label>

		                            </fieldset>
		                        </div>
		                        </div>
		                    </div>
		                </div>

		            </div>
		        </div>
		    </div>

		    <div class="col-md-3 parent_fixed">
		        <div v-if="dataAns && !ans_true" class="table_fixed">
		                <button class="btn btn-success" @click="clickSubmit()">Nộp bài</button>

		                <p v-if="timeSubmitOnline" class="count_down_testing"> <span class="title-countdown">Thời gian còn lại:</span> {{ timeCount  }} </p>
		                <p v-if="timeSubmitOffline" class="count_down_testing"> <span class="title-countdown">Thời gian còn lại:</span> {{ timeCount }} </p>

		                <table class="table table-bordered">
		                    <tbody v-for="i in (dataAns.length/5)">
		                    <tr class="table-content" align="center">
		                        <td class="scroll_ans" :id = "'scroll_' + (5*i - 5)"> {{ (5*i - 4) + '. ' }}
		                            <span v-if="dataAns[5*i - 5]" :id="'answer_' + (5*i - 5)">
		                                {{ dataAns[5*i - 5] }}
		                            </span>
		                        </td>
		                        <td class="scroll_ans" :id = "'scroll_' + (5*i - 4)"> {{ (5*i - 3) + '. ' }}
		                            <span v-if="dataAns[5*i - 4]" :id="'answer_' + (5*i - 4)">
		                                {{ dataAns[5*i - 4] }}
		                            </span>
		                        </td>
		                        <td class="scroll_ans" :id = "'scroll_' + (5*i - 3)"> {{ (5*i - 2) + '. ' }}
		                            <span v-if="dataAns[5*i - 3]" :id="'answer_' + (5*i - 3)">
		                                {{ dataAns[5*i - 3] }}
		                            </span>
		                        </td>
		                        <td class="scroll_ans" :id = "'scroll_' + (5*i - 2)"> {{ (5*i - 1) + '. ' }}
		                            <span v-if="dataAns[5*i - 2]" :id="'answer_' + (5*i - 2)">
		                                {{ dataAns[5*i - 2] }}
		                            </span>
		                        </td>
		                        <td class="scroll_ans" :id = "'scroll_' + (5*i - 1)"> {{ (5*i) + '. ' }}
		                            <span v-if="dataAns[5*i - 1]" :id="'answer_' + (5*i - 1)">
		                                {{ dataAns[5*i - 1] }}
		                            </span>
		                        </td>
		                    </tr>
		                    </tbody>
		                </table>
		        </div>
		        <div v-if="dataAns && ans_true" class="table_fixed">
		                
		                <p class="count_down"> Điểm: {{ points + '/' + 10 }} </p>

		                <table class="table table-bordered">
		                    <tbody v-for="i in (dataAns.length/5)">
		                    <tr class="table-content" align="center">
		                        <td  class="scroll_ans" :id = "'scroll_' + (5*i - 5)"> {{ (5*i - 4) + '. ' }}
		                            <span v-if="dataAns[5*i - 5]" :id="'answer_' + (5*i - 5)" :style="ans_true[5*i-5] == dataAns[5*i-5] ? {'color' : 'blue'} : {'color':'red'}">
		                                {{ dataAns[5*i - 5] }}
		                            </span>
		                        </td>
		                        <td class="scroll_ans" :id = "'scroll_' + (5*i - 4)"> {{ (5*i - 3) + '. ' }}
		                            <span v-if="dataAns[5*i - 4]" :id="'answer_' + (5*i - 4)" :style="ans_true[5*i-4] == dataAns[5*i-4] ? {'color' : 'blue'} : {'color':'red'}">
		                                {{ dataAns[5*i - 4] }}
		                            </span>
		                        </td>
		                        <td class="scroll_ans" :id = "'scroll_' + (5*i - 3)"> {{ (5*i - 2) + '. ' }}
		                            <span v-if="dataAns[5*i - 3]" :id="'answer_' + (5*i - 3)" :style="ans_true[5*i-3] == dataAns[5*i-3] ? {'color' : 'blue'} : {'color':'red'}">
		                                {{ dataAns[5*i - 3] }}
		                            </span>
		                        </td>
		                        <td class="scroll_ans" :id = "'scroll_' + (5*i - 2)"> {{ (5*i - 1) + '. ' }}
		                            <span v-if="dataAns[5*i - 2]" :id="'answer_' + (5*i - 2)" :style="ans_true[5*i-2] == dataAns[5*i-2] ? {'color' : 'blue'} : {'color':'red'}">
		                                {{ dataAns[5*i - 2] }}
		                            </span>
		                        </td>
		                        <td class="scroll_ans" :id = "'scroll_' + (5*i - 1)"> {{ (5*i - 0) + '. ' }}
		                            <span v-if="dataAns[5*i - 1]" :id="'answer_' + (5*i - 1)" :style="ans_true[5*i-1] == dataAns[5*i-1] ? {'color' : 'blue'} : {'color':'red'}">
		                                {{ dataAns[5*i - 1] }}
		                            </span>
		                        </td>
		                    </tr>
		                    </tbody>
		                </table>
		                <p class="heading-title">BẢNG XẾP HẠNG</p>

		                <ul class="list-unstyled" v-for="(user_rank, key) in users">
		            
		                    <li class="feature-index container-fluid">
		                        <div class="col-md-2">
		                            <span class="pull-left">{{ key + 1 }}. </span>
		                        </div>
		                        <div class="col-md-8 text-center"><router-link  :to="{ name: 'ClientProfileIndex', params: { userslug: user_rank.user.username } }">
									<a>
		                            {{ user_rank.user.username }}   
		                            </a> </router-link>
		                        </div>
		                        <div class="col-md-2">
		                            <span class="pull-right"><font color="#f1004c">{{ user_rank.point_exam }}</font></span>
		                        </div>
		                    </li>

		                </ul>
		                <p>{{ current_user_rank_status }}</p>
		        </div>
		    </div>

		</div>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				post: '',

				wait_end: '',
				wait_start: '',
				eliminate: '',
				timeCount: '',

				timeSubmitOnline: '',
				timeSubmitOffline: '',

				dataAns: '',
				users: '',
				bquestions: '',
				points: '',
				current_user_rank_status: '',
				ans_true: '',

				intervals: [],
				path: '',
			}
		},
		created() {
			if(this.$authjs.isAuthenticated()) {
				this.getCurrentUser()
				this.path = this.$route.path
				console.log(this.path)
				this.fetchData()

				setTimeout(function(){ 

			        $('.table_fixed').width($('.parent_fixed').width()).css('position', 'fixed')

			        var tableClick = $('.scroll_ans')
			        tableClick.click(function() {
			            let id = $(this).attr('id');
			            let idQues = 'ques-'+ id.substring(7);
			            $('html, body').animate({
			                scrollTop: $("#"+ idQues+"").offset().top-100
			            }, 500);
			        })

			        $('.choose').change(function() {
			            let id = $(this).attr('id')
			            let value = $(this).val()
			            let key = id.substring(5)
			            $('#answer_'+key).html(value)
			            $('#answer_'+key).css( 'color', 'red')
			        })

			    }, 5000)

			}
		},
		methods: {
			getCurrentUser() {
				var vm = this
				axios.get('/api/client/user', { headers: { Authorization: 'Bearer ' + this.$authjs.getToken() }})
					.then((response)=>{
						vm.current_user = response.data.user
					}, (error) => {
						this.$authjs.destroyToken()
						this.$router.push({ name: 'ClientLogin' })
					})
			},
			fetchData() {
				var vm = this
				var link = '/api/client/testonline'
				var data = {
					paramUrl: vm.$route.params.slugPost
				}
				axios.post(link, data, { headers: { Authorization: 'Bearer ' + this.$authjs.getToken() }})
				.then((response) => {
					console.log(response)

					if(response.data.wait_start) {
						let count_down = response.data.wait_start
						vm.wait_start = true
						vm.shutTime(count_down)

					} else if(response.data.wait_end) {
						let count_down = response.data.wait_end
						vm.wait_end = true
						vm.shutTime(count_down)

					} else if(response.data.eliminate){
						let count_down = response.data.eliminate
						vm.eliminate = true
						vm.shutTime(count_down)

					} else if(response.data.timeSubmitOnline){
						vm.bquestions = response.data.bquestions
						vm.dataAns = response.data.dataAns
						vm.timeSubmitOnline = true
						let count_down = response.data.timeSubmitOnline

						vm.shutTime(count_down)

					} else if(response.data.timeSubmitOffline) {
						
						vm.bquestions = response.data.bquestions
						vm.dataAns = response.data.dataAns
						vm.timeSubmitOffline = true
						let count_down = response.data.timeSubmitOffline
						vm.shutTime(count_down)
						
					} else if(response.data.ans_true) {
						vm.bquestions = response.data.bquestions
						vm.dataAns = response.data.dataAns

						vm.ans_true = response.data.ans_true
						vm.users = response.data.users
						vm.points = response.data.points
						vm.current_user_rank_status = response.data.current_user_rank_status
					}
					vm.post = response.data.post
				})
			},
			shutTime(time) {
				var vm = this
				if(vm.intervals.length > 0) {
					clearInterval(vm.intervals.pop())
				}
				vm.intervals.push(setInterval(function() {
					if(vm.$route.path != vm.path) {
						clearInterval(vm.intervals[0])
					}
					let h = Math.floor(time / 3600)
				    let m = Math.floor(time % 3600 / 60)
				    let s = Math.floor(time % 3600 % 60)
					time --
					if(time < 0) {
						vm.$router.go()
					} else {

						var hh = h, mm = m, ss = s

						if(h < 10) {
							hh = "0" + h
						}
						if(m < 10) {
							mm = "0" + m
						}
						if(s < 10) {
							ss = "0" + s
						}

						vm.timeCount = hh + ":" + mm + ":" + ss
					}
					
				}, 1000))
			},
			doAnswer(key, value) {
				var vm = this
				var link = '/api/client/ajaxanswer'
				var data = {
					paramUrl: vm.$route.params.slugPost,
					answerKey: key,
					answerValue: value
				}
				axios.post(link, data, { headers: { Authorization: 'Bearer ' + this.$authjs.getToken() }})
				.then((response) => {
					console.log(response)
					if(response.data.timeSubmitOnline) {
						let count_down = response.data.timeSubmitOnline
						vm.shutTime(count_down)
						vm.dataAns = response.data.dataAns
					} else if(response.data.timeSubmitOffline) {
						let count_down = response.data.timeSubmitOffline
						vm.shutTime(count_down)
						vm.dataAns = response.data.dataAns
					}
					$('#answer_'+key).css('color', 'blue')
				}, (response) => {
					$('#answer_'+key).css('color', 'red')
				})
			},

			clickSubmit() {
				var vm = this
				var link = '/api/client/submitTest'
				var data = {
					paramUrl: vm.$route.params.slugPost
				}

				vm.$swal({
                  title: 'Nộp bài?',
                  text: "Bạn chắc chắn nộp bài của mình!",
                  type: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Yes, submit it!'
                }).then((result) => {

                	if(result) {
                		axios.post(link, data, { headers: { Authorization: 'Bearer ' + this.$authjs.getToken() }})
						.then((response) => {
							if(response.data.submit) {
								vm.$swal("Success!", 'Nộp bài thành công!', "success", {
				                  button: "OK!",
				                })
								vm.$router.go()
							} else {
								vm.$swal("Error!", 'Lỗi!', "error", {
				                  button: "OK!",
				                })
							}
						})
                	}

                }).catch(vm.$swal.noop)
				
			}
		}
	}
</script>