<template>
    <div>
        <ProgressBar size="medium" :val="progress" :text="`${progress}%`"/>
        <div class="mb-5" v-if="message">{{ message }}</div>
    </div>
</template>

<script>
    import ProgressBar from 'vue-simple-progress'

    export default {
        components: {ProgressBar},
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
        }
    }
</script>