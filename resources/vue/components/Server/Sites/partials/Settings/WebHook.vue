<template>
    <div class="section section--border-b">
        <div class="section-header">
            {{ $t('site.webhook.title') }}

            <p>{{ $t('site.webhook.description') }}</p>
        </div>
        <pre class="break-all whitespace-normal mt-5">
            <Loader :loading="loading" />
            <Copy :text="site.links.hooks_url"/><br />

            <button class="btn btn-sm btn-primary mt-5" @click="register" v-if="site.repository.is_source_provider">
                {{ $t('site.webhook.button.register') }}
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