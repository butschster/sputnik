<template>
    <div>
        <h1>
            Databases
        </h1>

        <CreateForm :server="$parent.server" class="well well-lg mb-12" @created="load"/>

        <h4>Databases ({{ databases.length }})</h4>
        <div v-if="hasDatabase">
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
                    <th>User</th>
                    <th>Password</th>
                    <th>Status</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="database in databases">
                    <td>{{ database.name }}</td>
                    <td>{{ database.user }}</td>
                    <td>
                        <Copy :text="database.password" :label="database.password"/>
                    </td>
                    <td class="text-right">
                        <BadgeTaskStatus :status="database.status"/>
                    </td>
                    <td class="text-right">
                        <button class="btn btn-danger btn-circle btn-sm" @click="remove(database)">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <div v-else class="well well-lg text-center">
            <img class="mx-auto mb-10" src="https://image.flaticon.com/icons/svg/1265/1265529.svg" alt="" width="100px">
            <h3 class="mb-0">Looks like you don't have any databases yet</h3>
        </div>
    </div>
</template>

<script>
    import CreateForm from "@vue/components/Server/Database/CreateForm"

    export default {
        components: {CreateForm},
        data() {
            return {
                loading: false,
                page: 1,
                databases: []
            }
        },
        mounted() {
            this.load()
        },
        methods: {
            async load() {
                this.loading = true

                try {
                    this.databases = await this.$api.serverDatabases.list(this.$parent.server.id)
                    console.log(this.databases)
                } catch (e) {
                    this.$handleError(e)
                }

                this.loading = false
            },
            removedDatabase(database) {
                this.load()

                this.$notify.success('Database successfully deleted')
            },
            async remove(database) {
                this.loading = true
                try {
                    await this.$api.serverDatabases.remove(database.id)
                    this.removedDatabase(database)
                } catch (e) {
                    this.$handleError(e)
                }
                this.loading = false
            }
        },
        computed: {
            hasDatabase() {
                return this.databases.length > 0
            }
        }
    }
</script>
