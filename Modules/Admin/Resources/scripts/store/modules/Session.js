export default {
	namespaced: true,
	state: {
		accessToken: sessionStorage.getItem("access_token") || null,
		refreshToken: sessionStorage.getItem("refresh_token") || null,
		expiresIn: sessionStorage.getItem("expire_in") || null
	},
	getters: {  },
	mutations: {
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
			return new Promise((resolve, reject) => {
				resolve();
			});
		},
		logout(context){
			context.commit('unsetSession');
		}
	}
};
