<template>
    <div class="w-full">
        <div class="container px-10">
        <template v-if="isPending">
            <div class="alert alert-primary mb-8 rounded">
                <p>{{ $t('server.installation.message.run_script') }}</p>
                <Copy :text="installScript">
                    <code>{{ installScript }}</code>
                </Copy>
            </div>

            <div class="py-10 text-center mb-12">
                <Loader :loading="true"/>
                <h2 class="mt-5">{{ $t('server.installation.message.waiting_response') }}</h2>
            </div>
        </template>

        <template v-if="isConfiguring">
            <section class="section mb-10">
                <div class="section-header">
                    {{ $t('server.installation.message.in_progress') }}
                    <p>{{ $t('server.installation.message.please_wait') }}</p>
                </div>
                <div class="section-body">
                    <div class="text-center font-bold text-gray-600">{{ progress }}%</div>
                    <ProgressBar class="mb-5" size="big" :val="progress" :bg-color="null" :bar-color="null"
                                 text-position="top"/>
                    <h4 class="mt-5" v-if="message">
                        {{ $t(`server.events.${message}`) }}...
                    </h4>
                </div>
            </section>
        </template>
        </div>
    </div>
</template>

<script>
    import ProgressBar from 'vue-simple-progress'
    import serverMixin from "@js/vue/mixins/server"

    export default {
        components: {ProgressBar},
        mixins: [serverMixin],
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
            }
        },
    }
</script>
