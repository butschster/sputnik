<template>
    <div class="section">
        <div class="section-header">
            Use this public key for access deployment
        </div>
        <pre class="break-all whitespace-normal">
            <Loader :loading="loading" />
            <Copy :text="site.server.public_key"/><br />

            <button class="btn btn-sm btn-primary mt-5" @click="register" v-if="site.repository.is_source_provider">
                Register deploy key
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
                    await this.$api.serverSiteRepository.registerPublicKey(this.site.id)
                } catch (e) {
                    this.$handleError(e)
                }

                this.loading = false
            }
        }
    }
</script>