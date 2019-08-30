<template>
    <PaymentMethods :team="$parent.team" />
</template>

<script>
    import PaymentMethods from "@vue/components/User/Teams/PaymentMethods/List"
    export default {
        components: {PaymentMethods}
    }
</script>