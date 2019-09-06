<template>
    <section class="card">
        <div class="card-header">
            Source Control
        </div>
        <Loader :loading="loading"/>

        <div class="section-body" v-if="hasConnected">
            <h4>Connected</h4>

            <div v-for="provider in connected" :key="provider.type" class="flex items-center mt-2">
                <div class="flex-1">
                    {{ provider.name }}
                </div>
                <a class="btn btn-outline btn-sm mr-5" :href="provider.links.refresh" >
                    <i class="fas fa-sync-alt"></i> Refresh token
                </a>
                <buttons class="btn btn-danger btn-sm mr-5" @click="unlink(provider)">
                    <i class="fas fa-unlink"></i> Unlink
                </buttons>
            </div>
        </div>

        <div class="section-body" v-if="isAvailable">
            <h4>Available connectors</h4>

            <a class="btn btn-outline mr-5" :href="provider.links.connect" v-for="provider in available" :key="provider.type">
                <i class="fab mr-1 fa-lg" :class="`${provider.icon}`"></i>
                {{ provider.name }}
            </a>
        </div>
    </section>
</template>

<script>
    export default {
        props: {
            user: Object
        },
        data() {
            return {
                loading: false,
                providers: [],
                connected: []
            }
        },
        mounted() {
            this.load()
        },
        methods: {
            async load() {
                this.loading = true

                try {
                    this.providers = await this.$api.sourceProviders.list()
                    this.connected = await this.$api.userProfile.sourceProviders()
                } catch (e) {
                    this.$handleError(e)
                }

                this.loading = false
            },
            refreshToken(provider) {

            }
        },
        computed: {
            available() {
                const keys = this.connected.map(p => p.type)

                return this.providers.filter(p => keys.indexOf(p.type) === -1)
            },
            isAvailable() {
                return this.available.length > 0
            },
            hasConnected() {
                return this.connected.length > 0
            }
        }
    }
</script>
