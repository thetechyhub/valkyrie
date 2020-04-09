<template>
	<secondary-layout>
		<template v-slot:main-content>
			<div class="container mx-auto px-4 h-100">
				<div class="group-container">
					<div class="form-container px-4">
						<div class="d-flex justify-content-center flex-column">
							<h1 class="title text-center">Admin Portal</h1>
						</div>

						<form class="pb-3">
							<div class="alert alert-danger" role="alert" v-if="error">
  							{{ error }}
							</div>
							<div class="form-group">
								<label for="email-address">Email Address</label>
								<input type="email" class="form-control" id="email-address" placeholder="Email Address..." v-model="data.email">
							</div>
							<div class="form-group">
								<label for="password">Password</label>
								<input type="password" class="form-control" id="password" placeholder="Password..." v-model="data.password">
							</div>

							<button type="submit" class="btn btn-submit" @click="onLogin">SIGN IN</button>
						</form>
					</div>
				</div>
			</div>
		</template>
	</secondary-layout>
</template>

<script>
	import { mapState, mapActions } from 'vuex';

	export default {
		props: [],
		computed: {
			...mapState({
				session: state => state.session,
			}),
		},
		data: function(){
			return {
				data: {},
				error: null,
			}
		},
		methods: {
			...mapActions('session', {
				login: 'login',
			}),
			onLogin: function(e){
				e.preventDefault();
				this.login( this.data )
				.then(() => {
					this.$router.replace({ name: 'root' });
				}).catch(() => {
					this.error = "Email or password is incorrect."
				});
			}
		}
	}
</script>