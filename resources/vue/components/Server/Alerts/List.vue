<template>
    <div>
        <Loader :loading="loading"/>

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
                alerts: []
            }
        },
        mounted() {
            this.load()
        },
        methods: {
            async load() {
                this.loading = true

                try {
                    this.alerts = await this.$api.serverAlerts.list(this.server.id)
                } catch (e) {
                    this.$handleError(e)
                }

                this.loading = false
            }
        }
    }
</script>