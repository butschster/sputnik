<template>
    <div>
        <h1>{{ $t(`mysql.title.${module}`) }}</h1>

        <CreateForm
                :server="server"
                :module="module"
                class="well well-lg mb-12"
                @created="load"
        />

        <div v-if="hasDatabase">
            <Loader :loading="loading"/>
            <h4>{{ $t('mysql.database.title') }} ({{ databases.length }})</h4>
            <table class="table mb-10">
                <col>
                <col width="200px">
                <col width="200px">
                <col width="100px">
                <col width="100px">
                <thead>
                <tr>
                    <th>{{ $t('mysql.database.table.name') }}</th>
                    <th>{{ $t('mysql.database.table.user') }}</th>
                    <th>{{ $t('mysql.database.table.password') }}</th>
                    <th>{{ $t('mysql.database.table.status') }}</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="database in databases">
                    <td>{{ database.meta.name }}</td>
                    <td>{{ database.meta.user }}</td>
                    <th>
                        <small>
                            <Copy :text="database.meta.password" label="*******"/>
                        </small>
                    </th>
                    <td class="text-right">
                        <BadgeTaskStatus :task="database.task"/>
                    </td>
                    <td class="text-right">
                        <button class="btn btn-danger btn-circle btn-sm" @click="destroy(database)">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <div v-else class="well well-lg text-center">
            <img class="mx-auto mb-10" src="https://image.flaticon.com/icons/svg/1265/1265529.svg" alt="" width="100px">
            <h3 class="mb-0">{{ $t('mysql.database.message.empty_list') }}</h3>
        </div>
    </div>
</template>

<script>
    import CreateForm from "./partials/CreateForm"

    export default {
        components: {CreateForm},
        data() {
            return {
                loading: false,
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
                    this.databases = await this.$api.mysqlDatabase.list(this.server.id, this.module)
                } catch (e) {
                    this.$handleError(e)
                }

                this.loading = false
            },
            onDestroy(database) {
                this.load()

                this.$notify.success(
                    this.$t('mysql.database.message.deleted')
                )
            },
            async destroy(database) {
                this.loading = true
                try {
                    await this.$api.mysqlDatabase.destroy(database.id)
                    this.onDestroy(database)
                } catch (e) {
                    this.$handleError(e)
                }
                this.loading = false
            }
        },
        computed: {
            hasDatabase() {
                return this.databases.length > 0
            },
            server() {
                return this.$parent.server
            },
            module() {
                return this.$route.meta.database
            }
        }
    }
</script>
