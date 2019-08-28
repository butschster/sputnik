<template>
    <div>
        <div class="price-table">
            <h2>Available plans</h2>
            <div class="price-table__items">

                <div class="price-table__item" v-for="plan in plans" :key="plan.id"
                     :class="{'current': isCurrentPlan(plan)}">
                    <div>
                        <h3 class="price-table__item--title">{{ plan.name }}

                            <strong class="ml-3" v-if="!plan.is_free">${{ plan.price }}</strong> <span class="text-xs">/mo</span>
                        </h3>
                        <ul class="price-table__item--features">
                            <li class="price-table__item--feature" v-for="feature in plan.features">
                                <i class="icon fas fa-check-circle "></i> {{ feature.name }}
                                <span v-if="!feature.is_unlimited">[{{ feature.value }} times]</span>
                            </li>
                        </ul>
                    </div>

                    <div class="text-center mt-5" v-if="canBeUpgradedTo(plan)">
                        <button class="btn btn-primary btn-rounded">Order now</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="border-gray-300 bg-gray-100 py-8 px-8 my-12 flex items-center">
            <div class="flex-1">
                <h2>Cancel subscription</h2>
                <p>Pavel, just before you go, here are some courses we've got coming up that you might be interested
                    in.</p>
            </div>
            <div>
                <form action="">
                    <button class="btn btn-danger">
                        Cancel :(
                    </button>
                </form>
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
                plans: [],
                loading: false,
            }
        },
        mounted() {
            this.load()
        },
        methods: {
            async load() {
                this.loading = true

                try {
                    const response = await this.$api('v1.subscription.plans').request()
                    this.plans = response.data.data
                } catch (e) {
                    console.error(e)
                }

                this.loading = false
            },
            isCurrentPlan(plan) {
                return plan.id == this.team.subscription.plan.id
            },
            canBeUpgradedTo(plan) {
                if (this.isCurrentPlan(plan)) {
                    return false
                }

                if (this.team.subscription.plan.key == 'artisan') {
                    return plan.key == 'unlimited'
                }

                return plan.key != 'free'
            }
        }
    }
</script>