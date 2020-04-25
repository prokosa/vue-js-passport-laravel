<template>
	<v-app id="inspire">
		<v-navigation-drawer
				v-model="drawer"
				app
				clipped
		>
			<v-list dense>
				<v-list-item to="/dashboard" link>
					<v-list-item-action>
						<v-icon>mdi-view-dashboard</v-icon>
					</v-list-item-action>
					<v-list-item-content>
						<v-list-item-title>Dashboard</v-list-item-title>
					</v-list-item-content>
				</v-list-item>
				<v-list-item to="/users" link>
					<v-list-item-action>
						<v-icon>mdi-account-multiple</v-icon>
					</v-list-item-action>
					<v-list-item-content>
						<v-list-item-title>Users</v-list-item-title>
					</v-list-item-content>
				</v-list-item>
				<v-list-item link @click="logout">
					<v-list-item-action>
						<v-icon>mdi-power</v-icon>
					</v-list-item-action>
					<v-list-item-content>
						<v-list-item-title>Log out</v-list-item-title>
					</v-list-item-content>
				</v-list-item>
			</v-list>
		</v-navigation-drawer>

		<v-app-bar
				app
				clipped-left
		>
			<v-app-bar-nav-icon @click.stop="drawer = !drawer"/>
			<v-toolbar-title>{{currentUser.email}}</v-toolbar-title>
		</v-app-bar>

		<v-content>
			<v-container
					class="fill-height"
					fluid
			>
				<v-layout child-flex>
						<router-view></router-view>

				</v-layout>
			</v-container>
		</v-content>

		<v-footer app>
			<span>&copy; 2019</span>
		</v-footer>
	</v-app>
</template>

<script>
	export default {
		props: {
			source: String,
		},
		data: () => ({
			drawer: null,
		}),

		computed: {
			loggedIn: {
				get() {
					return this.$store.state.currentUser.loggedIn
				}
			},
			currentUser: {
				get() {
					return this.$store.state.currentUser.user;
				}
			}
		},

		methods: {
			logout() {
				this.$store.dispatch('currentUser/logoutUser');
			},
		},

		created() {
			if (localStorage.hasOwnProperty("spa_token")) {
				axios.defaults.headers.common["Authorization"] = "Bearer " + localStorage.getItem("spa_token");
				this.$store.dispatch('currentUser/getUser');
				this.$vuetify.theme.dark = true;
			} else {
				window.location.replace("/login");
			}
		}
	}
</script>