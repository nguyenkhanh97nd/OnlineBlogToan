<template>
	<div class="container">
		<div class="row" v-if="current_user">
		    <div class="col-md-9">
		        <div class="heading-block col-sm-12">
		            <a><router-link  :to="{ name: 'ClientIndex' }">Trang chủ </router-link></a>|
		            <a><router-link  :to="{ name: 'ClientFollow' }">Trang chủ </router-link></a>

		            <div class="pull-right search-friend" @input="search">
		            	<input class="form-control" v-model="searchKeyword" name="searchfriend" type="text" placeholder="Tìm kiếm bạn bè">
		            </div>
		            <a @click="show_followers" class="pull-right invite-friend">{{ followers.length }} Followers</a>
		        </div>
		        

		        <div v-if="show_followers_model">
		            <div v-for="friend in followers">

		                <div class="content-item-subcategory col-sm-6">
		                    <div class="row">
		                        <div class="col-md-2 media">
		                            <div class="row">
		                                <router-link  :to="{ name: 'ClientProfileIndex', params: { userslug: friend.username } }">
	                                	<a>
		                                    <div v-if="friend.avatar">

		                                       <img class="img-responsive" style="width: 70px;" :src="'public/upload/users/' +friend.avatar"/>

		                                    </div>
		                                    <div v-if="!friend.avatar">
		                                        <div class="friend-list-span text-center">
		                                          <span>{{ friend.name.substring(0,1) }}</span>
		                                        </div>
		                                    </div>
		                                
		                                </a>
		                            	</router-link>
		                            </div>
		                        </div>
		                        <div class="col-md-10 caption">

		                            <p class="friend-list-name"><router-link  :to="{ name: 'ClientProfileIndex', params: { userslug: friend.username } }"><a>{{ friend.name }}</a></router-link></p>
		                            
		                            <div v-if="check_following(friend.id, followings)">
										<button class="be-add-received-type" @click="doRemoveFollow(friend.username)">Unfollow</button>
		                              
		                            </div>

		                            <div v-if="!check_following(friend.id, followings)">
		                            	<button class="be-add-received-type" @click="doAddFollow(friend.username)">Follow</button>
		                            
		                            </div>
		                        </div>
		                    </div>
		                </div>
		            </div>
		        </div>

		        <div v-if="!searchKeyword && !show_followers_model">
		            <div v-for="friend in followings">

		                <div class="content-item-subcategory col-sm-6">
		                    <div class="row">
		                        <div class="col-md-2 media">
		                            <div class="row">
		                                
	                                	<router-link  :to="{ name: 'ClientProfileIndex', params: { userslug: friend.username } }">
	                                	<a>
		                                    <div v-if="friend.avatar">

		                                       <img class="img-responsive" style="width: 70px;" :src="'public/upload/users/' +friend.avatar"/>

		                                    </div>
		                                    <div v-if="!friend.avatar">
		                                        <div class="friend-list-span text-center">
		                                          <span>{{ friend.name.substring(0,1) }}</span>
		                                        </div>
		                                    </div>
		                                
		                                </a>
		                            	</router-link>
		                            </div>
		                        </div>
		                        <div class="col-md-10 caption">
		                            <p class="friend-list-name"><router-link  :to="{ name: 'ClientProfileIndex', params: { userslug: friend.username } }"><a>{{ friend.name }}</a></router-link></p>

		                            <button class="be-add-received-type" @click="doRemoveFollow(friend.username)">Unfollow</button>
		                        </div>
		                    </div>
		                </div>

		            </div>
		        </div>
		        <div v-if="searchKeyword">
		            <div v-for="friend in users">


		                <div class="content-item-subcategory col-sm-6">
		                    <div class="row">
		                        <div class="col-md-2 media">
		                            <div class="row">
		                                <router-link  :to="{ name: 'ClientProfileIndex', params: { userslug: friend.username } }"><a>
		                                    <div v-if="friend.avatar">

		                                       <img class="img-responsive" style="width: 70px;" :src="'public/upload/users/' +friend.avatar"/>

		                                    </div>
		                                    <div v-if="!friend.avatar">
		                                        <div class="friend-list-span text-center">
		                                          <span>{{ friend.name.substring(0,1) }}</span>
		                                        </div>
		                                    </div>
		                                
		                                </a></router-link>
		                            </div>
		                        </div>
		                        <div class="col-md-10 caption">
		                            <p class="friend-list-name"><router-link  :to="{ name: 'ClientProfileIndex', params: { userslug: friend.username } }"><a>{{ friend.name }}</a></router-link></p>
		                            <div v-if="check_following(friend.id, followings)">
										<button class="be-add-received-type" @click="doRemoveFollow(friend.username)">Unfollow</button>
		                              
		                            </div>

		                            <div v-if="!check_following(friend.id, followings)">
		                            	<button class="be-add-received-type" @click="doAddFollow(friend.username)">Follow</button>
		                            
		                            </div>
		                        </div>
		                    </div>
		                </div>

		            </div>
		        </div>
		    </div>

		    <div class="col-md-3 hidden-sm hidden-xs">
		        <p class="heading-title">THỐNG KÊ</p>
		        <p>Following: {{ followings.length }}</p>
		        <p>Followers: {{ followers.length }}</p>
		    </div>
		</div>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				followers: '',
				followings: '',
				users: '',
				current_user: '',
				searchKeyword: '',
				show_followers_model: '',

				link_add: '',
				link_remove: '',
				link_following: '',
				link_follower: '',
			}
		},
		mounted() {
			if(this.$authjs.isAuthenticated()) {
				this.getUser()

				this.link_add = '/api/client/addFollow'
				this.link_remove = '/api/client/removeFollow'
				this.link_following = '/api/client/following'
				this.link_follower = '/api/client/followers'

				this.show_followers_model = false

				this.fetchData()
			}
		},
		methods: {
			search() {
				var vm = this

				vm.show_followers_model = false
				axios({
                    method: "POST",
                    url: vm.link_following,
                    data: {
                    	search_user: vm.searchKeyword
                    },
                    headers: { Authorization : "Bearer " + this.$authjs.getToken() }
                }).then(function(response) {
                    vm.users = response.data.users
                })
			},
			show_followers() {
				var vm = this
				vm.searchKeyword = ''
				vm.show_followers_model = true
			},
			getUser() {
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
				axios({
                    method: "POST",
                    url: vm.link_following,
                    data: '',
                    headers: { Authorization : "Bearer " + this.$authjs.getToken() }
                }).then(function(response) {
                    vm.followers = response.data.followers
                    vm.followings = response.data.followings
                    vm.users = response.data.users
                })
			},
			check_following(id_check, array_check) {
				var i
				for(i=0;i<array_check.length; i++) {
					if(array_check[i].id == id_check) {
						return 1
						break
					}
				}
				return 0;
			},
			doAddFollow(username) {
				var vm = this
				var getUsername = username
				
				axios({
                    method: "POST",
                    url: vm.link_add,
                    data: {
                    	username: getUsername
                    },
                    headers: { Authorization : "Bearer " + this.$authjs.getToken() }
                }).then(function(response) {
                    vm.$swal("Success!", response.data.success, "success", {
                      button: "OK!",
                    })
                    vm.$router.go()
                })
			},
			doRemoveFollow(username) {
				var vm = this
				var getUsername = username
				vm.$swal({
				  title: 'Bỏ theo dõi?',
				  text: "Bạn chắc chắn bỏ theo dõi!",
				  type: 'warning',
				  showCancelButton: true,
				  confirmButtonColor: '#3085d6',
				  cancelButtonColor: '#d33',
				  confirmButtonText: 'Yes, Unfollow!'
				}).then((result) => {
					
				  if (result) {

				  	axios({
	                    method: "POST",
	                    url: vm.link_remove,
	                    data: {
	                    	username: getUsername
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
			}
		}
	}
</script>