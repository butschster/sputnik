<template>
    <section class="section">
        <Loader :loading="loading" />
        <div class="section-header">
            Configuration
            <p>We use <a href="https://deployer.org/">deployer</a> for zero-time deployment. If you want to
                configure it, please read <a href="https://deployer.org/docs/getting-started.html">documentation</a>.
            </p>
        </div>
        <pre>{{ config }}</pre>
    </section>
</template>

<script>
    export default {
        props: {
            site: Object
        },
        data() {
            return {
                loading: false,
                config: null
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
        }
    }
</script>