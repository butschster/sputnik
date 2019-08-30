<template>
    <section class="section">
        <Loader :loading="loading"/>
        <div class="section-header">
            Create a new use
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
                    const response = await this.$api('v1.server.user.store', {server: this.server.id}).request(this.form)
                    this.$emit('created', response.data.data)

                    this.$notify({
                        text: 'User successfully create',
                        type: 'success'
                    });

                    this.clear()
                } catch (e) {
                    console.error(e)
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
