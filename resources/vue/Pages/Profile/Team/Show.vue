<template>
    <div>
        <Loader :loading="loading"/>
        <div v-if="team">
            <h1 class="mb-4">
                <i class="fas fa-users mr-3"></i>
                {{ team.name }}
            </h1>

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
                    const response = await this.$api('v1.team.show', {team: this.$route.params.id}).request()
                    this.team = response.data.data
                } catch (e) {
                    console.error(e)
                    this.$router.replace({name: "404"})
                }

                this.loading = false
            }
        },
    }
</script>