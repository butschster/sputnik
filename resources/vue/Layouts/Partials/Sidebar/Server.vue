<template>
    <div class="sidebar-section" v-if="server && isConfigured">
        <h5>Server</h5>
        <nav class="nav">
            <router-link class="nav-link" :to="$link.serverUsers(server)"><span class="w-8 inline-block">
                        <i class="fas fa-server"></i>
                        </span>Users
            </router-link>
            <router-link class="nav-link" :to="$link.serverFirewall(server)"><span class="w-8 inline-block">
                        <i class="fas fa-globe"></i>
                        </span>Firewall
            </router-link>
            <router-link class="nav-link" :to="$link.serverScheduler(server)"> <span class="w-8 inline-block">
                        <i class="far fa-calendar-alt"></i>
                        </span>Scheduler
            </router-link>
            <router-link class="nav-link" :to="$link.serverSupervisor(server)"><span class="w-8 inline-block">
                        <i class="far fa-chart-bar"></i>
                        </span>Supervisor
            </router-link>
            <router-link class="nav-link" :to="$link.serverDatabases(server)"> <span class="w-8 inline-block">
                        <i class="fas fa-server"></i>
                        </span>Database
            </router-link>
        </nav>
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
