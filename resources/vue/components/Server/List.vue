<template>
    <section class="servers-list">
        <loader :loading="loading"/>
        <h4>Servers</h4>
        <div class="servers-list-items">
            <div class="servers-list-item-wrapper" v-for="server in servers">
                <div class="servers-list-item__status">
                    <div class="status-indicator" :class="server.status"></div>
                </div>
                <div class="servers-list-item__name">
                    <router-link :to="{name: 'server.show', params: {id: server.id }}">
                        {{ server.name }}
                    </router-link>
                    <div class="servers-list-item__address">{{ server.ip }}</div>
                </div>
                <div class="servers-list-item__project">
                    {{ server.team.name }}
                </div>
            </div>
        </div>
    </section>
</template>
<script>
    export default {
        data() {
            return {
                servers: [],
                loading: false
            }
        },
        mounted() {
            this.load()
        },
        methods: {
            async load() {
                this.loading = true

                try {
                    const response = await this.$api('v1.servers').request();
                    this.servers = response.data.data
                } catch (e) {
                    console.error(e)
                }

                this.loading = false
            }
        },
    }
</script>
