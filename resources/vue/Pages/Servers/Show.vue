<template>
    <div>
        <Loader :loading="loading"/>
        <div v-if="server">
            <div class="mb-8 flex items-center">
                <ServerStatus :server="server" class="mr-5"/>
                <div>
                    <h2 class="mb-0">{{ server.name }}</h2>
                    <div class="text-gray-600">
                        Team
                        <router-link :to="{name: 'profile.team.show', params: {id: server.team.id }}">
                            {{ server.team.name }}
                        </router-link>

                        <span class="text-gray-500" v-if="hasSysInfo"> - {{ server.sys_info.name }}</span>
                    </div>
                </div>
            </div>

            <NotSupported v-if="!isSupported" :server="server" />

            <div class="tabs" role="tabs">
                <router-link :to="{name: 'server.show', params: {id: server.id }}" class="tab">Sites</router-link>
                <router-link :to="{name: 'server.information', params: {id: server.id }}" class="tab">Information</router-link>
                <router-link :to="{name: 'server.events', params: {id: server.id }}" class="tab">Events</router-link>
                <router-link :to="{name: 'server.tasks', params: {id: server.id }}" class="tab">Tasks</router-link>
                <router-link :to="{name: 'server.settings', params: {id: server.id }}" class="tab">Settings</router-link>
            </div>

            <InstallProgress :server="server"/>

            <router-view/>
        </div>
    </div>
</template>
<script>

    import ServerStatus from "@vue/components/Server/partials/ServerStatus"
    import InstallProgress from "@vue/components/Server/partials/InstallProgress"
    import NotSupported from "@vue/components/Server/partials/NotSupported"

    export default {
        components: {InstallProgress, ServerStatus, NotSupported},
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
                this.$echo.onServerStatusChanged(this.server.id, (e) => {
                    this.server.status = e.status
                })

                this.$echo.onServerConfigured(this.server.id, (e) => {
                    this.load()
                })

                this.$store.dispatch('server/setServer', this.server)
            },
            async load() {
                this.loading = true

                try {
                    this.server = await this.$api.server.show(this.$route.params.id)
                    this.loaded()
                } catch (e) {
                    this.$handleError(e)
                    this.$router.replace({name: "404"})
                }

                this.loading = false
            }
        },
        computed: {
            canBeManaged() {
                return this.isSupported && this.isSupported
            },
            isPending() {
                return this.server.status == 'pending'
            },
            isConfiguring() {
                return this.server.status == 'configuring'
            },
            isConfigured() {
                return this.server.status == 'configured'
            },
            hasSysInfo() {
                return this.server.hasOwnProperty('sys_info')
            },
            isSupported() {

                if (this.hasSysInfo) {
                    return this.server.sys_info.is_supported
                }

                return true
            }
        },
        watch: {
            '$route': 'load'
        }
    }
</script>
