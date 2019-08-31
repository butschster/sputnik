<template>
    <section class="section">
        <Loader :loading="loading"/>
        <div class="section-header flex items-center">
            <div class="flex-1">
                Payment methods
                <p>Please enter your preferred payment method below. You can use a credit / debit card.</p>
            </div>

            <button class="btn btn-primary" @click="showForm" v-if="!loading && !hasPaymentMethod">
                Add
            </button>

            <AddMethodForm :team="team" @added="paymentMethodsChanged"/>
        </div>

        <div v-if="!hasPaymentMethod" class="well well-lg text-center">
            <img class="mx-auto mb-10" src="https://image.flaticon.com/icons/svg/1421/1421309.svg" alt="" width="100px">
            <h3 class="mb-0">
                Looks like you don't have any payment methods :(
            </h3>
        </div>
        <div v-else class="well well-lg">
            <ListItem v-for="method in paymentMethods"
                      :team="team"
                      :method="method"
                      :key="method.id"
                      @deleted="paymentMethodsChanged"
            />
        </div>
    </section>
</template>

<script>
    import ListItem from "@vue/components/User/Teams/PaymentMethods/ListItem"
    import AddMethodForm from "@vue/components/User/Teams/PaymentMethods/AddMethodForm"
    export default {
        components: {AddMethodForm, ListItem},
        props: {
            team: Object
        },
        data() {
            return {
                loading: false,
                paymentMethods: [],
            }
        },
        mounted() {
            this.loadPaymentMethods()
        },
        methods: {
            paymentMethodsChanged() {
                this.loadPaymentMethods()
                this.$bus.$emit('paymentMethodsChanged')
            },
            showForm() {
                this.$modal.show('add_payment_method')
            },
            async loadPaymentMethods() {
                this.loading = true

                try {
                    const response = await this.$api('v1.team.payment.methods', {team: this.team.id}).request()
                    this.paymentMethods = response.data
                } catch (e) {
                    console.error(e)
                }

                this.loading = false
            },
        },
        computed: {
            hasPaymentMethod() {
                return this.paymentMethods.length > 0
            },
        }
    }
</script>