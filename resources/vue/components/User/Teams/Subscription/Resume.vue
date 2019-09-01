<template>
    <div>
        <Loader :loading="loading" />
        <div class="border-green-300 border-2 bg-gray-100 py-8 px-8 my-12 flex items-center">
            <div class="flex-1">
                <h2>Resume subscription</h2>
                <p>Pavel, just before you go, here are some courses we've got coming up that you might be interested in.</p>
            </div>
            <div>
                <button class="btn btn-primary" @click="onResume">
                    Resume :)
                </button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            team: Object
        },
        data() {
            return {
                loading: false
            }
        },
        methods: {
            async onResume() {
                this.loading = true

                try {
                    await this.$apiRoute('v1.team.subscription.resume', {team: this.team.id}).request()
                } catch (e) {
                    console.error(e)
                }

                this.loading = false
            }
        }
    }
</script>
