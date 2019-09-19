<template>
    <section class="section flex items-center">
        <div class="flex-1">
            <div class="section-header">
                {{ $t('user.profile.deactivate.title') }}
                <p class="text-gray-600">
                    {{ $t('user.profile.deactivate.description') }}
                </p>
            </div>
        </div>
        <div>
            <button class="btn btn-danger-outline" @click="onDeactivate">
                {{ $t('user.profile.deactivate.button') }}
            </button>

            <Modal name="deactivate">
                <div class="modal__top">
                    {{ $t('user.profile.deactivate.modal.title') }}
                </div>
                <div class="modal__content">
                    <p class="mb-3">{{ $t('user.profile.deactivate.modal.description') }}</p>

                    <FormInput v-model="form.email" :label="$t('user.profile.deactivate.modal.field')" name="email" class="w-full" required autofocus/>
                    <button class="btn btn-danger-outline btn-block" :disabled="isDisabledButton" @click="deactivate">
                        {{ $t('user.profile.deactivate.modal.button') }}
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
