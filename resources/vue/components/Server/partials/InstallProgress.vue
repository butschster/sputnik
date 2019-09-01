<template>
    <div>
        <template v-if="isPending">
            <div class="alert alert-primary mb-8 rounded">
                <p>Run this code in your server and wait until server configuring</p>
                <Copy :text="installScript"/>
            </div>

            <div class="py-10 text-center">
                <Loader :loading="true"/>
                <h2 class="mt-5">Waiting for server response</h2>
            </div>
        </template>


        <template v-if="isConfiguring">
            <section class="section well mb-10">
                <div class="section-header">
                    Installation is in progress
                    <p>Please wait for a while</p>
                </div>
                <div class="section-body">
                    <div class="text-center font-bold text-gray-600">{{ progress }}%</div>
                    <ProgressBar class="mb-5" size="big" :val="progress" :bg-color="null" :bar-color="null" text-position="top" />
                    <h4 class="mt-5" v-if="message">{{ message }}...</h4>
                </div>
            </section>
        </template>
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
            this.$echo.onServerEventCreated(this.server.id, (e) => {
                this.message = e.event.message
                if (typeof e.event.meta.progress != "undefined") {
                    this.progress = e.event.meta.progress
                }
            })

            this.isConfiguring && this.loadLastEvent()
        },
        methods: {
            async loadLastEvent() {
                this.last_event = await this.$api.serverEvents.lastOne(this.server.id)

                this.message = this.last_event.message
                if (typeof this.last_event.meta.progress != "undefined") {
                    this.progress = this.last_event.meta.progress
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
