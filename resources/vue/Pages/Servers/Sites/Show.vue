<template>
    <div v-if="site">
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

        <div class="section" v-if="$gate.allow('deploy', 'server', site)">
            <div class="section-header">
                Git repository details

                <div>
                    <button class="btn btn-warning btn-sm"><i class="fas fa-play-circle mr-2"></i> Deploy!</button>
                </div>
            </div>
            <div class="progress rounded-0" v-if="site.is_deploying">
                <div class="progress-bar progress-bar-striped progress-bar-animated"
                     role="progressbar" aria-valuenow="75"
                     aria-valuemin="0" aria-valuemax="100"
                     style="width: 45%">Deployment
                </div>
            </div>
        </div>


        <div class="mt-10 flex items-start">
            <LeftMenu>
                <router-link :to="$link.serverSiteDeployment(site)">
                    Deployment
                </router-link>
                <router-link :to="$link.serverSiteEnvironment(site)">
                    Environment
                </router-link>
                <router-link :to="$link.serverSite(site)">
                    Settings
                </router-link>
            </LeftMenu>
            <router-view class="flex-1 ml-10"/>
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
