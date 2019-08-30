<template>
    <section class="section">
        <Loader :loading="loading"/>
        <div class="section-header flex items-center">
            <div class="flex-1">
                Payment methods
                <p>Please enter your preferred payment method below. You can use a credit / debit card.</p>
            </div>

            <button class="btn btn-primary" @click="intent" v-if="!hasSecret">
                Add
            </button>
        </div>

        <div v-if="!hasPaymentMethod" class="well well-lg text-center">
            <img class="mx-auto mb-10" src="https://image.flaticon.com/icons/svg/1421/1421309.svg" alt="" width="100px">
            <h3 class="mb-0">
                Looks like you don't have any payment methods :(
            </h3>
        </div>
        <div v-else class="well well-lg">

            <div v-for="method in paymentMethods" class="border-2 px-4 py-3 mb-2 bg-white rounded-lg flex">
                <div class="flex-1">
                    <h4>{{ method.name }} xxxx-{{ method.card.last4 }}</h4>
                    <div class="text-gray-600">Expired {{ method.card.exp_month }}/{{ method.card.exp_year }} • Created
                        on {{ method.created_at | moment('DD MMM YYYY') }}
                    </div>
                </div>
                <button class="btn btn-danger btn-sm" @click="deletePaymentMethod(method)">
                    Delete
                </button>
            </div>
        </div>

        <div class="well well-lg mt-5" v-if="hasSecret">
            <h3>Add new card</h3>
            <p class="text-lg mb-3">All major credit / debit cards accepted.</p>
            <div class="flex items-start">
                <div class="form-group is-required flex-1">
                    <div class="form-control">
                        <div id="card-element" class="pt-1"></div>
                    </div>
                    <div class="invalid-feedback" v-if="hasStripeError">
                        {{ stripeError.message }}
                    </div>
                </div>
                <div class="form-group form-group-labeled ml-8 is-required">
                    <input v-validate="'required'" id="card-holder-name" type="text" v-model="card_holder"
                           name="card_holder" class="form-control" placeholder="Card Holder">
                    <label for="card-holder-name">Card Holder</label>
                    <span class="invalid-feedback">{{ errors.first('card_holder') }}</span>
                </div>
            </div>

            <button class="btn btn-primary mt-6" :data-secret="secret" @click="addPaymentMethod">
                Add
            </button>
        </div>
    </section>
</template>

<script>
    export default {
        props: {
            team: Object
        },
        data() {
            return {
                loading: false,
                secret: null,
                paymentMethods: [],
                card_holder: null,
                stripeError: null
            }
        },
        mounted() {
            this.loadPaymentMethods()
        },
        methods: {
            async deletePaymentMethod(method) {
                this.loading = true

                try {
                    const response = await this.$api('v1.team.payment.method.delete', {team: this.team.id, id: method.id}).request()
                } catch (e) {
                    console.error(e)
                }

                this.loading = false
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
            async intent() {
                this.loading = true

                try {
                    const response = await this.$api('v1.team.payment.method.intent', {team: this.team.id}).request()
                    this.secret = response.data

                    setTimeout(() => {
                        this.initStripe()

                    }, 200)

                } catch (e) {
                    console.error(e)
                }

                this.loading = false
            },
            initStripe() {
                const elements = this.$stripe.elements();
                this.cardElement = elements.create('card');

                this.cardElement.mount('#card-element');
            },
            async addPaymentMethod(e) {
                this.stripeError = null
                const {setupIntent, error} = await this.$stripe.handleCardSetup(
                    this.secret, this.cardElement, {
                        payment_method_data: {
                            billing_details: {name: this.card_holder}
                        }
                    }
                );

                console.log(setupIntent)
                if (error) {
                    this.stripeError = error
                } else {
                    const response = await this.$api('v1.team.payment.method.store', {team: this.team.id}).request(setupIntent)
                    this.secret = null
                }
            }
        },
        computed: {
            hasPaymentMethod() {
                return this.paymentMethods.length > 0
            },
            hasSecret() {
                return this.secret && this.secret.length > 0
            },
            hasStripeError() {
                return this.stripeError !== null
            }
        }
    }
</script>