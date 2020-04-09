export default {
	namespaced: true,
	state: {
		accessToken: null,
		refreshToken: null,
		expiresIn: null,
		currentUser: {},
	},
	getters: { 
		check(state){
			return !!state.accessToken;
		}
	},
	mutations: {
		init(state){
			state.accessToken = sessionStorage.getItem("access_token");
			state.refreshToken = sessionStorage.getItem("refresh_token");
			state.expiresIn = sessionStorage.getItem("expire_in");
		},
		setSession(state, payload){ 
			state.accessToken = payload.access_token;
			state.refreshToken = payload.refresh_token;
			state.expiresIn = payload.expires_in;

			sessionStorage.setItem("access_token", state.accessToken);
			sessionStorage.setItem("refresh_token", state.refreshToken);
			sessionStorage.setItem("expire_in", state.expiresIn);
		},
		setCurrentUser(state, payload){ 
			// 
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
		init(context){
			context.commit("init");
		},
		login(context, { email, password }) {
			let url = route('admin.login').url();

			return axios.post(url, { email, password })
			.then(({ data }) => {
				context.commit('setSession', data);
				return new Promoise.resolve();
			}).catch((response) => {
				return new Promoise.reject(response);
			});
		},
		logout(context){

		},
		refresh(context){
			let url = route('admin.refresh').url();

			return axios.post(url, { refresh_token: context.state.refreshToken })
			.then(({ data }) => {
				context.commit('setSession', data);
				return true;
			}).catch((response) => {
				return false;
			});
		},
		profile({ state, dispatch }){
			let accessToken = state.refreshToken;
			let url = route('admin.profile').url();


			return axios.get(url, {
				headers: {
					'Authorization': `Basic ${accessToken}`
				}
			}).then(({ data }) => {
				return Promise.resolve(true);
			}).catch(({ response }) => {
				let status = response.status;
				if(status == 401){
					return dispatch('refresh').then((state) => {
						if(!state){
							context.commit("unsetSession");
							return Promise.resolve(false);
						}

						return Promise.resolve(true);
					});
				}

				return Promise.resolve(false);
			});
		},
		validate({ state, dispatch, getters }){
			// get access token and call api for current user details
			// if 401 then request new access token
			// if got 401 again then logout the user and ask him to login again.
			// add a key to the session marking the last time you validated the user
			// this will stop the app from making requests to the server everytime since the token can last for more than 1 hour
			// update this session on each valid request.
			if(!getters.check) return Promise.resolve(false);

			return Promise.resolve(true);
			let retry = 3;
			let current = 0;
			let status = false;
			while(current <= retry){
				if (!getters.check) return Promise.resolve(false);
				dispatch('profile')
					.then((state) => {
						status = state;
						current = retry;		
					});
				current++;
			}

			return Promise.resolve(status);
		}
	}
};
