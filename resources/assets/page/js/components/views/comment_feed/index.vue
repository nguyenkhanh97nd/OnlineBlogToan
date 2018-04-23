<template>
<div class="container" v-if="current_user && getUser">
    <div class="row">
    <div class="col-sm-9 col-xs-12">
        <div class="col-md-3">
            <div class="row">
            <div class="be-user-block">
                <div class="be-user-detail">
                    <router-link  :to="{ name: 'ClientProfileIndex', params: { userslug: getUser.username } }">
                    <a class="be-ava-user">
                        <div v-if="!getUser.avatar">
                            <div  class="span-circle">
                                <span>{{ getUser.name.substring(0,1) }}</span>
                            </div>
                        </div>
                        <div v-if="getUser.avatar">
                            <img class="img-circle" width="64px" height="64px" :src="'upload/users/' + getUser.avatar">
                        </div>
                    </a>
                    </router-link>
                    <p class="be-user-name">
                        {{ getUser.name }}
                    </p>
                    <div v-if="current_user.id == getUser.id">
                        <router-link  :to="{ name: 'ClientSetting' }">
                            <a><span>Cài đặt</span></a>
                        </router-link>
                    </div>
                </div>
                <div class="be-user-activity-block">
                    <div class="row">
                        <div class="col-md-12">

                            <div v-if="getUser.is_following">
                                <button class="be-user-activity-button be-add-type" @click="doRemoveFollow(getUser.username)">Unfollow</button>
                            </div>
                            <div v-if="current_user.id != getUser.id">
                                <div v-if="!getUser.is_following">
                                    <button class="be-user-activity-button be-add-type" @click="doAddFollow(getUser.username)">Follow</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <h5 class="be-title">Thông tin</h5>
                <p class="be-text-userblock">{{ getUser.info }}</p>
            </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="col-md-12">
                <div class="row be-single-feed">
                    <div class="col-md-12">
                        <h4 class="be-feed-title"><router-link  :to="{ name: 'ClientProfileIndex', params: { userslug: getUser.username } }"><a>{{ getUser.name }}</a></router-link> đã đăng câu hỏi tại 

                            <router-link  :to="{ name: 'ClientSocialLearningCateQuestion', params: { slugCateQuestion: feed.sub_cate_question.cate_question.slug } }">
                            <a>{{ feed.sub_cate_question.cate_question.name }}</a></router-link>, 

                            <router-link  :to="{ name: 'ClientSocialLearningSubCateQuestion', params: { slugCateQuestion: feed.sub_cate_question.cate_question.slug, slugSubCateQuestion: feed.sub_cate_question.slug } }">
                            <a>{{ feed.sub_cate_question.name }}</a></router-link>

                            <span class="pull-right option-feed">
                                <div v-if="current_user.id == getUser.id && feed.status != 10">
                                <button class="option-feed-btn" data-toggle="collapse" data-target="#option_feed_span">...</button>
                                  <ul id="option_feed_span" class="collapse expand-option-feed">
                                        <li><a @click="edit_comment_feed($event)"><span class="glyphicon glyphicon-pencil"></span><span style="margin-left: 5px"> Sửa</span></a></li>
                                        <li><a @click="remove_comment_feed(feed.slug)"><span class="glyphicon glyphicon-trash"></span><span style="margin-left: 5px"> Xoá</span></a></li>
                                  </ul>
                                </div>
                            </span>
                        </h4>
                        <p class="be-feed-time"><span class="glyphicon glyphicon-time"></span> {{ feed.updated_at }}</p>
                    </div>
                    <div class="col-md-12">
                        <p class="be-feed-name">{{ feed.name }}</p>
                        <p class="be-feed-content">{{ feed.content }}</p>
                        <img v-if="feed.image" class="img-responsive" :src="'upload/user_questions/'+  feed.image " >
                    </div>
                    <div class="col-md-12">
                        <div class="row be-devide-feed">
                            <div class="col-md-4">
                                <div v-if="!check_like_feed(current_user.id, feed.like_feed)">
                                    <span class="be-like-feed-btn"><span class="glyphicon glyphicon-thumbs-up"></span> 
                                    <button @click="doLike(feed.slug)" class="be-like-feed-btn-submit">Thích {{ feed.like_feed.length }}</button></span>
                                
                                </div>
                                <div v-if="check_like_feed(current_user.id, feed.like_feed)">
                                    <span style="color:#3b5998" class="be-like-feed-btn"><span class="glyphicon glyphicon-thumbs-up"></span> 
                                    <button @click="doDislike(feed.slug)" class="be-like-feed-btn-submit">Bỏ thích</button> </span>
                                </div> 
                            </div>
                            <div class="col-md-4">
                                <span class="be-like-feed-btn">
                                    <span class="glyphicon glyphicon-comment"></span> 
                                    <span class="be-comment-feed-span-click click-comment" @click="focusComment">Bình luận</span>
                                    <span>{{ total_comments }}</span>
                                </span>
                            </div>
                            <div class="col-md-4">
                                <span class="be-like-feed-btn"><span class="glyphicon glyphicon-share-alt"></span> 
                                <button @click="doShare(feed.slug)" class="be-like-feed-btn-submit">Chia sẻ</button></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div v-if="check_like_feed(current_user.id, feed.like_feed)">
                            <p>Bạn <span v-if="feed.like_feed.length > 1">và {{ (feed.like_feed.length) - 1 }} người khác</span> thích điều này</p>
                        </div>
                    </div>
                    <div class="col-md-12" >
                        <router-link  :to="{ name: 'ClientProfileIndex', params: { userslug: current_user.username } }"  v-if="feed.status == 1">
                        <a class="pull-left be-comment-media hidden_status">
                                <span style="border-radius: 50%; width:34px; height: 34px; line-height: 34px; font-size: 15px" v-if="! current_user.avatar">{{ current_user.name.substring(0,1) }}</span>
                                <img class="img-circle" style="width: 34px; height: 34px" v-if="current_user.avatar" width="50px" height="50px" :src="'upload/users/' +current_user.avatar ">
                        </a>
                        </router-link>
                        <div class="media-body hidden_status"  v-if="feed.status == 1">
                            <div class="form-group">
                                    <input type="text" class="form-control be-comment-form focus-comment" @keydown="$event.keyCode === 13 && doComment($event)" placeholder="Viết bình luận..."  :name="feed.slug">
                                    
                                    <div class="input-file-container">  
                                        <input class="input-file" id="my-file" type="file" @change="click_image_upload($event)">
                                        <label title="Thêm ảnh" tabindex="0" for="my-file"  class="input-file-trigger"><span class="glyphicon glyphicon-folder-open"></span></label>

                                        <a class="remove-add-image" @click="removeImageData">Xoá ảnh</a>
                                      </div>
                                      <p class="file-return"></p>
                                      <div id="imgComment" style="display:none">
                                          <img :src="dataImageComment" alt="Ảnh Comment">
                                      </div>
                            </div>
                        </div>

                        <div v-for="(comment_feed_item, key) in comment_feeds.data" class="be-show-first-comment">
                            <router-link  :to="{ name: 'ClientProfileIndex', params: { userslug: comment_feed_item.user.username } }">
                            <a class="pull-left be-comment-media">
                                    <span style="border-radius: 50%; width:34px; height: 34px; line-height: 34px; font-size: 15px" v-if="! comment_feed_item.user.avatar">{{ comment_feed_item.user.name.substring(0,1) }}</span>
                                    <img class="img-circle" style="width: 34px; height: 34px" v-if="comment_feed_item.user.avatar" width="50px" height="50px" :src="'upload/users/' + comment_feed_item.user.avatar ">
                            </a>
                            </router-link>
                            <div class="media-body">
                                <p class="comment-content-feed">
                                    <span class="media-heading" >
                                        <span>
                                            <router-link  :to="{ name: 'ClientProfileIndex', params: { userslug: comment_feed_item.user.username } }">
                                            <a><font size="3" color="#3b5998"> {{ comment_feed_item.user.name }} </font></a>
                                            </router-link>
                                            <span v-if="comment_feed_item.status == 10" class="accept-ans-a">(Đã được duyệt)</span>
                                        </span>
                                        <span class="pull-right option-feed" v-if="current_user.id == getUser.id">
                                            <a v-if="comment_feed_item.status == 1" @click="accept_ans(comment_feed_item.id)" class="accept-ans-a">
                                                Duyệt <span class="glyphicon glyphicon-thumbs-up"></span>
                                            </a>
                                            <a v-if="comment_feed_item.status == 10" @click="remove_accept_ans(comment_feed_item.id)" class="accept-ans-a">
                                                Bỏ duyệt <span class="glyphicon glyphicon-thumbs-down"></span>
                                            </a>
                                        </span>
                                    </span>
                                </p>
                                <p class="comment-content-feed">{{ comment_feed_item.content }}</p>
                                <img v-if="comment_feed_item.image" class="img-responsive" :src="'upload/user_questions_comment/' +  comment_feed_item.image " >
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <center>
                            <a v-if="comment_feeds.next_page_url" class="text-center" id="loadMore" @click="loadMoreFun">Xem thêm</a> 
                        </center>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="col-sm-3 hidden-xs">
        <p class="heading-title">THÔNG TIN</p>
        <div class="be-user-block">
            <p>Thời gian: {{ feed.updated_at }}</p>
            <p>Tổng lượt thích: {{ feed.like_feed.length }}</p>
            <p>Tổng bình luận: {{ total_comments }}</p>
            <p>Số điểm: {{ feed.point_feed }}</p>
        </div>
        <div v-if="current_user.id == getUser.id ">
            <button v-if="feed.status == 1"  class="btn btn-success" @click="lock_feed(feed.slug)">Khoá bài</button>
            <p v-if="feed.status == 0"><font size="3" color="#f1004c">Bạn đã đóng bài</font></p>
            <p v-if="feed.status == 10"><font size="3" color="#f1004c">Bài bị Admin đóng</font></p>
        </div>
        <div v-if="current_user.id != getUser.id">
            <p v-if="feed.status == 0"><font size="3" color="#f1004c">Bài đã đóng</font></p>
            <p v-if="feed.status == 10"><font size="3" color="#f1004c">Bài bị Admin đóng</font></p>
        </div>
    </div>
    </div>


    <div class="col-md-12">
        <div class="col-md-offset-2 col-md-8">
        <div class="showQuestionForm">
            <router-link  :to="{ name: 'ClientProfileIndex', params: { userslug: current_user.username } }">
            <a class="pull-left be-feed-media" style="margin-top: 0">
                    <span style="border-radius: 50%; width:34px; height: 34px; line-height: 34px; font-size: 15px" v-if="! current_user.avatar">{{ current_user.name.substring(0,1) }}</span>
                    <img class="img-circle" style="width: 34px; height: 34px" v-if="current_user.avatar" width="50px" height="50px" :src="'upload/users/' + current_user.avatar">
            </a>
            </router-link>
            <div class="media-body body-feed-item">
                <div class="sort-left" layout="row" layout-align="space-between center">
                    <select required v-model="select_cate" @change="select_cate_fun" placeholder="Chọn chuyên mục"  class="md-no-underline custom-md-select-cate">
                        <option value="" disabled>Chọn chuyên mục</option>
                      <option v-for="cate in catequestion" :value="cate.slug">{{ cate.name }}</option>
                    </select>        
                </div>
                <div class="sort-left div_select_subcate" layout="row" style="margin-left:5px" layout-align="space-between center">
                        <select  v-model="select_subcate" required placeholder="Chọn mục"  class="md-no-underline custom-md-select-cate">
                            <option value="" disabled>Chọn mục</option>
                          <option v-for="subcate in subcatequestion" :value="subcate.slug">{{ subcate.name }}</option>
                        </select>
                </div>
                <div class="sort-left div_select_subcate" layout="row" style="margin-left:5px" layout-align="space-between center">
                        
                        <select v-model="point_set" disabled placeholder="Số điểm"  class="md-no-underline custom-md-select-cate">
                              <option  value="5">5</option>
                              <option value="10">10</option>
                              <option value="15">15</option>
                              <option value="20">20</option>
                        </select>

                </div>
                <div class="cancel_form_question pull-right">
                    <span v-if="minify" class="span-minify glyphicon glyphicon glyphicon-menu-down" @click="cancel_minify_add"></span>
                    <span v-if="!minify" class="span-minify glyphicon glyphicon glyphicon-menu-up" @click="cancel_minify_add"></span>
                    <span v-if="zoom" class="span-resize glyphicon glyphicon-resize-full" @click="cancel_resize_add"></span>
                    <span v-if="!zoom" class="span-resize glyphicon glyphicon-resize-small" @click="cancel_resize_add"></span>
                    <span class="span-cancel glyphicon glyphicon-remove" @click="cancel_form_add"></span>
                </div>
            </div>
            <div class="col-md-12">
                <div class="row">
                    <div layout-gt-sm="row">
                      <label>Tiêu đề</label>
                        <input v-model="title_question" required>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="row">
                    <label>Nội dung</label>
                      <textarea v-model="content_question" required rows="5" ></textarea>
                </div>
            </div>
            <div class="col-md-12">
                <div class="row">
                    <div class="form_add_question">
                        <button class="submit_add_question" @click="editQuestionFun(feed.slug)" >Gửi</button>
                          <div class="input-file-container">  
                            <input class="input-file" id="my-file-question" type="file" @change="editImage($event)">
                            <label title="Thêm ảnh" tabindex="0" for="my-file-question" class="input-file-trigger"><span class="glyphicon glyphicon-folder-open"></span></label>

                            <a class="remove-add-image-question" @click="removeImageDataQuestion">Xoá ảnh</a>
                          </div>
                          <p class="file-return-question"></p>
                          <div id="imgQuestion">
                              <img style="max-width:200px" v-if="dataImageQuestion" :src="dataImageQuestion" alt="Ảnh câu hỏi">
                              <img style="max-width:200px" v-if="imageQuestionUrl" :src="'upload/user_questions/' + imageQuestionUrl" alt="Ảnh câu hỏi">
                          </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>

</template>
<script>
    export default {
        data() {
            return {
                getUser: '',
                current_user: '',
                feed: '',
                comment_feeds: '',
                catequestion: '',
                subcatequestion: '',
                title_question: '',
                content_question: '',
                total_comments: '',

                select_cate: '',
                select_subcate: '',

                dataImageComment: '',

                api_comment_feed: '',
                dataImageQuestion: '',
                imageQuestionUrl: null,

                zoom: true,
                minify: true,
                point_set: '',
            }
        },
        created() {
            if(this.$authjs.isAuthenticated()) {
                this.getCurrentUser()

                this.api_comment_feed = '/api/client/comment_feed/' + this.$route.params.slugFeed

                this.fetchData()   
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
                axios.get(vm.api_comment_feed, { headers: { Authorization: 'Bearer ' + this.$authjs.getToken() }})
                .then((response) => {
                    vm.getUser = response.data.getUser
                    vm.feed = response.data.feed
                    vm.subcatequestion = response.data.feed.sub_cate_question.cate_question.sub_cate_question
                    vm.title_question = response.data.feed.name
                    vm.content_question = response.data.feed.content
                    vm.comment_feeds = response.data.comment_feeds
                    vm.total_comments = response.data.total_comments
                })
            },
            check_like_feed(id_check, array_check) {
                var i
                for(i=0;i<array_check.length; i++) {
                    if(array_check[i].id_user == id_check) {
                        return 1
                        
                        break
                    }
                }
                return 0;
            },
            doShare(e) {
                var vm =this
                vm.$swal("Error!", 'Chức năng sẽ cập nhật sau!', "error", {
                  button: "OK!",
                })
            },
            focusComment() {
                $('.focus-comment').focus()
            },
            doLike(e) {
                var vm = this
                var link = "/api/client/like"
                var data = {
                    slug_feed: e
                }
                axios.post(link, data, { headers: { Authorization: 'Bearer ' + this.$authjs.getToken() }})
                .then((response) => {
                    vm.$router.go()
                })
            },
            doDislike(e) {
                var vm = this
                var link = "/api/client/dislike"
                var data = {
                    slug_feed: e
                }
                axios.post(link, data, { headers: { Authorization: 'Bearer ' + this.$authjs.getToken() }})
                .then((response) => {
                    vm.$router.go()
                })
            },
            accept_ans(e) {
                var vm = this
                var id = e
                var data = {
                    comment_id: id,
                }
                var link = '/api/client/accept_answer_feed'
                axios.post(link, data, { headers: { Authorization: 'Bearer ' + this.$authjs.getToken() }})
                .then((response) => {
                    if(response.data.success) {
                        vm.$swal("Success!", response.data.success, "success", {
                          button: "OK!",
                        })
                    } else {
                        vm.$swal("Error!", response.data.error, "error", {
                          button: "OK!",
                        })
                    }
                    vm.$router.go()
                })
            },
            remove_accept_ans(e) {
                var vm = this
                var id = e
                var data = {
                    comment_id: id,
                }
                var link = '/api/client/remove_accept_answer_feed'
                axios.post(link, data, { headers: { Authorization: 'Bearer ' + this.$authjs.getToken() }})
                .then((response) => {
                    if(response.data.success) {
                        vm.$swal("Success!", response.data.success, "success", {
                          button: "OK!",
                        })
                        vm.$router.go()
                    } else {
                        vm.$swal("Error!", response.data.error, "error", {
                          button: "OK!",
                        })
                    }
                    
                })
            },
            click_image_upload(event) {
                var vm = this
                vm.dataImageComment = null
                if(event.target.files[0]) {
                    $('.file-return').html(event.target.value)
                    let fileReader = new FileReader()
                    fileReader.readAsDataURL(event.target.files[0])

                    fileReader.onload = (e) => {
                        let dataImage = e.target.result
                        vm.dataImageComment = dataImage
                    }
                    $('#imgComment').css('display', 'inline')
                    $('#imgComment img').css('max-width', '200px')
                    $('.remove-add-image').css('display', 'inline')
                    
                } else {
                    vm.dataImageComment = null
                    $('#imgComment').css('display', 'none')
                    $('.file-return').html('')
                    $('.remove-add-image').css('display', 'none')
                }
            },
            removeImageData() {
                var vm = this
                vm.dataImageComment = null
                $('#imgComment').css('display', 'none')
                $('.file-return').html('')
                $('.remove-add-image').css('display', 'none')
            },
            doComment(e) {
                var vm = this
                var link = "/api/client/commentFeed"
                var data = {
                    slug_feed: e.target.name,
                    comment_content: e.target.value,
                    comment_image: vm.dataImageComment
                }
                axios.post(link, data, { headers: { Authorization: 'Bearer ' + this.$authjs.getToken() }})
                .then((response) => {
                    if(response.data.success) {
                        vm.$swal("Success!", response.data.success, "success", {
                          button: "OK!",
                        })
                         vm.$router.go()
                    } else {
                        vm.$swal("Error!", response.data.comment_status, "error", {
                          button: "OK!",
                        })
                    }
                })

            },
            lock_feed(e) {
                var vm = this
                vm.$swal({
                  title: 'Khoá câu hỏi?',
                  text: "Bạn chắc chắn khoá bài viết của mình! Bạn sẽ không thể mở lại!",
                  type: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Yes, Lock it!'
                }).then((result) => {
                    
                  if (result) {

                    axios({
                        method: "POST",
                        url: 'api/client/lock_feed',
                        data: {
                            feed_slug: e
                        },
                        headers: { Authorization : "Bearer " + this.$authjs.getToken() }
                    }).then(function(response) {
                        vm.$swal("Success!", response.data.success, "success", {
                          button: "OK!",
                        })
                        vm.$router.go()
                    })  
                  }
                }).catch(vm.$swal.noop)
            },
            edit_comment_feed(e) {
                var vm = this
                vm.select_cate = vm.feed.sub_cate_question.cate_question.slug
                vm.select_subcate = vm.feed.sub_cate_question.slug
                vm.point_set = vm.feed.point_feed
                vm.imageQuestionUrl = vm.feed.image

                vm.getCateQuestion()
                $('.showQuestionForm').css('display', 'inline-block')
            },
            getCateQuestion() {
                var vm = this
                var link = '/api/client/catequestion'
                axios.get(link).then((response) => {
                    vm.catequestion = response.data
                })
            },
            editQuestionFun(e) {
                var vm = this
                var data = {
                    feed_slug: e,
                    cate: vm.select_cate,
                    subcate: vm.select_subcate,
                    title: vm.title_question,
                    content: vm.content_question,
                    imageData: vm.dataImageQuestion,
                    imageUrl: vm.imageQuestionUrl
                }
                var link = '/api/client/edit_feed'
                axios.post(link, data, { headers: { Authorization: 'Bearer ' + this.$authjs.getToken() }})
                .then((response) => {
                    if(response.data.success) {
                        vm.$swal("Success!", response.data.success, "success", {
                              button: "OK!",
                        })
                        vm.$router.go()
                    } else {
                        vm.$swal("Error!", response.data.error, "error", {
                              button: "OK!",
                        })
                    }
                })
            },
            remove_comment_feed(e) {
                var vm = this
                vm.$swal({
                  title: 'Xoá câu hỏi?',
                  text: "Bạn chắc chắn xoá bài viết của mình!",
                  type: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    
                  if (result) {

                    axios({
                        method: "POST",
                        url: 'api/client/remove_feed',
                        data: {
                            feed_slug: e
                        },
                        headers: { Authorization : "Bearer " + this.$authjs.getToken() }
                    }).then(function(response) {
                        if(response.data.success) {
                            vm.$swal("Success!", response.data.success, "success", {
                              button: "OK!",
                            })
                            vm.$router.push({ name: 'ClientSocialLearningIndex' })
                        } else {
                            vm.$swal("Error!", response.data.error, "error", {
                              button: "OK!",
                            })
                        }
                        
                    })  
                  }
                }).catch(vm.$swal.noop)
            },
            select_cate_fun() {
                var vm = this
                vm.subcatequestion = null
                var link = '/api/client/catequestion/' + vm.select_cate
                axios.get(link).then((response) => {
                    vm.subcatequestion = response.data.subcatequestion
                })
            },

            cancel_resize_add() {
                var vm = this
                if(vm.zoom) {
                    $('.showQuestionForm').css('top', '20%')
                    vm.zoom = false
                } else {
                    $('.showQuestionForm').css('top', "")
                    vm.zoom = true
                }
            },
            cancel_minify_add() {
                var vm = this
                if(vm.minify) {
                    $('.showQuestionForm').css('top', '90%')
                    vm.minify = false
                } else {
                    $('.showQuestionForm').css('top', "")
                    vm.minify = true
                }
            },
            cancel_form_add() {
                $('.showQuestionForm').css('display', 'none')
            },
            editImage(event) {
                var vm = this
                vm.dataImageQuestion = null
                
                if(event.target.files[0]) {
                    $('.file-return-question').html(event.target.value)
                    let fileReader = new FileReader()
                    fileReader.readAsDataURL(event.target.files[0])

                    fileReader.onload = (e) => {
                        let dataImage = e.target.result
                        vm.dataImageQuestion = dataImage
                    }
                    $('#imgQuestion').css('display', 'inline')
                    $('#imgQuestion img').css('max-width', '200px')
                    $('.remove-add-image-question').css('display', 'inline')
                    vm.imageQuestionUrl = null

                } else {
                    vm.dataImageQuestion = null
                    $('#imgQuestion').css('display', 'none')
                    $('.file-return-question').html('')
                    $('.remove-add-image-question').css('display', 'none')
                }


            },
            removeImageDataQuestion() {
                var vm = this

                if(vm.dataImageQuestion) {
                    vm.dataImageQuestion = null
                    vm.imageQuestionUrl = vm.feed.image
                } else if(vm.imageQuestionUrl){

                    vm.$swal({
                          title: 'Xoá ảnh gốc?',
                          text: "Bạn chắc chắn xoá ảnh gốc bài viết!",
                          type: 'warning',
                          showCancelButton: true,
                          confirmButtonColor: '#3085d6',
                          cancelButtonColor: '#d33',
                          confirmButtonText: 'Yes, delete it!'
                        }).then((result) => {
                            
                          if (result) {
                                vm.dataImageQuestion = null
                                vm.imageQuestionUrl = null
                                $('.remove-add-image-question').css('display', 'none')   
                          }
                        }).catch(vm.$swal.noop)               
                }
                $('.file-return-question').html('')
            },
            loadMoreFun() {
                var vm = this
                var link = vm.comment_feeds.next_page_url
                if(link) {
                    axios.get(link, { headers: { Authorization: 'Bearer ' + this.$authjs.getToken() }}).then((response) => {
                        var res = response.data.comment_feeds

                        vm.comment_feeds.next_page_url = res.next_page_url
                        for(var i = 0; i < res.data.length; i++) {
                            var check = true
                            for(var j = 0; j < vm.comment_feeds.data.length; j++) {
                                if(vm.comment_feeds.data[j].id == res.data[i].id) {
                                    check = false;
                                    break;
                                }
                            }
                            if(check) {
                                vm.comment_feeds.data.push(res.data[i])
                            }
                            
                        }

                    })
                }
            }
        }
    }
</script>