<template>
    <section class="section">
        <Loader :loading="loading"/>
        <div class="section-header">
            Add a new client
        </div>
        <div class="flex">
            <FormInput v-model="form.name" label="Name" name="name" class="flex-1 mr-8" required autofocus/>

            <div class="form-group mb-0">
                <button class="btn btn-primary" @click="onSubmit">Create</button>
            </div>
        </div>
    </section>
</template>

<script>
    import FormInput from '@vue/components/Form/Input'

    export default {
        components: {FormInput},
        props: {
            server: Object
        },
        data() {
            return {
                loading: false,
                form: {
                    name: null,
                }
            }
        },
        methods: {
            async onSubmit() {
                this.loading = true

                try {
                    const user = await this.$api.serverOpenVPNClients.store(this.server.id, this.form)
                    this.$emit('created', user)

                    this.$notify.success('Client successfully created')

                    this.clear()
                } catch (e) {
                    this.$handleError(e)
                }

                this.loading = false
            },
            clear() {
                this.form = {
                    name: null,
                }
            }
        }
    }
</script>
