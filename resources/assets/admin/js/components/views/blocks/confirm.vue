<template>
	
	<div class="ConfirmModalWrapper">
		<span v-html="spanText" class="btn btn-xs" v-bind:class="spanClass" @click="handleActionButton()"></span>
		<div class="modal" v-bind:class="{'is-active': modalState}">
			<div class="modal-background"></div>
			<div class="modal-content">
				<h4>{{ message }}</h4>
				<p class="btn btn-success" @click="handleConfirmButton()">OK</p>
				<p class="btn btn-danger" @click="handleCloseButton()">Cancer</p>
			</div>
			<p class="modal-close" @click="handleCloseButton()"></p>
		</div>
	</div>

</template>
<script>
	export default {
    props: ['message','spanText', 'spanClass', 'url', 'dataSend']
    ,
		data() {
			return {
				modalState:false
			}
		}
		,
		methods: {
			handleActionButton() {
				this.modalState = true
			},
			handleCloseButton() {
				this.modalState = false
			},
			handleConfirmButton() {
				var vm = this
				axios.delete(vm.url+vm.dataSend, { headers: { Authorization: 'Bearer'+ " " + this.$auth.getToken() }})
				.then(function(response) {

            if(response.data.deleted) {
                vm.handleCloseButton()
                vm.$swal("Success!", response.data.message, "success", {
                          button: "OK!",
                        })
                vm.$parent.fetchData()
            } else {
            	vm.handleCloseButton()
                vm.$swal("Failed!", response.data.message, "error", {
                          button: "OK!",
                        })
            }
        }).catch(error => console.log(error))
			}
		}
	}
</script>