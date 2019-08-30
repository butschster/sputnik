<template>
    <div>
        <div class="alert alert-warning flex justify-between items-center" v-if="$parent.team.subscription.is_invalid">
            <div>
                Your subscription is expired. Please renew it.
            </div>

            <button class="btn btn-danger">Renew</button>
        </div>

        <Subscription :team="$parent.team" />
    </div>
</template>

<script>
    import Subscription from '@vue/components/User/Teams/Subscription'
    export default {
        components: {Subscription}
    }
</script>