import axios from "axios";

const state = {
	users: {},
};
const getters = {};

const actions = {
	getList({commit}, pageNumber) {
		axios.get('/api/users?page=' + pageNumber)
			.then(response => {
				commit('setUsers', response.data);
			});
	},
	addUser({}, data) {
		return axios.post('/api/users', data);
	},
	editUser({}, data) {
		return axios.put('/api/users/' + data.id, data);
	},
	deleteUser({}, id) {
		//console.log(id);
		return axios.delete('/api/users/' + id);
	}
};
const mutations = {
	setUsers(state, data) {
		state.users = data;
	},
	setCurrentPage(state, data) {
		state.users.current_page = data;
	}
};

export default {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
}