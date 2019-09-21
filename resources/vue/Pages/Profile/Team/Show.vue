<template>
    <div>
        <div class="wrap-bg">
            <figure class="wrap-bg__svg">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="1170px"
                     height="348px">
                    <path fill-rule="evenodd" fill="rgb(35, 23, 123)"
                          d="M-0.011,116.317 L8.682,113.988 L11.011,122.681 L2.318,125.011 L-0.011,116.317 Z"></path>
                    <path fill-rule="evenodd" fill="rgb(35, 23, 123)"
                          d="M463.014,336.868 L474.131,331.013 L479.986,342.131 L468.868,347.984 L463.014,336.868 Z"></path>
                    <path fill-rule="evenodd" fill="rgb(93, 203, 250)"
                          d="M610.564,-0.012 L623.995,8.556 L615.429,21.987 L601.997,13.419 L610.564,-0.012 Z"></path>
                    <path fill-rule="evenodd" fill="rgb(35, 23, 123)"
                          d="M1123.000,78.000 C1127.418,78.000 1131.000,81.582 1131.000,86.000 C1131.000,90.418 1127.418,94.000 1123.000,94.000 C1118.582,94.000 1115.000,90.418 1115.000,86.000 C1115.000,81.582 1118.582,78.000 1123.000,78.000 Z"></path>
                    <path fill-rule="evenodd" fill="rgb(35, 23, 123)"
                          d="M1088.000,288.000 C1090.761,288.000 1093.000,290.239 1093.000,293.000 C1093.000,295.761 1090.761,298.000 1088.000,298.000 C1085.239,298.000 1083.000,295.761 1083.000,293.000 C1083.000,290.239 1085.239,288.000 1088.000,288.000 Z"></path>
                    <path fill-rule="evenodd" fill="rgb(93, 203, 250)"
                          d="M910.000,172.000 C912.761,172.000 915.000,174.238 915.000,177.000 C915.000,179.761 912.761,182.000 910.000,182.000 C907.238,182.000 905.000,179.761 905.000,177.000 C905.000,174.238 907.238,172.000 910.000,172.000 Z"></path>
                    <path fill-rule="evenodd" fill="rgb(93, 203, 250)"
                          d="M57.000,317.000 C59.209,317.000 61.000,318.791 61.000,321.000 C61.000,323.209 59.209,325.000 57.000,325.000 C54.791,325.000 53.000,323.209 53.000,321.000 C53.000,318.791 54.791,317.000 57.000,317.000 Z"></path>
                    <path fill-rule="evenodd" fill="rgb(74, 92, 246)"
                          d="M178.500,83.000 C184.299,83.000 189.000,87.701 189.000,93.500 C189.000,99.299 184.299,104.000 178.500,104.000 C172.701,104.000 168.000,99.299 168.000,93.500 C168.000,87.701 172.701,83.000 178.500,83.000 Z"></path>
                    <path fill-rule="evenodd" fill="rgb(35, 23, 123)"
                          d="M276.500,275.000 C278.985,275.000 281.000,277.014 281.000,279.500 C281.000,281.985 278.985,284.000 276.500,284.000 C274.015,284.000 272.000,281.985 272.000,279.500 C272.000,277.014 274.015,275.000 276.500,275.000 Z"></path>
                    <path fill-rule="evenodd" fill="rgb(74, 92, 246)"
                          d="M861.131,312.447 L853.879,325.370 L846.314,312.267 L861.131,312.447 Z"></path>
                </svg>
            </figure>

            <div class="container px-10 pt-12">
                <Loader :loading="loading"/>
                <div v-if="team" class="flex items-center flex-wrap mb-4">
                    <h1 class="flex items-center mr-4 mb-0">
                        <img src="https://image.flaticon.com/icons/svg/1171/1171856.svg" width="50px"
                             class="inline-block mr-4">
                        {{ team.name }}
                    </h1>
                    <div>
                        <span class="badge badge-warning" v-if="team.is_trial_period">
                            {{ $t('user.team.subscription.trial_ends_at') }} {{ team.subscription.trial_ends_at | moment('DD/MM/YYYY') }}
                        </span>
                        <span class="badge badge-error ml-5" v-if="team.is_cancelled">
                            {{ $t('user.team.subscription.ends_at') }} {{ team.subscription.ends_at | moment('DD/MM/YYYY') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="container px-10">
            <div class="tabs -mt-16 relative" role="tabs">
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
            <router-view/>
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
