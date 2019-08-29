<template>
    <div>

    </div>
</template>

<script>
    export default {
        props: {
            server: Object
        },
        data() {
            return {
                loading: false,
                sites: []
            }
        },
        mounted() {
            this.load()
        },
        methods: {
            async load() {
                this.loading = true

                try {
                    const response = await this.$api('v1.server.sites', {server: this.$route.params.id}).request()
                    this.sites = response.data.data
                } catch (e) {
                    console.error(e)
                }

                this.loading = false
            }
        }
    }
</script>
