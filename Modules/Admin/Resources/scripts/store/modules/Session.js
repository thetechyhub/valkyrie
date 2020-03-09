export default {
	namespaced: true,
	state: {
		accessToken: null,
		refreshToken: null,
		expiresIn: null
	},
	getters: { 
		check(state){
			return !!state.accessToken;
		}
	},
	mutations: {
		init(state){
			state.accessToken = sessionStorage.getItem("access_token")
			state.refreshToken = sessionStorage.getItem("refresh_token");
			state.expiresIn = sessionStorage.getItem("expire_in");

			dispatch('validate');
		},
		setSession(state, { accessToken, refreshToken, expiresIn }){ 
			state.accessToken = accessToken;
			state.refreshToken = refreshToken;
			state.expiresIn = expiresIn;

			sessionStorage.setItem("access_token", accessToken);
			sessionStorage.setItem("refresh_token", refreshToken);
			sessionStorage.setItem("expire_in", expiresIn);
		},
		unsetSession: function(){
			state.accessToken = null;
			state.refreshToken = null;
			state.expiresIn = null;

			sessionStorage.removeItem("access_token");
			sessionStorage.removeItem("refresh_token");
			sessionStorage.removeItem("expire_in");
		}
	},
	actions: {
		login(context, { email, password }) {
			let url = route('admin.login').url();
			axios.post(url, { email, password })
			.then(({ data }) => {
				return Promise.resolve(data);
			}).catch((response) => {
				return Promise.reject(response);
			});
		},
		logout(context){

		},
		validate(context){
			if(context.getters.check) return Promise.resolve(false);


			// get access token and call api for current user details
			// if 401 then request new access token
			// if got 401 again then logout the user and ask him to login again.
			// add a key to the session marking the last time you validated the user
			// this will stop the app from making requests to the server everytime since the token can last for more than 1 hour
			// update this session on each valid request.
		}
	}
};
