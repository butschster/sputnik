<template>
    <section class="section">
        <Loader :loading="loading"/>
        <div class="section-header">
            Create a firewall rule
            <p>Enter a domain that you own below and start managing your DNS within your DigitalOcean
                account.</p>
        </div>
        <div class="flex flex-wrap">
            <FormInput v-model="form.name" label="Name" name="name" class="flex-1 mr-8" required autofocus/>
            <FormInputNumber v-model="form.port" label="Port" name="port" class="mr-8 w-48" minlength="2"
                             maxlength="4"
                             required/>
            <FormInput v-model="form.from" label="From" name="from" class="mr-8 w-48" autofocus/>
            <FormSelect v-model="form.policy" label="Policy" name="policy" :options="policy_value"
                        class="mr-8 w-48"
                        required/>


            <div class="form-group mb-0">
                <button class="btn btn-primary" @click="onSubmit">Create</button>
            </div>
        </div>
    </section>

</template>

<script>
    import FormInput from '@vue/components/Form/Input.vue'
    import FormInputNumber from '@vue/components/Form/InputNumber.vue'
    import FormSelect from '@vue/components/Form/Select'

    export default {
        components: {FormInput, FormInputNumber, FormSelect},
        props: {
            server: Object
        },
        data() {
            return {
                loading: false,
                form: {
                    name: null,
                    port: null,
                    from: null,
                    policy: "allow"

                },
                policy_value: [
                    {label: "Allow", value: "allow"},
                    {label: "Deny", value: "deny"}
                ]
            }
        },
        methods: {
            async onSubmit() {
                this.loading = true

                try {
                    const rule = await this.$api.serverFirewall.store(this.server.id, this.form)
                    this.$emit('created', rule)

                    this.$notify.success('Rule successfully create')

                    this.clear()
                } catch (e) {
                    this.$handleError(e)
                }

                this.loading = false
            },
            clear() {
                this.form = {
                    name: null,
                    port: null,
                    from: null,
                    policy: "allow",
                    status: null
                }
            }
        }
    }
</script>
