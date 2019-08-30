<template>
    <section class="section">
        <Loader :loading="loading"/>
        <div class="section-header">
            Create a firewall rule
            <p>Enter a domain that you own below and start managing your DNS within your DigitalOcean account.</p>
        </div>
        <div class="flex">
            <FormInput v-model="form.name" label="Name" name="name" class="flex-1 mr-8" required autofocus/>
            <FormInputNumber v-model="form.port" label="Port" name="port" class="flex-1 mr-8" minlength="2" maxlength="4" required autofocus/>
            <FormInput v-model="form.from" label="From" name="from" class="flex-1 mr-8" autofocus/>
            <FormSelect v-model="form.policy" label="Policy" name="policy" :options="policy_value"  class="flex-1 mr-8"required autofocus/>

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
                    policy: null

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
                    const response = await this.$api('v1.server.firewall.store', {server: this.server.id}).request(this.form)
                    this.$emit('created', response.data.data)
                    console.log(response)

                    this.$notify({
                        text: 'Rule successfully create',
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
                    port: null,
                    from: null,
                    policy: null,
                    status: null
                }
            }
        }
    }
</script>
