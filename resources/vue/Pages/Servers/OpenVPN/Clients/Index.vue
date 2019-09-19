<template>
    <div>
        <h1>
            OpenVPN Clients
        </h1>

        <CreateForm :server="$parent.server" class="well well-lg mb-12" @created="load()"/>

        <h4>Active clients ({{ clients.length }})</h4>
        <div v-if="hasClients">
            <Loader :loading="loading"/>
            <table class="table mb-10">
                <col>
                <col width="200px">
                <col width="150px">
                <col width="100px">
                <thead>
                <tr>
                    <th>Name</th>
                    <th class="text-right">Status</th>
                    <th class="text-right">Created At</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="client in clients">
                    <th>{{ client.name }}</th>
                    <td class="text-right">
                        <BadgeTaskStatus :task="client.task" />
                    </td>
                    <td class="text-right">
                        <BadgeTimeFrom :date="client.created_at" />
                    </td>
                    <td class="text-right">
                        <a class="btn btn-default btn-circle btn-sm" :href="client.links.download" >
                            <i class="fas fa-download"></i>
                        </a>

                        <button class="btn btn-danger btn-circle btn-sm" @click="remove(client)">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <div v-else class="well well-lg text-center">
            <img class="mx-auto mb-10" src="https://image.flaticon.com/icons/svg/1871/1871131.svg" alt="" width="100px">
            <h3 class="mb-0">Looks like you don't have any clients yet</h3>
        </div>
    </div>
</template>

<script>
    import CreateForm from "@vue/components/Server/OpenVPN/Clients/Create"

    export default {
        components: {CreateForm},
        data() {
            return {
                loading: false,
                clients: []
            }
        },
        mounted() {
            this.load()
        },
        methods: {
            async load() {
                this.loading = true

                try {
                    this.clients = await this.$api.serverOpenVPNClients.list(this.$parent.server.id)
                } catch (e) {
                    this.$handleError(e)
                }

                this.loading = false
            },
            removedUser(client) {
                this.load()
                this.$notify.success('Client successfully deleted')
            },
            async remove(client) {
                this.loading = true

                try {
                    await this.$api.serverOpenVPNClients.remove(client.id)
                    this.removedUser(client)
                } catch (e) {
                    this.$handleError(e)
                }

                this.loading = false
            }
        },
        computed: {
            hasClients() {
                return this.clients.length > 0
            }
        }
    }
</script>
