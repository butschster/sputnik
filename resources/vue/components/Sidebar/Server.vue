<template>
    <div v-if="server">
        <div class="sidebar-section" v-if="isConfigured">
            <h5>Server</h5>
            <div class="nav">
                <router-link class="nav-link" :to="{name: 'server.users', params: { id: server.id }}">Users</router-link>
                <router-link class="nav-link" :to="{name: 'server.firewall', params: { id: server.id }}">Firewall</router-link>
                <router-link class="nav-link" :to="{name: 'server.scheduler', params: { id: server.id }}">Scheduler</router-link>
                <router-link class="nav-link" :to="{name: 'server.supervisor', params: { id: server.id }}">Supervisor</router-link>
                <router-link class="nav-link" :to="{name: 'server.database', params: { id: server.id }}">Database</router-link>
            </div>
        </div>
    </div>

</template>

<script>
    import {mapGetters} from 'vuex'

    export default {
        computed: {
            ...mapGetters('server', {
                server: 'getServer'
            }),
            isConfigured() {
                return this.server.status == 'configured'
            }
        }
    }
</script>