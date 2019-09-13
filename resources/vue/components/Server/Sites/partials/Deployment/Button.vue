<template>
    <div class="well">
        <Loader :loading="loading" />
        <button class="btn btn-primary" @click="deploy" v-if="showButton">
            Deploy!
        </button>

        <ProgressBar size="big" :val="progress" :bg-color="null" :bar-color="null" text-position="top" v-else />
    </div>
</template>

<script>
    import ProgressBar from 'vue-simple-progress'

    export default {
        components: {ProgressBar},
        props: {
            site: Object
        },
        data() {
            return {
                loading: false,
                progress: 15
            }
        },
        mounted() {
            if (!this.showButton) {
                this.animateProgressBar()
            }
        },
        methods: {
            async deploy() {
                this.loading = true
                this.progress = 0

                try {
                    await this.$api.serverSiteDeployment.deploy(this.site.id)
                    this.animateProgressBar()
                } catch (e) {
                    this.$handleError(e)
                }

                this.loading = false
            },
            animateProgressBar(step = 5) {
                this.progress += 5
                if(this.progress < 70 ) {
                    return setTimeout(this.animateProgressBar, 1500);
                } else if(this.progress < 90 ) {
                    return setTimeout(() => {
                        this.animateProgressBar(3)
                    }, 1500);
                } else if(this.progress < 95 ) {
                    return setTimeout(() => {
                        this.animateProgressBar(1)
                    }, 1500);
                }
            }
        },
        computed: {
            showButton() {
                return this.$gate.allow('deploy', 'site', this.site)
            }
        }
    }
</script>