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
				return Promise.resolve();
			}).catch((response) => {
				return Promise.reject(response);
			});
		},
		logout(context){

		},
		refresh(context){
			let url = route('admin.refresh').url();

			return axios.post(url, { refresh_token: context.state.refreshToken })
			.then(({ data }) => {
				context.commit('setSession', data);
				return Promise.resolve();
			}).catch((response) => {
				return Promise.reject(response);
			});
		},
		profile({ state, dispatch }){
			let accessToken = state.accessToken;
			let url = route('admin.profile').url();


			return axios.get(url, {
				headers: {
					'Authorization': `Bearer ${accessToken}`
				}
			}).then(({ data }) => {
				context.commit("setCurrentUser", data);
				return Promise.resolve();
			}).catch(({ response }) => {
				return Promise.reject(response);
			});
		},
		validate({ state, dispatch, getters }){
			if(!getters.check) return Promise.resolve(false);

			return dispatch('profile')
				.then(() => {
					return Promise.resolve(true);
				}).catch(() => {
					return dispatch("refresh")
            .then(() => {
							dispatch("profile").then(() => {}).catch(() => {});
							return Promise.resolve(true);
						}).catch(() => {
							return Promise.resolve(false);
						});
				});
		}
	}
};
