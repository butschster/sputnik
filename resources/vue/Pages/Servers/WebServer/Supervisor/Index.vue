<template>
    <div>
        <h1>
            Supervisor
        </h1>

        <CreateForm :server="$parent.server" @created="load" class="well well-lg mb-12"/>

        <div class="mt-10" v-if="hasDaemons">
            <Loader :loading="loading"/>

            <table class="table mb-0">
                <col>
                <col>
                <col width="100px">
                <col width="100px">
                <col width="100px">
                <col width="80px">
                <thead class="thead-dark">
                <tr>
                    <th>Command</th>
                    <th>Directory</th>
                    <th class="text-center">Procs</th>
                    <th class="text-right">User</th>
                    <th class="text-right">Status</th>
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
                        <button class="btn btn-danger-outline btn-circle btn-sm" @click="remove(daemon)">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <div v-else class="well well-lg text-center">
            <img class="mx-auto mb-10" src="https://image.flaticon.com/icons/svg/1681/1681597.svg" alt=""
                 width="100px">
            <h3 class="mb-0">Looks like you don't have any daemons yet</h3>
        </div>
    </div>

</template>

<script>
    import CreateForm from "@vue/components/Server/Supervisor/CreateForm"

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
                    this.daemons = await this.$api.serverSupervisor.list(this.$parent.server.id)
                } catch (e) {
                    this.$handleError(e)
                }

                this.loading = false
            },
            async remove(daemon) {
                this.loading = true

                try {
                    await this.$api.serverSupervisor.remove(daemon.id)
                    this.onRemoved(daemon)
                } catch (e) {
                    this.$handleError(e)
                }

                this.loading = false
            },
            onRemoved(daemon) {
                this.load()
                this.$notify.success('Daemon successfully deleted')
            }
        },
        computed: {
            hasDaemons() {
                return this.daemons.length > 0
            }
        }
    }
</script>
