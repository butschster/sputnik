<template>
    <div>
        <div class="price-table">
            <Loader :loading="loading"/>
            <div class="price-table__bg">
                <h2>Available plans</h2>

                <div class="well border-red-300 border-2 rounded-lg mb-12 text-lg" v-if="!hasPaymentMethod">
                    You need to add payment method on
                    <router-link :to="$link.profileTeamBilling(team)">billing page</router-link>
                </div>
            </div>
            <div class="price-table__items">
                <div class="price-table__item" v-for="plan in plans" :key="plan.id"
                     :class="{'current': isCurrentPlan(plan)}">
                    <div>
                        <p class="price-table__item--badge" v-if="isCurrentPlan(plan)">Popular</p>
                        <h3 class="price-table__item--title">{{ plan.name | capitalize }}</h3>
                        <div class="h-12">
                            <p class="w-full text-center price-table__item--price" v-if="!plan.is_free">
                                &#36; <strong class="text-5xl text-bold ml-1"> {{ plan.price }} </strong>/mo
                            </p>
                        </div>
                    </div>

                    <ul class="price-table__item--features">
                        <li class="price-table__item--feature" v-for="feature in plan.features">
                            <i class="icon fas fa-check-circle "></i> {{ feature.name }}
                            <span v-if="!feature.is_unlimited"
                                  class="font-normal">[{{ feature.value }} times]</span>
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

        filters: {
            capitalize (value) {
                if (!value) return ''
                value = value.toString()
                return value.charAt(0).toUpperCase() + value.slice(1)
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
