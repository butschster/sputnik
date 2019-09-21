<template>
    <section class="section">
        <Loader :loading="loading"/>
        <div class="section-header">
            {{ $t('server.firewall.form.create.title') }}
        </div>
        <div class="flex flex-wrap md:flex-wrap">
            <FormInput v-model="form.name"
                       :label="$t('server.firewall.form.create.label.name')"
                       name="name"
                       class="flex-1 mr-8"
                       required
                       autofocus/>

            <FormInputNumber v-model="form.port"
                             :label="$t('server.firewall.form.create.label.port')"
                             name="port"
                             class="mr-8 w-48"
                             minlength="2"
                             maxlength="4"
                             required/>
            <FormInput v-model="form.from"
                       :label="$t('server.firewall.form.create.label.from')"
                       name="from"
                       class="mr-8 w-48"
                       autofocus/>
            <FormSelect v-model="form.policy"
                        :label="$t('server.firewall.form.create.label.policy')"
                        name="policy"
                        :options="policies"
                        class="mr-8 w-48"
                        required/>

            <div class="form-group mb-0">
                <button class="btn btn-primary" @click="onSubmit">
                    {{ $t('server.firewall.form.create.button.create') }}
                </button>
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

                }
            }
        },
        methods: {
            async onSubmit() {
                this.loading = true

                try {
                    const rule = await this.$api.serverFirewall.store(this.server.id, this.form)
                    this.$emit('created', rule)

                    this.$notify.success(this.$t('server.firewall.message.created'))

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
        },
        computed: {
            policies() {
                return [
                    {
                        label: "Allow",
                        value: "allow"
                    },
                    {
                        label: "Deny",
                        value: "deny"
                    }
                ]
            }
        }
    }
</script>
