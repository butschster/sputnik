<template>
    <div>
        <Loader :loading="loading"/>
        <div v-if="team">
            <h1 class="mb-4 flex items-center">
                <img src="https://image.flaticon.com/icons/svg/1171/1171856.svg" width="50px">
                {{ team.name }}
            </h1>

            <div class="mb-10">
                <span class="badge badge-warning" v-if="team.is_trial_period">
                    Trial ends at {{ team.subscription.trial_ends_at | moment('DD/MM/YYYY') }}
                </span>

                <span class="badge badge-error ml-5" v-if="team.is_cancelled">
                    Subscription cancelled and ends at {{ team.subscription.ends_at | moment('DD/MM/YYYY') }}
                </span>
            </div>

            <div class="tabs" role="tabs">
                <router-link :to="{name: 'profile.team.show', params: {id: team.id }}" class="tab">Members</router-link>
                <router-link :to="{name: 'profile.team.subscription', params: {id: team.id }}" class="tab">Subscription</router-link>
                <router-link :to="{name: 'profile.team.billing', params: {id: team.id }}" class="tab">Billing</router-link>
            </div>

            <router-view />
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                team: null,
                loading: false,
            }
        },
        mounted() {
            this.$bus.$on('paymentMethodsChanged', () => {
                this.load()
            })

            this.$bus.$on('subscribed', () => {
                this.load()
            })

            this.load()
        },
        methods: {
            async load() {
                this.loading = true

                try {
                    this.team = await this.$api.team.show(this.$route.params.id)
                } catch (e) {
                    this.$router.replace({name: "404"})
                    throw e
                }

                this.loading = false
            }
        },
    }
</script>