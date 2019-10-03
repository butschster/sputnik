<template>
    <section class="section">
        <Loader :loading="loading"/>
        <div class="section-header">
            Create a new one
            <p>You can easily mange databases on your server</p>
        </div>
        <div class="flex">
            <FormInput v-model="form.name" label="Name" name="name" class="flex-1 mr-8" required autofocus/>
            <FormPassword v-model="form.password" label="Password" name="password" class="mr-8"/>

            <div class="form-group mb-0">
                <button class="btn btn-primary" @click="onSubmit">Store</button>
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
                    password: null
                },
                modules: []
            }
        },
        methods: {
            async onSubmit() {
                this.loading = true
                try {
                    const database = await this.$api.mysqlDatabase.store(this.server.id, this.form)
                    this.$emit('created', database)

                    this.$notify.success('Database successfully create')
                    this.clear()
                } catch (e) {
                    this.$handleError(e)
                }
                this.loading = false
            },
            clear() {
                this.form = {
                    name: null,
                    password: null
                }
            }
        },
        computed: {
            modulesOptions() {
                return this.modules.map(m => {
                    return {
                        label: m.title,
                        value: m.id
                    }
                })
            }
        }
    }
</script>
