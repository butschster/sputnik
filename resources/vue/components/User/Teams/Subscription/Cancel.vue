<template>
    <section class="section">
        <Loader :loading="loading" />
        <div class="flex items-center">
            <div class="flex-1 section-header">
                Cancel subscription
                <p>Pavel, just before you go, here are some courses we've got coming up that you might be interested in.</p>
            </div>
            <div>
                <button class="btn btn-danger-outline" @click="onCancel">
                    Cancel
                </button>

                <Modal name="cancel">
                    <div class="modal__top">
                        Are you absolutely sure?
                    </div>
                    <div class="modal__content">
                        <p class="mb-3">This action cannot be undone. This will permanently delete your account and remove
                            all collaborator associations.</p>

                        <div class="flex">
                            <button class="btn btn-danger-outline mr-5" @click="cancel">
                                Yes
                            </button>
                            <button class="btn btn-default btn-light" @click="close">
                                Close
                            </button>
                        </div>
                    </div>
                </Modal>
            </div>
        </div>
    </section>
</template>

<script>
    import Modal from "@vue/components/UI/Modal";

    export default {
        components: {Modal},
        props: {
            team: Object
        },
        data() {
            return {
                loading: false
            }
        },
        methods: {
            onCancel() {
                this.$modal.show('cancel')
            },
            async cancel() {
                this.loading = true

                try {
                    await this.$api.subscription.cancel(this.team.id)
                    this.$modal.close('cancel')
                } catch (e) {
                    this.$handleError(e)
                }

                this.loading = false
            },
            close() {
                this.$modal.close('cancel')
            }
        }
    }
</script>
