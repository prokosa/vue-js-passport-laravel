import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter);

import Dashboard from '../components/dashboard/container'
import Users from '../components/users/container'

const routes = [
	{
		component: Dashboard,
		name: "dashboard",
		path: "/dashboard"
	},
	{
		component: Users,
		name: "users",
		path: "/users"
	}
];

export default new VueRouter({
	routes
});