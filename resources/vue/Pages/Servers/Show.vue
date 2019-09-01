<template>
    <div>
        <Loader :loading="loading"/>
        <div v-if="server">
            <h1 class="mb-8 flex items-center">
                <ServerStatus :server="server" class="mr-3" />
                {{ server.name }}
            </h1>

            <div class="tabs" role="tabs" v-if="!isPending">
                <router-link :to="{name: 'server.show', params: {id: server.id }}" class="tab">Sites</router-link>
                <router-link :to="{name: 'server.information', params: {id: server.id }}" class="tab">Information</router-link>
                <router-link :to="{name: 'server.events', params: {id: server.id }}" class="tab">Events</router-link>
                <router-link :to="{name: 'server.tasks', params: {id: server.id }}" class="tab">Tasks</router-link>
                <router-link :to="{name: 'server.settings', params: {id: server.id }}" class="tab">Settings</router-link>
            </div>

            <InstallProgress :server="server" />

            <router-view />
        </div>
    </div>
</template>
<script>

    import ServerStatus from "@vue/components/Server/partials/ServerStatus"
    import InstallProgress from "@vue/components/Server/partials/InstallProgress"

    export default {
        components: {InstallProgress, ServerStatus},
        data() {
            return {
                server: null,
                loading: false,
            }
        },
        mounted() {
            this.load()
        },
        methods: {
            loaded() {
                this.$echo.serverChannel(this.server.id)
                    .listen('.App\\Events\\Server\\StatusChanged', (e) => {
                        this.server.status = e.status
                        console.log(e)
                    })

                this.$store.dispatch('server/setServer', this.server)
            },
            async load() {
                this.loading = true

                try {
                    this.server = await this.$api.server.show(this.$route.params.id)
                    this.loaded()
                } catch (e) {
                    this.$router.replace({name: "404"})
                    throw e
                }

                this.loading = false
            }
        },
        computed: {
            isPending() {
                return this.server.status == 'pending'
            },
            isConfiguring() {
                return this.server.status == 'configuring'
            },
            isConfigured() {
                return this.server.status == 'configured'
            }
        },

        watch: {
            '$route': 'load'
        }
    }
</script>
