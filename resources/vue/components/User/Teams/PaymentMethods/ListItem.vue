<template>
    <div>
        <Loader :loading="loading" />
        <div class="border-2 px-4 py-3 mb-2 bg-white rounded-lg flex">
            <div class="flex-1">
                <h4>{{ method.name }} xxxx-{{ method.card.last4 }}</h4>
                <div class="text-gray-600">Expired {{ method.card.exp_month }}/{{ method.card.exp_year }} • Created
                    on {{ method.created_at | moment('DD MMM YYYY') }}
                </div>
            </div>
            <button class="btn btn-danger btn-sm" @click="deletePaymentMethod()">
                Delete
            </button>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            team: Object,
            method: Object
        },
        data() {
            return {
                loading: false
            }
        },
        methods: {
            async deletePaymentMethod() {
                this.loading = true

                try {
                    await this.$api.teamBilling.deletePaymentMethod(this.team.id, this.method.id)
                    this.$emit('deleted', this.method)
                } catch (e) {
                    this.$handleError(e)
                }

                this.loading = false
            },
        }
    }
</script>