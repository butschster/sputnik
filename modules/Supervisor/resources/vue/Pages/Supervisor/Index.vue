<template>
    <div>
        <h1>
            {{ $t('supervisor.title') }}
        </h1>

        <CreateForm :server="$parent.server" @created="load" class="well well-lg mb-12"/>

        <div class="mt-10" v-if="hasDaemons">
            <Loader :loading="loading"/>

            <h4>{{ $t('supervisor.daemons') }} ({{ daemons.length }})</h4>

            <table class="table mb-0">
                <col>
                <col>
                <col width="100px">
                <col width="100px">
                <col width="100px">
                <col width="80px">
                <thead class="thead-dark">
                <tr>
                    <th>{{ $t('supervisor.table.command') }}</th>
                    <th>{{ $t('supervisor.table.directory') }}</th>
                    <th class="text-center">{{ $t('supervisor.table.procs') }}</th>
                    <th class="text-right">{{ $t('supervisor.table.user') }}</th>
                    <th class="text-right">{{ $t('supervisor.table.status') }}</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="daemon in daemons" :key="daemon.id">
                    <th>{{ daemon.command }}</th>
                    <td>{{ daemon.directory }}</td>
                    <td class="text-center">{{ daemon.processes }}</td>
                    <td class="text-right">{{ daemon.user }}</td>
                    <td class="text-right">
                        <BadgeTaskStatus :task="daemon.task"/>
                    </td>

                    <td class="text-right">
                        <button class="btn btn-danger-outline btn-circle btn-sm" @click="destroy(daemon)">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>

        </div>

        <div v-else class="well well-lg text-center">
            <img class="mx-auto mb-10" src="https://image.flaticon.com/icons/svg/1681/1681597.svg" alt="" width="100px">
            <h3 class="mb-0">{{ $t('supervisor.message.empty_list') }}</h3>
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
                daemons: []
            }
        },
        mounted() {
            this.load()
        },
        methods: {
            async load() {
                this.loading = true

                try {
                    this.daemons = await this.$api.supervisor.list(this.$parent.server.id)
                } catch (e) {
                    this.$handleError(e)
                }

                this.loading = false
            },
            async destroy(daemon) {
                this.loading = true

                try {
                    await this.$api.supervisor.remove(daemon.id)
                    this.onDestroy(daemon)
                } catch (e) {
                    this.$handleError(e)
                }

                this.loading = false
            },
            onDestroy(daemon) {
                this.load()
                this.$notify.success(this.$t('supervisor.message.deleted'))
            }
        },
        computed: {
            hasDaemons() {
                return this.daemons.length > 0
            }
        }
    }
</script>
