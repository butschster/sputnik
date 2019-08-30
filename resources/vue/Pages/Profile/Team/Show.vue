<template>
    <div>
        <Loader :loading="loading"/>
        <div v-if="team">
            <h1 class="mb-4">
                <i class="fas fa-users mr-3"></i>
                {{ team.name }}
            </h1>

            <div class="alert alert-warning flex justify-between items-center" v-if="team.subscription.is_invalid">
                <div>
                    Your subscription is expired. Please renew it.
                </div>

                <button class="btn btn-danger">Renew</button>
            </div>

            <Members :team="team" class="mb-10"/>

            <PaymentMethods :team="team" />

            <Subscription :team="team" />
        </div>
    </div>
</template>

<script>
    import PaymentMethods from "@vue/components/User/Teams/PaymentMethods"
    import Subscription from '@vue/components/User/Teams/Subscription'
    import Members from '@vue/components/User/Teams/Members'

    export default {
        components: {Members, Subscription, PaymentMethods},
        data() {
            return {
                team: null,
                loading: false,
            }
        },
        mounted() {
            this.load()
        },
        methods: {
            loaded() {

            },
            async load() {
                this.loading = true

                try {
                    const response = await this.$api('v1.team.show', {team: this.$route.params.id}).request()
                    this.team = response.data.data
                    this.loaded()
                } catch (e) {
                    console.error(e)
                    this.$router.replace({name: "404"})
                }

                this.loading = false
            }
        },
    }
</script>