<template>
    <div>
        <h2>Deployment</h2>

        <DeploymentButton :site="site" class="section--border-b" />
        <DeploymentList :site="site" class="section--border-b" />
        <Configuration :site="site" />
    </div>
</template>

<script>
    import DeploymentButton from "@vue/components/Server/Sites/partials/Deployment/Button"
    import Configuration from "@vue/components/Server/Sites/partials/Deployment/Configuration"
    import DeploymentList from "@vue/components/Server/Sites/partials/Deployment/List"

    export default {
        components: {DeploymentButton, Configuration, DeploymentList},
        data() {
            return {

            }
        },
        mounted() {
            this.loadConfiguration()
        },
        methods: {
            async loadConfiguration() {
                try {
                    const response = await this.$api.serverSiteDeployment.script(this.site.id)

                    this.config = response.config
                } catch (e) {
                    this.$handleError(e)
                }
            }
        },
        computed: {
            site() {
                return this.$parent.site
            }
        }
    }
</script>