<template>
    <div class="w-full">
        <div class="container px-10">
            <button class="btn btn-default btn-dark" @click="showModal">
                {{ $t('user.profile.buttons.edit') }}
            </button>

            <Modal name="profile-form">
                <Loader :loading="loading"/>
                <div class="modal__top">
                    {{ $t('user.profile.edit_modal.title') }}
                </div>
                <div class="modal__content">
                    <div class="flex">
                        <FormInput v-model="form.name"
                                   :label="$t('user.profile.edit_modal.name')"
                                   name="name"
                                   class="w-full mr-6"
                                   required autofocus/>

                        <FormInput v-model="form.company"
                                   :label="$t('user.profile.edit_modal.company')"
                                   name="company"
                                   class="w-full"/>
                    </div>
                    <FormSelect v-model="form.lang"
                                :label="$t('user.profile.edit_modal.lang')"
                                name="lang"
                                :options="langs"
                                class="w-full"/>

                    <button class="btn btn-danger-outline btn-block" @click="update">
                        {{ $t('user.profile.edit_modal.save') }}
                    </button>
                </div>
            </Modal>
        </div>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex'
    import Modal from "@vue/components/UI/Modal"
    import FormInput from '@vue/components/Form/Input'
    import FormSelect from '@vue/components/Form/Select'

    export default {
        components: {Modal, FormInput, FormSelect},
        data() {
            return {
                loading: false,
                form: {
                    name: '',
                    company: '',
                    lang: ''
                },
                langs: [
                    {
                        label: 'English',
                        value: 'en'
                    },
                    {
                        label: 'Русский',
                        value: 'ru'
                    },
                ]
            }
        },
        methods: {
            showModal() {
                this.$modal.show('profile-form')
            },
            async update() {
                this.loading = true

                try {
                    const user = await this.$api.userProfile.update(this.form)
                    this.$store.commit('auth/setUser', user)

                    this.$modal.close('profile-form')

                } catch (e) {
                    this.$handleError(e)
                }

                this.loading = false
            }
        },
        created() {
            this.form.name = this.user.name
            this.form.company = this.user.company
            this.form.lang = this.user.lang
        },
        computed: {
            ...mapGetters('auth', {
                user: 'getUser',
            })
        }
    }
</script>
