<template>
    <div>
        <div class="price-table">
            <Loader :loading="loading"/>
            <h2>Available plans</h2>

            <div class="well border-red-300 border-2 rounded-lg mb-8 text-lg" v-if="!hasPaymentMethod">
                You need to add payment method on <router-link :to="{name: 'profile.team.billing', params: {id: team.id }}">billing page</router-link>
            </div>

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
                        <button class="btn btn-primary btn-rounded" @click="subscribe(plan)">
                            Subscribe now
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Modal from "@vue/components/UI/Modal"

    export default {
        components: {Modal},
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
        computed: {
            hasPaymentMethod() {
                return this.team.has_payment_method
            }
        },
        methods: {
            async subscribe(plan) {
                this.loading = true

                try {
                    await this.$api.subscription.subscribe(this.team.id, plan.id)
                    this.$bus.$emit('subscribed')
                } catch (e) {
                    this.$handleError(e)
                }

                this.loading = false
            },
            async load() {
                this.loading = true

                try {
                    this.plans = await this.$api.subscription.plans()
                } catch (e) {
                    this.$handleError(e)
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
                if (!this.hasPaymentMethod) {
                    return false
                }

                if (this.isCurrentPlan(plan)) {
                    return false
                }

                if (this.team.subscription.plan.key == 'artisan') {
                    return plan.key == 'unlimited'
                }

                if (this.team.subscription.plan.key == 'unlimited') {
                    return false
                }

                return plan.key != 'free'
            }
        }
    }
</script>
