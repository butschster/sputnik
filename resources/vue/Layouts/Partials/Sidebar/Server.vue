<template>
    <div class="sidebar-section" v-if="server && isConfigured">
        <h5>Server</h5>

        <nav class="nav">
            <router-link v-for="item in nav" class="nav-link" :to="item.link">
                <span class="w-8 inline-block"><i class="fas" :class="item.icon"></i></span>
                {{ item.title }}
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
            }),
            nav() {
                switch (this.server.type) {
                    case 'openvpn':
                        return [
                            {
                                link: this.$link.serverFirewall(this.server),
                                icon: 'fa-globe',
                                title: 'Firewall'
                            },
                            {
                                link: this.$link.serverUsers(this.server),
                                icon: 'fa-server',
                                title: 'Users'
                            },
                            {
                                link: this.$link.serverScheduler(this.server),
                                icon: 'fa-calendar-alt',
                                title: 'Scheduler'
                            },
                        ]
                }

                return [
                    {
                        link: this.$link.serverSites(this.server),
                        icon: 'fa-globe',
                        title: 'Sites'
                    },
                    {
                        link: this.$link.serverFirewall(this.server),
                        icon: 'fa-globe',
                        title: 'Firewall'
                    },
                    {
                        link: this.$link.serverUsers(this.server),
                        icon: 'fa-server',
                        title: 'Users'
                    },
                    {
                        link: this.$link.serverScheduler(this.server),
                        icon: 'fa-calendar-alt',
                        title: 'Scheduler'
                    },
                    {
                        link: this.$link.serverSupervisor(this.server),
                        icon: 'fa-chart-bar',
                        title: 'Supervisor'
                    },
                    {
                        link: this.$link.serverDatabases(this.server),
                        icon: 'fa-server',
                        title: 'Database'
                    }
                ]

            }
        }
    }
</script>
