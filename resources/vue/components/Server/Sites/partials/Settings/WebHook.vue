<template>
    <div class="section section--border-b">
        <div class="section-header">
            Deployment Trigger URL

            <p>
                Using a custom Git service, or want a service like Travis CI to run your tests before your
                application is deployed to Forge? It's simple. When you commit fresh code, or when your continuous
                integration service finishes testing your application, instruct the service to make a GET or POST
                request to the following URL. Making a request to this URL will trigger your Forge deployment
                script:
            </p>
        </div>
        <pre class="break-all whitespace-normal mt-5">
            <Loader :loading="loading" />
            <Copy :text="site.links.hooks_url"/><br />

            <button class="btn btn-sm btn-primary mt-5" @click="register" v-if="site.repository.is_source_provider">
                Register web hook
            </button>
        </pre>
    </div>
</template>

<script>
    export default {
        props: {
            site: Object
        },
        data() {
            return {
                loading: false
            }
        },
        methods: {
            async register() {
                this.loading = true

                try {
                    await this.$api.serverSiteRepository.registerWebhook(this.site.id)
                } catch (e) {
                    this.$handleError(e)
                }

                this.loading = false
            }
        }
    }
</script>