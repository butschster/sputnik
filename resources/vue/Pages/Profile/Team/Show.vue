<template>
    <div class="w-full">
        <div class="container pl-10 pt-12">
            <Loader :loading="loading"/>
            <div v-if="team">
                <h1 class="mb-4 flex items-center">
                    <img src="https://image.flaticon.com/icons/svg/1171/1171856.svg" width="50px">
                    {{ team.name }}
                </h1>
                <div class="mb-10">
                <span class="badge badge-warning" v-if="team.is_trial_period">
                    {{ $t('user.team.subscription.trial_ends_at') }} {{ team.subscription.trial_ends_at | moment('DD/MM/YYYY') }}
                </span>

                    <span class="badge badge-error ml-5" v-if="team.is_cancelled">
                    {{ $t('user.team.subscription.ends_at') }} {{ team.subscription.ends_at | moment('DD/MM/YYYY') }}
                </span>
                </div>
            </div>
        </div>

            <div class="tabs" role="tabs">
                <div class="container pl-10">
                    <router-link :to="$link.profileTeam(team)" class="tab">
                        {{ $t('user.team.members.title') }}
                    </router-link>
                    <router-link :to="$link.profileTeamSubscription(team)" class="tab">
                        {{ $t('user.team.subscription.title') }}
                    </router-link>
                    <router-link :to="$link.profileTeamBilling(team)" class="tab">
                        {{ $t('user.team.billing.title') }}
                    </router-link>
                </div>
            </div>
            <router-view/>
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
