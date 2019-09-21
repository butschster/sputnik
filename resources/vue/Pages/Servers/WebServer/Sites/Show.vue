<template>
    <div v-if="site" class="w-full">

        <div class="container px-10">
            <div class="flex items-center">
                <h2 class="flex flex-1 items-center">
                    <img src="https://image.flaticon.com/icons/svg/1055/1055685.svg" width="40px" class="mr-4">
                    <a :href="site.links.url" target="_blank">{{ site.domain }}</a>
                </h2>

                <span class="badge badge-warning mr-5" v-if="site.domain_expires_at">
                Expires at {{ site.domain_expires_at | moment('DD/MM/YYYY') }}
            </span>

                <BadgeTaskStatus :task="site.task"/>
            </div>

            <div class="mt-10 flex items-start">
                <LeftMenu>
                    <router-link :to="$link.serverSiteDeployment(site)" v-if="$gate.allow('deploy', 'site', site)">
                        Deployment
                    </router-link>
                    <router-link :to="$link.serverSiteEnvironment(site)" v-if="$gate.allow('deploy', 'site', site)">
                        Environment
                    </router-link>
                    <router-link :to="$link.serverSite(site)">
                        Settings
                    </router-link>
                </LeftMenu>
                <router-view class="flex-1 ml-10"/>
            </div>
        </div>
    </div>
</template>

<script>
    import LeftMenu from "@vue/Layouts/Partials/Content/LeftMenu"

    export default {
        components: {LeftMenu},
        data() {
            return {
                site: null,
                loading: false,
            }
        },
        mounted() {
            this.load()

            this.$bus.$on('site.updated', (site) => {
                this.load()
            })
        },
        methods: {
            async load() {
                this.loading = true

                try {
                    this.site = await this.$api.serverSites.show(this.$route.params.site_id)

                    this.$echo.onSiteDeployment(this.site.id, () => {
                        this.load()
                    })

                } catch (e) {
                    this.$handleError(e)
                    this.$router.replace({name: "404"})
                }

                this.loading = false
            }
        },
        computed: {
            server() {
                return this.$parent.server
            }
        }
    }
</script>
