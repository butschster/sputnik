<template>
    <div class="sidebar-section" v-if="server && isConfigured">
        <h5>Server</h5>
        <div class="nav">
            <router-link class="nav-link" :to="$link.serverUsers(server)">Users</router-link>
            <router-link class="nav-link" :to="$link.serverFirewall(server)">Firewall</router-link>
            <router-link class="nav-link" :to="$link.serverScheduler(server)">Scheduler</router-link>
            <router-link class="nav-link" :to="$link.serverSupervisor(server)">Supervisor</router-link>
            <router-link class="nav-link" :to="$link.serverDatabases(server)">Database</router-link>
        </div>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex'

    export default {
        computed: {
            ...mapGetters('server', {
                server: 'getServer',
                isConfigured: 'isConfigured'
            })
        }
    }
</script>
