<template>
    <Modal name="add_payment_method" @visible="onStateChanged">
        <div class="modal__top">
            Add new card
        </div>
        <div class="modal__content">
            <Loader :loading="loading"/>
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
    </Modal>
</template>

<script>
    import Modal from "@vue/components/UI/Modal"

    export default {
        components: {Modal},

        props: {
            team: Object,
        },
        data() {
            return {
                loading: false,
                secret: null,
                card_holder: null,
                stripeError: null
            }
        },
        methods: {
            onStateChanged(state) {
                if (state) {
                    this.intent()
                }
            },
            initStripe() {
                const elements = this.$stripe.elements();
                this.cardElement = elements.create('card');

                this.cardElement.mount('#card-element');
            },
            async addPaymentMethod(e) {
                this.loading = true

                this.stripeError = null
                const {setupIntent, error} = await this.$stripe.handleCardSetup(
                    this.secret, this.cardElement, {
                        payment_method_data: {
                            billing_details: {name: this.card_holder}
                        }
                    }
                );

                if (error) {
                    this.stripeError = error
                    this.$emit('error', error)
                } else {
                    const response = await this.$api('v1.team.payment.method.store', {team: this.team.id}).request(setupIntent)
                    this.secret = null
                    this.$emit('added', response.data)
                    this.$modal.close('add_payment_method')

                    this.$notify({
                        type: 'success',
                        text: 'Payment method successfully added'
                    })
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
        },
        computed: {
            hasSecret() {
                return this.secret && this.secret.length > 0
            },
            hasStripeError() {
                return this.stripeError !== null
            }
        }
    }
</script>