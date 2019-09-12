<template>
    <div>
        <h1>
            Users
        </h1>

        <CreateForm :server="$parent.server" class="well well-lg mb-12" @created="load()"/>

        <h4>Active users ({{ users.length }})</h4>
        <div v-if="hasUsers">
            <Loader :loading="loading"/>
            <table class="table mb-10">
                <col>
                <col width="200px">
                <col width="200px">
                <col width="100px">
                <col width="150px">
                <col width="100px">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Sudo password</th>
                    <th>Home</th>
                    <th class="text-right">Status</th>
                    <th class="text-right">Created At</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="user in users">
                    <th>{{ user.name }}</th>
                    <td>
                        <Copy :text="user.sudo_password" :label="user.sudo_password"/>
                    </td>
                    <td>{{ user.home_dir }}</td>
                    <td class="text-right">
                        <BadgeTaskStatus :task="user.task" />
                    </td>
                    <td class="text-right">
                        <BadgeTimeFrom :date="user.created_at" />
                    </td>
                    <td class="text-right">
                        <a class="btn btn-default btn-circle btn-sm" :href="user.links.download_key" >
                            <i class="fas fa-download"></i>
                        </a>

                        <button class="btn btn-danger btn-circle btn-sm" v-if="!user.is_system" @click="remove(user)">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <div v-else class="well well-lg text-center">
            <img class="mx-auto mb-10" src="https://image.flaticon.com/icons/svg/1871/1871131.svg" alt="" width="100px">
            <h3 class="mb-0">Looks like you don't have any users yet</h3>
        </div>
    </div>
</template>

<script>
    import CreateForm from "@vue/components/Server/Users/Create"

    export default {
        components: {CreateForm},
        data() {
            return {
                loading: false,
                page: 1,
                users: []
            }
        },
        mounted() {
            this.load()
        },
        methods: {
            async load() {
                this.loading = true

                try {
                    this.users = await this.$api.serverUsers.list(this.$parent.server.id)
                } catch (e) {
                    this.$handleError(e)
                }

                this.loading = false
            },
            removedUser(user) {
                this.load()
                this.$notify.success('User successfully deleted')
            },
            async remove(user) {
                this.loading = true

                try {
                    await this.$api.serverUsers.remove(user.id)
                    this.removedUser(user)
                } catch (e) {
                    this.$handleError(e)
                }

                this.loading = false
            }
        },
        computed: {
            hasUsers() {
                return this.users.length > 0
            }
        }
    }
</script>
