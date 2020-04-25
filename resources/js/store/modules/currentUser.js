import axios from "axios";

const state = {
	user: {}
};
const getters = {};

const actions = {
	getUser({commit}) {
		axios.get('/api/user')
			.then(response => {
				commit('setUser', response.data);
			});
	},
	loginUser({}, user) {
		axios.post('/api/login', {
			email: user.email,
			password: user.password
		}).then(response => {
				if (response.data.access_token) {
					//save token
					localStorage.setItem('spa_token', response.data.access_token);
					window.location.replace('/app');
				}
			})
	},
	logoutUser(){
		localStorage.removeItem("spa_token");
		window.location.replace('/login');
	}
};
const mutations = {
	setUser(state, data) {
		state.user = data;
	}
};

export default {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
}