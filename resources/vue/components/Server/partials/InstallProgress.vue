<template>
    <div>
        <div class="alert alert-primary mb-8 rounded" v-if="isPending">
            <p>Run this code in your server and wait until server configuring</p>
            <code>{{ installScript }}</code>
            <Copy :text="installScript" />
        </div>

        <div v-if="isPending" class="py-10 text-center">
            <Loader :loading="true" />
            <h2 class="mt-5">Waiting for server response</h2>
        </div>

        <div v-if="isConfiguring">
            <ProgressBar size="medium" :val="progress" :text="`${progress}%`"/>
            <div class="mb-5" v-if="message">{{ message }}</div>
        </div>
    </div>
</template>

<script>
    import Copy from "@vue/components/UI/Copy"
    import ProgressBar from 'vue-simple-progress'

    export default {
        components: {ProgressBar, Copy},
        props: {
            server: Object
        },
        data() {
            return {
                progress: 5,
                message: null
            }
        },
        mounted() {
            this.$echo.channel('server.' + this.server.id)
                .listen('.App\\Events\\Server\\Event\\Created', (e) => {
                    this.message = e.event.message
                    if (typeof e.event.meta.progress != "undefined") {
                        this.progress = e.event.meta.progress
                    }
                })

            this.loadLastEvent()
        },
        methods: {
            async loadLastEvent() {
                try {
                    const response = await this.$api('v1.server.event.last', {server: this.server.id}).request()
                    this.last_event = response.data.data

                    this.message = this.last_event.message
                    if (typeof this.last_event.meta.progress != "undefined") {
                        this.progress = this.last_event.meta.progress
                    }
                } catch (e) {
                    console.error(e)
                }
            }
        },
        computed: {
            installScript() {
                return `wget -O sputnik.sh "${this.server.links.install_script}"; bash sputnik.sh`
            },
            isPending() {
                return this.server.status == 'pending'
            },
            isConfiguring() {
                return this.server.status == 'configuring'
            },
            isConfigured() {
                return this.server.status == 'configured'
            }
        },
    }
</script>
