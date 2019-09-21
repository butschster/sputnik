<template>
    <div>

            <div class="alert alert-warning flex justify-between items-center" v-if="team.subscription.is_invalid">
                <div>
                    Your subscription is expired. Please renew it.
                </div>

                <button class="btn btn-danger-outline">Renew</button>
            </div>

            <SubscriptionPlans :team="team" class="section--border-b"/>
            <CancelSubscription v-if="canBeCanceled" :team="team"/>
            <ResumeSubscription v-if="canBeResumed" :team="team"/>

    </div>
</template>

<script>
    import ResumeSubscription from "@vue/components/User/Teams/Subscription/Resume"
    import CancelSubscription from "@vue/components/User/Teams/Subscription/Cancel"
    import SubscriptionPlans from '@vue/components/User/Teams/Subscription/Plans'

    export default {
        components: {CancelSubscription, ResumeSubscription, SubscriptionPlans},
        computed: {
            canBeCanceled() {
                if (this.team.subscription.plan.is_free) {
                    return false
                }

                return !this.team.subscription.is_cancelled
            },
            canBeResumed() {
                return this.team.subscription.is_cancelled
            },
            team() {
                return this.$parent.team
            }
        },
    }
</script>
