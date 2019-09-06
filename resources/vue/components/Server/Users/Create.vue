<template>
    <section class="section">
        <Loader :loading="loading"/>
        <div class="section-header">
            Create a new user
            <p>After creating a user you will have public key for auth.</p>
        </div>
        <div class="flex">
            <FormInput v-model="form.name" label="Name" name="name" class="flex-1 mr-8" required autofocus/>
            <FormPassword v-model="form.sudo_password" label="Password" name="sudo_password" class="mr-8"/>

            <div class="form-group mb-0">
                <button class="btn btn-primary" @click="onSubmit">Create</button>
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

                    this.$notify.success('User successfully create')

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
