<template>
    <div>
        <CreateForm :server="$parent.server" class="mb-12" @created="load(0)"/>

        <h4>Active users ({{ users.data.length }})</h4>
        <div v-if="hasUsers">
            <Loader :loading="loading"/>
            <table class="table mb-10">
                <col>
                <col width="200px">
                <col width="200px">
                <col width="100px">
                <col width="100px">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Sudo password</th>
                    <th>Home</th>
                    <th class="text-right">Status</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="user in users.data">
                    <th>{{ user.name }}</th>
                    <td>
                        <Copy :text="user.sudo_password" :label="user.sudo_password"/>
                    </td>
                    <td>{{ user.home_dir }}</td>
                    <td class="text-right"><BadgeStatus :status="user.status" /></td>
                    <td class="text-right">
                        <a :href="user.links.download_key" class="btn btn-sm">
                            <i class="fas fa-download"></i>
                        </a>

                        <button class="btn btn-danger btn-sm" v-if="!user.is_system" @click="remove(user)">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>

            <Pagination :data="users" @pagination-change-page="load"/>
        </div>

        <div v-else class="well well-lg text-center">
            <img class="mx-auto mb-10" src="https://image.flaticon.com/icons/svg/1871/1871131.svg" alt="" width="100px">
            <h3 class="mb-0">Looks like you don't have any users yet</h3>
        </div>
    </div>
</template>

<script>
    import BadgeStatus from "@vue/components/UI/Badge/Status"
    import Copy from "@vue/components/UI/Copy"
    import Pagination from 'laravel-vue-pagination'
    import CreateForm from "@vue/components/Server/Users/Create"

    export default {
        components: {CreateForm, Pagination, Copy, BadgeStatus},
        data() {
            return {
                loading: false,
                page: 1,
                users: {
                    data: []
                }
            }
        },
        mounted() {
            this.load()
        },
        methods: {
            async load(page = 1) {
                this.loading = true

                if (page > 0) {
                    this.page = page
                }

                try {
                    this.users = await this.$api.serverUsers.list(this.$parent.server.id, this.page)
                } catch (e) {
                    console.error(e)
                }

                this.loading = false
            },
            removedUser(user) {
                this.load(0)
                this.$notify({
                    text: 'User successfully deleted',
                    type: 'success'
                });
            },
            async remove(user) {
                this.loading = true

                try {
                    await this.$api.serverUsers.remove(user.id)
                    this.removedUser(user)
                } catch (e) {
                    console.error(e)
                }

                this.loading = false
            }
        },
        computed: {
            hasUsers() {
                return this.users.data.length > 0
            }
        }
    }
</script>
