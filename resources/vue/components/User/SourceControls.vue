<template>
    <section class="section">
        <div class="section-header">
            Source Control
        </div>

        <div class="section-body">
            <Loader :loading="loading" />

            <a class="btn btn-outline mr-5" :href="provider.links.connect" v-for="provider in providers">
                <i class="fab mr-1 fa-lg" :class="`${provider.icon}`"></i>
                {{ provider.name }}
            </a>
        </div>
    </section>
</template>

<script>
    export default {
        data() {
            return {
                loading: false,
                providers: []
            }
        },
        mounted() {
            this.load()
        },
        methods: {
            async load() {
                this.loading = true

                try {
                    const response = await this.$api('v1.source_providers').request()
                    this.providers = response.data
                } catch (e) {
                    console.error(e)
                }

                this.loading = false
            }
        }
    }
</script>
