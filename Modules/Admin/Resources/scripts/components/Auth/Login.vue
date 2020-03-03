<template>
	<secondary-layout>
		<template v-slot:main-content>
			<h1 class="fs-30 lp-25 text-center">Sign In</h1>

			<form method="post" action="">
				<p class="tnc pt-0 text-center">Admin Portal</p>
				<div class="auth-inputs">
					<div class="auth-input-wrapper">
						<input name="email" type="email" id="email_label" placeholder="Email Address..." v-model="data.email">
					</div>

					<div class="auth-input-wrapper">
						<input name="password" type="password" id="password_label" placeholder="Password..." v-model="data.password">
					</div>

					<div class="d-flex justify-content-center">
						<button type="submit" class="btn btn-primary" @click="onLogin">LOGIN</button>
					</div>
				</div>
			</form>
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
			}
		},
		methods: {
			...mapActions('session', {
				login: 'login',
			}),
			onLogin: function(e){
				e.preventDefault();
				this.login( this.data )
				.then((data) => {
					this.$router.replace({ name: 'root' });
				}).catch(() => {

				});
			}
		}
	}
</script>