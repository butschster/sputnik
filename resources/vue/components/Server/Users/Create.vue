<template>
    <section class="section">
        <Loader :loading="loading"/>
        <div class="section-header">
            {{ $t('server.users.form.create.title') }}
            <p>{{ $t('server.users.form.create.description') }}</p>
        </div>
        <div class="flex">
            <FormInput v-model="form.name" :label="$t('server.users.form.create.label.name')" name="name" class="flex-1 mr-8" required autofocus/>
            <FormPassword v-model="form.sudo_password" :label="$t('server.users.form.create.label.password')" name="sudo_password" class="mr-8"/>

            <div class="form-group mb-0">
                <button class="btn btn-primary" @click="onSubmit">
                    {{ $t('server.users.form.create.button.create') }}
                </button>
            </div>
        </div>
    </section>
</template>

<script>
    import FormInput from '@vue/components/Form/Input'
    import FormPassword from '@vue/components/Form/Password'

    export default {
        components: {FormInput, FormPassword},
        props: {
            server: Object
        },
        data() {
            return {
                loading: false,
                form: {
                    name: null,
                    sudo_password: null
                }
            }
        },
        methods: {
            async onSubmit() {
                this.loading = true

                try {
                    const user = await this.$api.serverUsers.store(this.server.id, this.form)
                    this.$emit('created', user)

                    this.$notify.success(
                        this.$t('server.users.form.create.message.created')
                    )

                    this.clear()
                } catch (e) {
                    this.$handleError(e)
                }

                this.loading = false
            },
            clear() {
                this.form = {
                    name: null,
                    sudo_password: null
                }
            }
        }
    }
</script>
