<template>
    <div>
        <h1>
            {{ $t('openvpn.clients.title') }}
        </h1>

        <CreateForm :server="$parent.server" class="well well-lg mb-12" @created="load()"/>

        <h4>{{ $t('openvpn.clients.clients') }} ({{ clients.length }})</h4>
        <div v-if="hasClients">
            <Loader :loading="loading"/>
            <table class="table mb-10">
                <col>
                <col width="200px">
                <col width="150px">
                <col width="100px">
                <thead>
                <tr>
                    <th>{{ $t('openvpn.clients.table.name') }}</th>
                    <th class="text-right">{{ $t('openvpn.clients.table.status') }}</th>
                    <th class="text-right">{{ $t('openvpn.clients.table.time') }}</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="client in clients">
                    <th>{{ client.meta.name }}</th>
                    <td class="text-right">
                        <BadgeTaskStatus :task="client.task"/>
                    </td>
                    <td class="text-right">
                        <BadgeTimeFrom :date="client.created_at"/>
                    </td>
                    <td class="text-right">
                        <a class="btn btn-default btn-circle btn-sm" :href="client.links.download">
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
            <h3 class="mb-0">{{ $t('openvpn.clients.message.empty_results') }}</h3>
        </div>
    </div>
</template>

<script>
    import CreateForm from "./partials/Create"

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
                    this.clients = await this.$api.openVpnClient.list(this.$parent.server.id)
                } catch (e) {
                    this.$handleError(e)
                }

                this.loading = false
            },
            removedUser(client) {
                this.load()
                this.$notify.success(this.$t('openvpn.clients.message.deleted'))
            },
            async remove(client) {
                this.loading = true

                try {
                    await this.$api.openVpnClient.remove(client.id)
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
