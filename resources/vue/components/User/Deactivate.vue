<template>
    <section class="section flex items-center">
        <div class="flex-1">
            <div class="section-header">
                Deactivate account
                <p class="text-gray-600">This will remove your account from all teams and disable your account.</p>
            </div>
        </div>
        <div>
            <button class="btn btn-danger" @click="onDeactivate">
                Deactivate account
            </button>

            <Modal name="deactivate">
                <div class="modal__top">
                    Are you absolutely sure?
                </div>
                <div class="modal__content">
                    <p class="mb-3">This action cannot be undone. This will permanently delete your account and remove
                        all collaborator associations.</p>

                    <p class="mb-3">Please type in your <strong>Email address</strong> to confirm.</p>

                    <FormInput v-model="form.email" label="Email address" name="email" class="w-full" required autofocus/>
                    <button class="btn btn-danger btn-block" :disabled="isDisabledButton" @click="deactivate">
                        I understand the consequences, continue
                    </button>
                </div>
            </Modal>
        </div>
    </section>
</template>

<script>
    import {mapGetters} from 'vuex'
    import FormInput from '@vue/components/Form/Input'
    import Modal from "@vue/components/UI/Modal"

    export default {
        components: {Modal, FormInput},
        data() {
            return {
                form: {
                    email: ''
                }
            }
        },
        methods: {
            onDeactivate() {
                this.$modal.show('deactivate')
            },
            async deactivate() {
                this.loading = true

                try {
                    await this.$api.userProfile.remove(this.form)
                } catch (e) {
                    this.$handleError(e)
                }

                this.loading = false
            }
        },
        computed: {
            ...mapGetters('auth', {
                user: 'getUser',
            }),
            isDisabledButton() {
                return this.user.email != this.form.email;
            }
        }
    }
</script>