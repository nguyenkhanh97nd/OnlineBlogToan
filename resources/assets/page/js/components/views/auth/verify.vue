<template>
	<div class="container">
		<p>Bấm để kích hoạt tài khoản </p>
		<button class="btn btn-success" @click="activeAccount">Kích hoạt</button>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				link: '',
				param: '',
			}
		},
		created() {
			this.param = this.$route.params.code
			this.link = '/register/verify/' + this.$route.params.code
		},
		methods: {
			activeAccount() {
				var vm = this
				axios.post(vm.link).then((response) => {
					vm.$swal("Success!", response.data.confirm_email, "success", {
                      button: "OK!",
                    });
					this.$router.push({ name: 'ClientLogin' })
				}, (error) => {
					vm.$swal("Error!", "Lỗi!", "error", {
                      button: "OK!",
                    })
                    this.$router.push({ name: 'ClientIndex' })
				})
			}
		}
	}
</script>