<template>
    <div>
        <Loader :loading="loading"/>
        <div v-if="server">
            <h1 class="mb-4">
                <i class="fas fa-hdd mr-3"></i>
                {{ server.name }}
            </h1>

            <div class="tabs" role="tabs">
                <router-link :to="{name: 'server.show', params: {id: server.id }}" class="tab">Sites</router-link>
                <router-link :to="{name: 'server.information', params: {id: server.id }}" class="tab">Information</router-link>
                <router-link :to="{name: 'server.events', params: {id: server.id }}" class="tab">Events</router-link>
                <router-link :to="{name: 'server.tasks', params: {id: server.id }}" class="tab">Tasks</router-link>
                <router-link :to="{name: 'server.settings', params: {id: server.id }}" class="tab">Settings</router-link>
            </div>

            <div class="alert alert-primary mb-8 rounded" v-if="isPending">
                <p>Run this code in your server and wait until server configuring</p>
                <code>{{ installScript }}</code>
                <Copy :text="installScript" />
            </div>

            <InstallProgress v-if="isConfiguring" :server="server" />

            <router-view />
        </div>
    </div>
</template>
<script>
    import Copy from "@vue/components/UI/Copy";
    import InstallProgress from "@vue/components/Server/partials/InstallProgress"

    export default {
        components: {InstallProgress, Copy},
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
                this.$echo.channel('server.' + this.server.id)
                    .listen('.App\\Events\\Server\\StatusChanged', (e) => {
                        this.server.status = e.status
                        console.log(e)
                    })

                this.$store.dispatch('server/setServer', this.server)
            },
            async load() {
                this.loading = true

                try {
                    const response = await this.$api('v1.server.show', {server: this.$route.params.id}).request()
                    this.server = response.data.data
                    this.loaded()
                } catch (e) {
                    console.error(e)
                    this.$router.replace({name: "404"})
                }

                this.loading = false
            }
        },
        computed: {
            installScript() {
                return `wget -O sputnik.sh "${this.server.links.install_script}"; bash sputnik.sh`
            },
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
