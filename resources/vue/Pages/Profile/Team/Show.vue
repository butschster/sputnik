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

            <div class="card mb-4">
                <div class="card-header">
                    Payment method
                    <p>This will replace your current payment method.</p>
                </div>
                <div class="card-body">
                    <form action="" class="mt-8">
                        <div class="flex">
                            <div class="form-group flex-1 mr-5">
                                <input type="text" id="card" class="form-control" name="card" autofocus
                                       placeholder="Card number">
                            </div>
                            <div class="form-group mr-5">
                                <input type="text" id="date" class="form-control" name="date"
                                       placeholder="MM/YY">
                            </div>
                            <div class="form-group">
                                <input type="text" id="cvc" class="form-control" name="cvc"
                                       placeholder="CVC">
                            </div>
                        </div>
                        <div class="form-group mt-2">
                            <button class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>


            <Subscription :team="team" />
        </div>
    </div>
</template>

<script>
    import Subscription from '@vue/components/User/Teams/Subscription'
    import Members from '@vue/components/User/Teams/Members'

    export default {
        components: {Members, Subscription},
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