<template>
    <div>
        <Loader :loading="loading"/>
        <div v-if="server">
            <div class="mb-8 flex items-center">
                <ServerStatus :server="server" class="mr-5"/>
                <div>
                    <h1 class="mb-0">{{ server.name }}</h1>
                    <div class="text-gray-600">
                        Team
                        <router-link :to="$link.profileTeam(server.team)">
                            {{ server.team.name }}
                        </router-link>

                        <span class="text-gray-500" v-if="hasSysInfo"> - {{ server.sys_info.name }}</span>
                    </div>
                </div>
            </div>

            <NotSupported v-if="!isSupported" :server="server"/>

            <div class="tabs" role="tabs">
                <router-link v-for="(item, index) in links" :key="index" :to="item.link" class="tab">
                    {{ $t(item.title)}}
                </router-link>
            </div>

            <InstallProgress :server="server"/>

            <router-view/>
        </div>
    </div>
</template>
<script>
    import LinksManager from '@js/LinksManager'
    import ServerStatus from "@vue/components/Server/partials/ServerStatus"
    import InstallProgress from "@vue/components/Server/partials/InstallProgress"
    import NotSupported from "@vue/components/Server/partials/NotSupported"
    import serverMixin from "@js/vue/mixins/server"

    export default {
        components: {InstallProgress, ServerStatus, NotSupported},
        mixins: [serverMixin],
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

                this.$echo.onServerTaskStatusChanged(this.server.id, (e) => {
                    this.$bus.$emit(`task.${e.task.id}`, e.task)
                })

                this.$store.dispatch('server/setServer', this.server)
            },
            async load() {
                this.loading = true

                this.server = null

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
            links() {
                return LinksManager.serverTopSidebar.linksWithArgs(this.server)
            }
        },
        watch: {
            '$route'(route) {
                this.load()
            }
        }
    }
</script>
