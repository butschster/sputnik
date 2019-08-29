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

        <CancelSubscription v-if="!team.subscription.is_invalid" :team="team"/>
    </div>
</template>

<script>
    import CancelSubscription from "@vue/components/User/Teams/CancelSubscription"

    export default {
        components: {CancelSubscription},
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
                if (this.team.subscription.is_invalid) {
                    return false
                }

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
