<template>
	<div>
		<v-card class="d-flex pa-2"
				outlined
				tile
				width="100%">
			<v-container>
				<v-card-title>
					<v-spacer></v-spacer>
					<v-text-field
							v-model="search"
							append-icon="mdi-magnify"
							label="Search"
							single-line
							hide-details
					></v-text-field>
				</v-card-title>
				<v-data-table
						expand-icon
						item-key="name"
						:headers="headers"
						:items="users"
						dense
						:items-per-page="perPage"
						hide-default-footer
						:search="search"
						class="elevation-0"
				>
					<template slot="top">
						<v-toolbar flat color="dark">
							<v-toolbar-title>Users</v-toolbar-title>
							<v-divider
									class="mx-4"
									inset
									vertical
							></v-divider>
							<v-spacer></v-spacer>
							<v-dialog v-model="dialog" max-width="500px">
								<template v-slot:activator="{ on }">
									<v-btn color="red" dark class="mb-2" v-on="on">New Item</v-btn>
								</template>
								<v-card>
									<v-card-title>
										<span class="headline">{{ formTitle }}</span>
									</v-card-title>
									<v-card-text>
										<v-container>
											<v-row>
												<v-col cols="12" sm="6" md="6">
													<v-text-field dark v-model="editedItem.name"
																  label="Name"></v-text-field>
													<form-error v-if="errors.name" :errors="errors">
														{{ errors.name[0] }}
													</form-error>
												</v-col>
												<v-col cols="12" sm="6" md="6">
													<v-text-field dark v-model="editedItem.email"
																  label="E-mail"></v-text-field>
													<form-error v-if="errors.email" :errors="errors">
														{{ errors.email[0] }}
													</form-error>
												</v-col>
											</v-row>
										</v-container>
									</v-card-text>
									<v-card-actions>
										<v-spacer></v-spacer>
										<v-btn color="grey darken-1" text @click="close">Cancel</v-btn>
										<v-btn color="red darken-1" text @click="submit">Save</v-btn>
									</v-card-actions>
								</v-card>
							</v-dialog>
						</v-toolbar>
					</template>
					<template v-slot:item.actions="{ item }">
						<v-icon
								small
								class="mr-2"
								@click="edit(item)"
						>
							mdi-pencil
						</v-icon>
						<v-icon
								small
								@click="destroy(item)"
						>
							mdi-delete
						</v-icon>
					</template>
				</v-data-table>
				<template slot="no-data">
					No users found.
				</template>
				<paginate store="user" collection="users"/>
			</v-container>

		</v-card>
		<v-snackbar
				v-model="show"
				:color="color"
				:timeout="2000"
				:bottom="true"
				:left="true"
		>
			{{ message }}
			<v-btn
					dark
					text
					@click="show = false"
			>
				Close
			</v-btn>
		</v-snackbar>
	</div>
</template>

<script>
	import paginate from '../paginate';
	import FormError from '../FormError';

	export default {
		components: {
			paginate,
			FormError
		},
		watch: {
			dialog(val) {
				val || this.close()
			},
		},
		data() {
			return {
				dialog: false,
				search: '',
				headers: [
					{text: 'ID', align: 'left', value: 'id',},
					{text: 'Name', value: 'name'},
					{text: 'Email', value: 'email'},
					{text: 'Reg. date', value: 'created_at'},
					{text: 'Actions', value: 'actions', sortable: false},

				],
				editedIndex: -1,
				editedItem: {
					id: '',
					name: '',
					email: '',
					created_at: ''
				},
				defaultItem: {
					id: '',
					name: '',
					email: '',
					created_at: ''
				},
				errors: {},
				/* Notification Settings */
				show: false,
				message: '',
				color: ''
			}
		},
		computed: {
			users: {
				get() {
					return this.$store.state.user.users.data;
				}
			},
			perPage: {
				get() {
					return this.$store.state.user.users.per_page;
				}
			},
			currentPage: {
				get() {
					return this.$store.state.user.users.current_page;
				}
			},
			formTitle() {
				return this.editedIndex === -1 ? 'New Item' : 'Edit Item';
			},
		},
		created() {
			this.$store.dispatch('user/getList', 0);
		},
		methods: {
			edit(item) {
				this.editedIndex = this.users.indexOf(item);
				this.editedItem = Object.assign({}, item);
				this.dialog = true;
			},
			store() {
				this.$store.dispatch('user/addUser', this.editedItem)
					.then(({data}) => {
						this.close();
						this.users.push(data);
						this.notify('The ticket was added successfully', 'success');
					})
					.catch((error) => {
						this.errors = error.response.data.errors;
						console.log(this.errors);
						this.notify('There was an error adding the item', 'error');
					})
			},
			update() {
				this.$store.dispatch('user/editUser', this.editedItem)
					.then(({data}) => {
						this.close();
						this.$store.dispatch('user/getList', this.currentPage);
						this.notify('The item was modified successfully', 'success');
					})
					.catch((error) => {
						this.errors = error.response.data.errors;
						console.log(error);
						this.notify('There was an error editing the item', 'error');
					})
			},
			destroy(item) {
				if (confirm('Are you sure you want to delete this item?')) {
					const index = this.users.indexOf(item);
					this.$store.dispatch('user/deleteUser', item.id).then(() => {
						this.users.splice(index, 1);
						this.notify('The item was deleted successfully', 'success');
					})
						.catch((error) => {
							console.log(error);
							this.notify('There was an error deleting the ticket.', 'error');
						})
				}
			},
			submit() {
				if (this.editedIndex > -1) {
					this.update()
				} else {
					this.store();
				}
			},
			close() {
				this.dialog = false;
				this.errors = {};
				setTimeout(() => {
					this.editedItem = Object.assign({}, this.defaultItem);
					this.editedIndex = -1;
				}, 300)
			},
			notify(message, color) {
				this.message = message;
				this.color = color;
				this.show = true;
			}
		}
	}
</script>