<template>
    <div>
        <Loader :loading="loading" />
        <div class="border-red-300 border-2 bg-gray-100 py-8 px-8 my-12 flex items-center">
            <div class="flex-1">
                <h2>Cancel subscription</h2>
                <p>Pavel, just before you go, here are some courses we've got coming up that you might be interested in.</p>
            </div>
            <div>
                <button class="btn btn-danger" @click="onCancel">
                    Cancel :(
                </button>

                <Modal name="cancel">
                    <div class="modal__top">
                        Are you absolutely sure?
                    </div>
                    <div class="modal__content">
                        <p class="mb-3">This action cannot be undone. This will permanently delete your account and remove
                            all collaborator associations.</p>

                        <div class="flex">
                            <button class="btn btn-danger mr-5" @click="cancel">
                                Yes
                            </button>
                            <button class="btn btn-default" @click="close">
                                Close
                            </button>
                        </div>
                    </div>
                </Modal>
            </div>
        </div>
    </div>
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
                    await this.$api('v1.team.subscription.cancel', {team: this.team.id}).request()
                    this.$modal.close('cancel')
                } catch (e) {
                    console.error(e)
                }

                this.loading = false
            },
            close() {
                this.$modal.close('cancel')
            }
        }
    }
</script>
